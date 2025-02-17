class ChatHandler {
  constructor(userId, lastMessageTime) {
    this.userId = userId;
    this.lastMessageTime = lastMessageTime;
    this.pollInterval = 2000;
    this.retryInterval = 5000;
    this.processedMessageIds = new Set();
    this.isPolling = false;
    this.initEmojiPicker();
  }

  startPolling() {
    if (!this.isPolling) {
      this.isPolling = true;
      this.pollMessages();
    }
  }

  stopPolling() {
    this.isPolling = false;
  }

  pollMessages() {
    if (!this.isPolling) return;

    $.ajax({
      url: "/app/check-new-messages",
      type: "GET",
      data: {
        userId: this.userId,
        lastMessageTime: this.lastMessageTime,
      },
      success: (response) => {
        if (response.success) {
          const newMessageIds = response.messageIds.filter(
            (id) => !this.processedMessageIds.has(id)
          );

          // Play notification if not on messages page
          if (
            window.location.pathname !== "/app/messages" &&
            newMessageIds.length > 0
          ) {
            this.playNotification();
          }
          if (newMessageIds.length > 0) {
            $("#chat-messages").append(response.html);
            this.scrollToBottom();
            this.lastMessageTime = response.lastMessageTime;
            newMessageIds.forEach((id) => this.processedMessageIds.add(id));
          }
        }
        if (this.isPolling) {
          setTimeout(() => this.pollMessages(), this.pollInterval);
        }
      },
      error: () => {
        if (this.isPolling) {
          setTimeout(() => this.pollMessages(), this.retryInterval);
        }
      },
    });
  }

  scrollToBottom() {
    const container = $(".messaging-custom-scrollbar");
    if (container.length) {
      container.scrollTop(container[0].scrollHeight);
    }
  }

  initEmojiPicker() {
    const emojiIcon = document.getElementById("emoji-icon");
    const emojiPicker = document.getElementById("emoji-picker");
    const messageInput = document.getElementById("message-input");

    if (!emojiIcon || !emojiPicker || !messageInput) {
      console.error("Emoji picker elements not found");
      return;
    }

    // Toggle emoji picker
    emojiIcon.addEventListener("click", () => {
      emojiPicker.style.display =
        emojiPicker.style.display === "none" ? "block" : "none";
    });

    // Handle emoji selection
    emojiPicker.addEventListener("emoji-click", (event) => {
      const emoji = event.detail.unicode;
      const cursorPos = messageInput.selectionStart;
      const text = messageInput.value;
      messageInput.value =
        text.slice(0, cursorPos) + emoji + text.slice(cursorPos);
      messageInput.focus();
      emojiPicker.style.display = "none";
    });

    // Close picker when clicking outside
    document.addEventListener("click", (event) => {
      if (!emojiPicker.contains(event.target) && event.target !== emojiIcon) {
        emojiPicker.style.display = "none";
      }
    });
  }
}

window.initChat = function (userId, lastMessageTime) {
  window.chatHandler = new ChatHandler(userId, lastMessageTime);
  window.chatHandler.startPolling();
};

window.destroyChat = function () {
  if (window.chatHandler) {
    window.chatHandler.stopPolling();
    window.chatHandler = null;
  }
};

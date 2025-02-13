class ChatHandler {
  constructor(userId, lastMessageTime) {
    this.userId = userId;
    this.lastMessageTime = lastMessageTime;
    this.pollInterval = 2000;
    this.retryInterval = 5000;
    this.processedMessageIds = new Set();
    this.isPolling = false;
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

class NotificationHandler {
  constructor() {
    this.pollInterval = 3000;
    this.retryInterval = 5000;
    this.isPolling = false;
    this.lastCheckTime = new Date().toISOString();
    this.processedMessageIds = new Set();
  }

  startPolling() {
    if (!this.isPolling) {
      this.isPolling = true;
      this.pollNotifications();
    }
  }

  stopPolling() {
    this.isPolling = false;
  }

  pollNotifications() {
    if (!this.isPolling) return;

    $.ajax({
      url: "/app/check-notifications",
      type: "GET",
      data: {
        lastCheckTime: this.lastCheckTime,
      },
      success: (response) => {
        if (response.success && response.newMessages.length > 0) {
          const newMessageIds = response.newMessages.filter(
            (msg) => !this.processedMessageIds.has(msg.id)
          );

          if (
            window.location.pathname !== "/app/messages" &&
            newMessageIds.length > 0
          ) {
            this.showNotification(newMessageIds[0]);
          }

          newMessageIds.forEach((msg) => this.processedMessageIds.add(msg.id));
          this.lastCheckTime = response.currentTime;
        }

        if (this.isPolling) {
          setTimeout(() => this.pollNotifications(), this.pollInterval);
        }
      },
      error: (xhr, status, error) => {
        console.error("Notification polling error:", status, error);
        if (this.isPolling) {
          setTimeout(() => this.pollNotifications(), this.retryInterval);
        }
      },
    });
  }

  showNotification(message) {
    Toastify({
      text: `New message from ${message.sender}`,
      duration: 5000,
      close: true,
      gravity: "bottom",
      position: "right",
      stopOnFocus: true,
      className: "message-toast",
      onClick: function () {
        window.location.href = "/app/messages";
      },
      style: {
        background: "linear-gradient(to right, #5a5fe6, #4448c9)",
        borderRadius: "8px",
        padding: "12px 24px",
        boxShadow: "0 4px 12px rgba(0, 0, 0, 0.15)",
        cursor: "pointer",
      },
    }).showToast();
  }
}

// Initialize notification handler when document is ready
$(document).ready(() => {
  if (typeof Toastify !== "undefined") {
    window.notificationHandler = new NotificationHandler();
    window.notificationHandler.startPolling();
  } else {
    console.error("Toastify is not loaded");
  }
});

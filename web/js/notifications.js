$(document).ready(function () {
  // Long polling for notifications
  function pollNotifications() {
    let lastNotificationId = $(".notification-item")
      .first()
      .data("notification-id");

    function poll() {
      $.ajax({
        url: "/app/check-new-notifications",
        data: { lastNotificationId: lastNotificationId },
        success: function (response) {
          if (response.success) {
            $(".notifications-container").prepend(response.html);
            lastNotificationId = response.lastNotificationId;
          }
        },
        complete: function () {
          setTimeout(poll, 5000);
        },
      });
    }
    poll();
  }

  // Start polling
  pollNotifications();
});

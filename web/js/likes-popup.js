document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".like-count").forEach((element) => {
    tippy(element, {
      content: "Loading...",
      trigger: "mouseenter",
      interactive: true,
      theme: "nexus",
      animation: "scale",
      arrow: true,
      placement: "top",
      allowHTML: true,
      onShow(instance) {
        const postId = element.dataset.postId;
        const likesUrl = element.dataset.likesUrl; // Get the URL from data attribute

        instance.setContent(`
          <div class="likes-loading">
            <i class='bx bx-loader-alt bx-spin'></i>
            <span>Loading...</span>
          </div>
        `);

        $.ajax({
          url: likesUrl, // Use the generated URL
          method: "GET",
          dataType: "json",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
          xhrFields: {
            withCredentials: true,
          },
          success: function (data) {
            console.log("AJAX success:", data);

            if (!data.success) {
              throw new Error(data.error || "Failed to load likes");
            }

            if (!data.likes.length) {
              instance.setContent(
                '<div class="likes-empty">No likes yet</div>'
              );
              return;
            }

            const content = `
              <div class="likes-list">
                ${data.likes
                  .map(
                    (user) => `
                    <div class="like-user">${user.fullname}</div>
                  `
                  )
                  .join("")}
              </div>
            `;

            instance.setContent(content);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", textStatus, errorThrown);
            console.log("Response Text:", jqXHR.responseText);
            instance.setContent(
              '<div class="likes-error">Failed to load likes</div>'
            );
          },
        });
      },
    });
  });
});

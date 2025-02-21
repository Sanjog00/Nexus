document.addEventListener("DOMContentLoaded", function () {
  // Hide all modals on page load
  document.querySelectorAll(".share-modal").forEach((modal) => {
    modal.style.display = "none";
    modal.classList.remove("active");
  });
});

function openShareModal(postId) {
  const modal = document.getElementById(`shareModal${postId}`);
  if (modal) {
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";
  }
}

function closeShareModal(postId) {
  const modal = document.getElementById(`shareModal${postId}`);
  if (modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
  }
}

function copyShareLink(postId) {
  const linkInput = document.getElementById(`shareLink${postId}`);
  linkInput.select();
  document.execCommand("copy");

  // Show toast notification
  Toastify({
    text: "Link copied to clipboard!",
    duration: 3000,
    gravity: "bottom",
    position: "center",
    backgroundColor: "#0095f6",
  }).showToast();
}

function searchFriends(query, postId) {
  const friendsList = document.getElementById(`friendsList${postId}`);
  const friends = friendsList.getElementsByClassName("friend-item");

  Array.from(friends).forEach((friend) => {
    const name = friend.querySelector(".friend-name").textContent.toLowerCase();
    const username = friend
      .querySelector(".friend-username")
      .textContent.toLowerCase();

    if (
      name.includes(query.toLowerCase()) ||
      username.includes(query.toLowerCase())
    ) {
      friend.style.display = "";
    } else {
      friend.style.display = "none";
    }
  });
}

function sharePostToFriends(postId) {
  const modal = document.getElementById(`shareModal${postId}`);
  const selectedFriends = Array.from(
    modal.querySelectorAll(".friend-checkbox:checked")
  ).map((checkbox) => checkbox.value);

  if (selectedFriends.length === 0) {
    Toastify({
      text: "Please select at least one friend",
      duration: 3000,
      gravity: "bottom",
      position: "center",
      backgroundColor: "#ff4444",
    }).showToast();
    return;
  }

  // Create form data
  const formData = new FormData();
  formData.append("postId", postId);
  selectedFriends.forEach((friendId) => {
    formData.append("friendIds[]", friendId);
  });

  // Get CSRF token
  const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

  // Send request
  fetch("/app/share-post", {
    method: "POST",
    body: formData,
    headers: {
      "X-CSRF-Token": csrfToken,
      "X-Requested-With": "XMLHttpRequest",
    },
    credentials: "same-origin",
  })
    .then((response) => {
      if (!response.ok) {
        return response.text().then((text) => {
          throw new Error(text || "Network response was not ok");
        });
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        Toastify({
          text: data.message || "Post shared successfully!",
          duration: 3000,
          gravity: "bottom",
          position: "center",
          backgroundColor: "#0095f6",
        }).showToast();
        closeShareModal(postId);
      } else {
        throw new Error(data.message || "Failed to share post");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Toastify({
        text: error.message || "Failed to share post",
        duration: 3000,
        gravity: "bottom",
        position: "center",
        backgroundColor: "#ff4444",
      }).showToast();
    });
}

// Close modal when clicking outside
document.addEventListener("click", function (event) {
  if (event.target.classList.contains("share-modal")) {
    const postId = event.target.id.replace("shareModal", "");
    closeShareModal(postId);
  }
});

// Prevent modal close when clicking inside modal content
document.addEventListener("click", function (event) {
  if (event.target.closest(".share-modal-content")) {
    event.stopPropagation();
  }
});

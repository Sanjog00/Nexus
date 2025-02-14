let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let sidebarLinks = document.querySelectorAll(".nav-list li");

let isFeedActive = false;

closeBtn.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  menuBtnChange();
});

// Close sidebar and set active class on link click (excluding the menu button)
sidebarLinks.forEach((link) => {
  link.addEventListener("click", (event) => {
    // Skip action if the clicked link contains the menu button (closeBtn)
    if (link.contains(closeBtn)) return;

    // Close the sidebar and set active class on the clicked item
    sidebar.classList.remove("open");
    menuBtnChange();
    // Remove active class from all items, add it to the clicked one
    sidebarLinks.forEach((item) => item.classList.remove("active"));
    link.classList.add("active");

    console.log(link.classList);
  });
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
  } else {
    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const navList = document.querySelector(".nav-list");

  // Event delegation for tab links
  navList.addEventListener("click", function (event) {
    const target = event.target.closest("a[data-section]");
    if (target) {
      // Remove active class from all tab links
      navList
        .querySelectorAll("li")
        .forEach((li) => li.classList.remove("active"));

      // Add active class to the clicked tab link
      target.parentElement.classList.add("active");
    }
  });

  // Set the active class based on the current URL
  function setActiveTab() {
    const currentPath = window.location.pathname;
    navList.querySelectorAll("a[data-section]").forEach((link) => {
      if (link.getAttribute("href") === currentPath) {
        link.parentElement.classList.add("active");
      } else {
        link.parentElement.classList.remove("active");
      }
    });
  }

  setActiveTab();
  window.addEventListener("popstate", setActiveTab);
});

// Close sidebar when clicking outside
document.addEventListener("click", (event) => {
  // Check if the click is outside of the sidebar and the menu button
  if (!sidebar.contains(event.target) && event.target !== closeBtn) {
    sidebar.classList.remove("open");
    menuBtnChange();
  }
});

function openModal() {
  document.getElementById("settingsModal").style.display = "block";
}

// Function to close the modal
function closeModal() {
  document.getElementById("settingsModal").style.display = "none";
}

// Function to handle tab switching
function openTab(tabId) {
  // Remove the 'active' class from all tabs and tab buttons
  document
    .querySelectorAll(".tab-content")
    .forEach((tab) => tab.classList.remove("active"));
  document
    .querySelectorAll(".tab-button")
    .forEach((button) => button.classList.remove("active"));

  // Add the 'active' class to the selected tab and tab button
  document.getElementById(tabId).classList.add("active");
  document
    .querySelector(`[onclick="openTab('${tabId}')"]`)
    .classList.add("active");
}

// Initialize the modal by setting the default tab (Profile Edit) as active
document.addEventListener("DOMContentLoaded", () => {
  openTab("profileEditTabContent");
});

// Example trigger for opening the modal (can be connected to a settings button in your UI)
document
  .querySelector('a[data-section="settings"]')
  .addEventListener("click", (event) => {
    event.preventDefault();
    openModal();
  });

// Close the modal when clicking outside the modal content
window.onclick = (event) => {
  const modal = document.getElementById("settingsModal");
  if (event.target === modal) {
    closeModal();
  }
};

document.addEventListener("DOMContentLoaded", () => {
  const emojiIcon = document.getElementById("emoji-icon");
  const emojiPicker = document.getElementById("emoji-picker");
  const messageInput = document.getElementById("message-input");

  // Toggle emoji picker
  emojiIcon.addEventListener("click", () => {
    const isHidden = emojiPicker.style.display === "none";
    emojiPicker.style.display = isHidden ? "block" : "none";
  });

  // Handle emoji selection
  emojiPicker.addEventListener("emoji-click", (event) => {
    const emoji = event.detail.unicode;
    const cursorPosition = messageInput.selectionStart;
    const textBeforeCursor = messageInput.value.substring(0, cursorPosition);
    const textAfterCursor = messageInput.value.substring(cursorPosition);

    messageInput.value = textBeforeCursor + emoji + textAfterCursor;
    messageInput.focus();

    // Hide picker after selection
    emojiPicker.style.display = "none";
  });

  // Close emoji picker when clicking outside
  document.addEventListener("click", (event) => {
    if (!emojiPicker.contains(event.target) && event.target !== emojiIcon) {
      emojiPicker.style.display = "none";
    }
  });
});

<div id="settingsModal" class="modal">
    <div id="settingsModalContent" class="modal-content">

        <span id="settingsModalCloseButton" class="close-btn" onclick="closeModal()">&times;</span>


        <div id="settingsTopTabs" class="top-tabs">
            <button id="profileEditTabButton" class="tab-button active" onclick="openTab('profileEditTabContent')">Profile</button>
            <button id="notificationEditTabButton" class="tab-button" onclick="openTab('notificationEditTabContent')">Notifications</button>
            <button id="passwordSecurityTabButton" class="tab-button" onclick="openTab('passwordSecurityTabContent')">Security</button>
        </div>


        <div id="settingsContentWrapper">
            <!-- Profile Edit Tab Content -->
            <div id="profileEditTabContent" class="tab-content active">
                <h3>Profile Edit</h3>

                <!-- Profile Picture and Change Button -->
                <div id="profilePictureCard" class="profile-card">
                    <img id="profilePictureImage" src="images/profile.png" alt="Profile Picture" class="profile-img" />
                    <button id="changeProfilePictureButton" class="change-profile-btn">Change Picture</button>
                </div>

                <!-- Profile Fields -->
                <div class="form-group">
                    <label for="profileNameInput">Profile Name</label>
                    <input type="text" id="profileNameInput" value="Jon Snow" placeholder="Enter your full name" />
                </div>

                <div class="form-group">
                    <label for="usernameInput">Username</label>
                    <input type="text" id="usernameInput" value="@jon112" disabled />
                </div>

                <div class="form-group">
                    <label for="birthdayInput">Birthday</label>
                    <input type="date" id="birthdayInput" value="2000-01-01" />
                </div>

                <div class="form-group">
                    <label for="aboutTextarea">About (Bio)</label>
                    <textarea id="aboutTextarea" placeholder="Tell us a bit about yourself...">Discuss only during work hours, unless you want to discuss music 🎶</textarea>
                </div>

                <!-- Save Button for Profile Tab -->
                <button id="profileSaveButton" class="save-btn">Save Changes</button>
            </div>

            <!-- Notification Edit Tab Content -->
            <div id="notificationEditTabContent" class="tab-content">
                <h3>Notification Settings</h3>

                <!-- Notification Options -->
                <div class="notification-option">
                    <label for="messageNotificationsToggle">Message Notifications</label>
                    <label class="switch">
                        <input type="checkbox" id="messageNotificationsToggle" checked>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="notification-option">
                    <label for="friendRequestNotificationsToggle">Friend Request Notifications</label>
                    <label class="switch">
                        <input type="checkbox" id="friendRequestNotificationsToggle" checked>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="notification-option">
                    <label for="commentNotificationsToggle">Comment Notifications</label>
                    <label class="switch">
                        <input type="checkbox" id="commentNotificationsToggle">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="notification-option">
                    <label for="likeNotificationsToggle">Like Notifications</label>
                    <label class="switch">
                        <input type="checkbox" id="likeNotificationsToggle">
                        <span class="slider round"></span>
                    </label>
                </div>


                <button id="notificationSaveButton" class="save-btn">Save Notification Preferences</button>
            </div>


            <div id="passwordSecurityTabContent" class="tab-content">
                <h3>Password & Security</h3>
                <div class="form-group">
                    <label for="currentPasswordInput">Current Password</label>
                    <input type="password" id="currentPasswordInput" placeholder="Enter current password" />
                </div>
                <div class="form-group">
                    <label for="newPasswordInput">New Password</label>
                    <input type="password" id="newPasswordInput" placeholder="Enter new password" />
                </div>
                <div class="form-group">
                    <label for="confirmNewPasswordInput">Confirm New Password</label>
                    <input type="password" id="confirmNewPasswordInput" placeholder="Confirm new password" />
                </div>


                <button id="passwordSaveButton" class="save-btn">Reset Password</button>
            </div>
        </div>
    </div>
</div>
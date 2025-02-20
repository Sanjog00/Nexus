<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;


AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">


<head>
    <link rel="stylesheet" href="<?= Url::to('@web/css/styles.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/feed.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/find-friends.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/message.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/profile-friend.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/style-friends.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/style-notifications.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/css/settings.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/css/emoji-picker.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>


    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title>Nexus</title>

    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-left">
                <div class='app-name' onclick="window.location.href='<?= Url::to(['/app/feed']) ?>'" style="cursor: pointer;">Nexus</div>

            </div>
            <ul class="navbar-right">
                <li>
                    <?= Html::a(
                        Html::img(Html::encode(Yii::$app->user->identity->profile_picture), ['alt' => 'Profile', 'class' => 'profile-icon']),
                        ['/app/profile-view', 'username' => Yii::$app->user->identity->username],
                        ['class' => 'profile-link']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-details">
            <div class="logo_name"><?= Html::encode(Yii::$app->user->identity->fullname) ?></div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="<?= Url::to(['app/feed']) ?>" data-section="feed">
                    <i class="bx bx-home"></i>
                    <span class="links_name">Feed</span>
                </a>
                <span class="tooltip">Feed</span>
            </li>
            <li>
                <a href="<?= Url::to(['app/friends']) ?>" data-section="friends">
                    <i class="bx bx-user"></i>
                    <span class="links_name">Friends</span>
                </a>
                <span class="tooltip">Friends</span>
            </li>
            <li>
                <a href="<?= Url::to(['app/notifications']) ?>" data-section="notifications">
                    <i class="bx bx-bell"></i>
                    <span class="links_name">Notifications</span>
                </a>
                <span class="tooltip">Notifications</span>
            </li>
            <li>
                <a href="<?= Url::to(['app/search']) ?>" data-section="find-friends">
                    <i class="bx bx-search-alt"></i>
                    <span class="links_name">Find Friends</span>
                </a>
                <span class="tooltip">Find Friends</span>
            </li>
            <li>
                <a href="<?= Url::to(['app/messages']) ?>" data-section="messages">
                    <i class="bx bx-chat"></i>
                    <span class="links_name">Messages</span>
                </a>
                <span class="tooltip">Messages</span>
            </li>

            <div class="bottom-section">
                <ul>
                    <li>
                        <a href="#" data-section="settings" onclick="openModal()">
                            <i class="bx bx-cog"></i>
                            <span class="links_name">Settings</span>
                        </a>
                        <span class="tooltip">Settings</span>
                    </li>
                    <li>
                        <a href="<?= Url::to(['site/logout']) ?>" data-method="post" data-section="logout">
                            <i class="bx bx-log-out"></i>
                            <span class="links_name">Logout</span>
                        </a>
                        <span class="tooltip">Logout</span>
                    </li>
                </ul>
            </div>

        </ul>


    </div>

    <!-- Main Content Area -->
    <div class="home-section">
        <?php echo $content ?>
    </div>


    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    $this->registerJsFile('@web/js/notifications.js', ['depends' => [\yii\web\JqueryAsset::class]]);
    $this->registerJsFile('@web/js/notification-handler.js', ['depends' => [\yii\web\JqueryAsset::class]]);
    $this->registerJsFile('https://unpkg.com/@popperjs/core@2', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('https://unpkg.com/tippy.js@6', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerCssFile('https://unpkg.com/tippy.js@6/animations/scale.css');
    ?>



    <div id="settingsModal" class="modal">
        <div id="settingsModalContent" class="modal-content">

            <span id="settingsModalCloseButton" class="close-btn" onclick="closeModal()">&times;</span>


            <div id="settingsTopTabs" class="top-tabs">
                <button id="profileEditTabButton" class="tab-button active" onclick="openTab('profileEditTabContent')">Profile</button>
                <button id="notificationEditTabButton" class="tab-button" onclick="openTab('notificationEditTabContent')">Notifications</button>
                <button id="passwordSecurityTabButton" class="tab-button" onclick="openTab('passwordSecurityTabContent')">Security</button>
            </div>


            <div id="settingsContentWrapper">

                <div id="profileEditTabContent" class="tab-content active">
                    <h3>Profile Edit</h3>


                    <div id="profilePictureCard" class="profile-card">
                        <img id="profilePictureImage"
                            src="<?= Html::encode(Yii::$app->user->identity->profile_picture) ?>"
                            alt="Profile Picture"
                            class="profile-img" />

                        <?= Html::beginForm(['app/update-profile-picture'], 'post', [
                            'enctype' => 'multipart/form-data',
                            'id' => 'profilePictureForm'
                        ]); ?>
                        <label class="btn btn-primary change-picture-btn">
                            Change Picture
                            <input type="file"
                                name="profilePicture"
                                accept="image/*"
                                style="display: none;"
                                onchange="this.form.submit();" />
                        </label>
                        <?= Html::endForm(); ?>
                    </div>

                    <div class="form-group">
                        <?= Html::beginForm(['app/update-profile'], 'post', ['id' => 'profile-form']); ?>
                        <div class="form-group">
                            <label for="profileNameInput">Profile Name</label>
                            <input type="text"
                                name="fullname"
                                id="profileNameInput"
                                value="<?= Yii::$app->user->identity->fullname ?>"
                                placeholder="Enter your full name" />
                        </div>

                        <div class="form-group">
                            <label for="usernameInput">Username</label>
                            <input type="text"
                                id="usernameInput"
                                value="<?= '@' . Html::encode(Yii::$app->user->identity->username) ?>"
                                disabled />
                        </div>

                        <div class="form-group">
                            <label for="aboutTextarea">About (Bio)</label>
                            <textarea name="bio"
                                id="aboutTextarea"
                                placeholder="Tell us a bit about yourself..."><?= Html::encode(\app\models\Usersmain::findOne(Yii::$app->user->identity->id)->bio) ?></textarea>
                        </div>

                        <button type="submit" class="save-btn">Save Changes</button>
                        <?= Html::endForm(); ?>
                    </div>
                </div>


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
                        <?php $form = ActiveForm::begin([
                            'id' => 'password-form',
                            'action' => ['app/change-password'],
                            'enableAjaxValidation' => true,
                            'validationUrl' => ['app/validate-password']
                        ]); ?>
                        <?php $passwordForm = new \app\models\ChangePasswordForm(); ?>

                        <?= $form->field($passwordForm, 'currentPassword')
                            ->passwordInput(['placeholder' => 'Enter current password'])
                            ->error(['class' => 'help-block error-message']) ?>

                        <?= $form->field($passwordForm, 'newPassword')
                            ->passwordInput(['placeholder' => 'Enter new password'])
                            ->error(['class' => 'help-block error-message']) ?>

                        <?= $form->field($passwordForm, 'confirmNewPassword')
                            ->passwordInput(['placeholder' => 'Confirm new password'])
                            ->error(['class' => 'help-block error-message']) ?>

                        <button type="submit" class="save-btn">Reset Password</button>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $this->registerCss("
        .error-message {
            color: #ff4444;
            margin-top: 5px;
            font-size: 12px;
        }
    ");
    ?>



    <?php $this->endBody() ?>


</body>

</html>

<?php $this->endPage() ?>
<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use app\models\Usersmain;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;

$this->title = 'Feed';
$this->registerCss('.home-section { overflow-y: auto; };');

?>

<?= Html::csrfMetaTags() ?>


<div class="container-fluid d-flex justify-content-center home-section feed-active" style="background-color: #11101D;">
    <div class="row" style="max-width: 1200px; width: 100%;">
        <!-- Main Feed Column (8/12) -->
        <div class="col-lg-8 feed-column">

            <!-- Post Creation Box -->
            <?php Pjax::begin(['id' => 'create-post-pjax', 'enablePushState' => false]); ?>
            <div class="feed-creation-box">
                <?php $form = ActiveForm::begin([
                    'action' => ['app/create-post'],
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'data-pjax' => true,
                        'class' => 'post-form'
                    ]
                ]); ?>
                <div class="feed-input-container">
                    <img src="<?= Html::encode(Yii::$app->user->identity->profile_picture) ?>" alt="Profile" class="feed-user-pic">
                    <?= Html::textInput('caption', '', ['class' => 'feed-input', 'placeholder' => "What's on your mind?"]) ?>
                </div>
                <div class="feed-buttons">
                    <label for="photoInput" class="feed-photo-btn"><i class='bx bx-image'></i> Photo</label>
                    <?= Html::fileInput('image', null, ['id' => 'photoInput', 'style' => 'display: none;', 'accept' => 'image/*']) ?>
                    <div class="image-preview-container">
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none;">
                        <span id="removeImage" class="remove-image" style="display: none;"> &times;</span>
                    </div>
                    <?= Html::submitButton('Post', ['class' => 'feed-post-btn']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <?php Pjax::end(); ?>

            <div class="feed-container">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <?= $this->render('_post', ['post' => $post]) ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: white;">No posts available.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-4 sidebar-column">
            <!-- Friend Suggestions -->
            <div class="suggestions-box">
                <h4 class="sidebar-heading">Friend Suggestions</h4>
                <hr class="divider-k">
                <div class="suggestions-scroll custom-scroll">
                    <?php foreach ($notFollowedUsers as $user): ?>
                        <div class="suggestion-entry">
                            <img src="<?= Html::encode($user->profile_image_path) ?>" alt="Friend" class="suggestion-avatar">
                            <?= Html::a(Html::encode($user->fullname), ['/app/profile-view', 'username' => $user->username], ['class' => 'suggestion-name']) ?>


                            <?php Pjax::begin(['id' => 'follow-button-' . $user->user_id]); ?>
                            <?= $this->render('_suggestionFollowButton', [
                                'user' => $user,
                                'isFollowing' => false
                            ]) ?>
                            <?php Pjax::end(); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Active Friends -->
            <div class="active-friends-box">
                <h4 class="sidebar-heading">Active Friends</h4>
                <div class="friend-list custom-scroll">
                    <?php foreach ($activeFriends as $friend): ?>
                        <li class="friend-entry">
                            <?= Html::a(
                                '<img src="' . Html::encode($friend->profile_image_path) . '" alt="Friend" class="active-avatar">' .
                                    '<p class="active-name">' . Html::encode($friend->fullname) . '</p>',
                                ['/app/messages'],
                                ['class' => 'friend-link']
                            ) ?>
                        </li>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(
    <<<JS
    document.getElementById('photoInput').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                var removeImage = document.getElementById('removeImage');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                removeImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('removeImage').addEventListener('click', function() {
        var imagePreview = document.getElementById('imagePreview');
        var removeImage = document.getElementById('removeImage');
        imagePreview.src = '#';
        imagePreview.style.display = 'none';
        removeImage.style.display = 'none';
        document.getElementById('photoInput').value = ''; 
    });
JS
);
?>
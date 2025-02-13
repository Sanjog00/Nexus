<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Search';
?>




<div class="friends-container">


    <div class="friends-sidebar">
        <h2 class="find-sidebar-title">Find Friends</h2>

        <?php Pjax::begin(['id' => 'search-pjax', 'enablePushState' => false]); ?>
        <div class="find-search-wrapper">
            <?php $form = ActiveForm::begin([
                'id' => 'search-form',
                'method' => 'post',
                'options' => ['data-pjax' => true],
            ]); ?>
            <i class="bx bx-search find-search-icon"></i>
            <?= Html::activeTextInput($searchModel, 'fullname', [
                'class' => 'find-search-input',
                'placeholder' => 'Search friends'
            ]) ?>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="find-history-scroll">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <div class="find-history-entry">
                        <a href="#" class="friend-link" data-id="<?= $user->user_id ?>">
                            <?php if ($user->profile_image_path): ?>
                                <img src="<?= Html::encode($user->profile_image_path) ?>" alt="Profile" class="friend-avatar">
                            <?php else: ?>

                            <?php endif; ?>
                            <div class="find-name-container">
                                <p class="find-name"><?= Html::encode($user->fullname) ?></p>
                            </div>

                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php Pjax::end(); ?>
    </div>

    <!-- Profile Preview Section -->
    <div class="profile-preview">

        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="text-center">
                <i class='bx bx-user' style="font-size: 50px; color: #fff;"></i>
                <p style="color: #fff; font-size: 20px;">Search and select a friend to view their profile.</p>
            </div>
        </div>

    </div>
</div>


<?php
$this->registerJs("
    $(document).on('click', '.friend-link', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        $.ajax({
            url: '" . Yii::$app->urlManager->createUrl(['app/profile']) . "?id=' + userId,
            type: 'GET',
            push: false,
            success: function(data) {
                $('.profile-preview').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading profile:', textStatus, errorThrown);
                console.error('Response:', jqXHR.responseText);
                alert('Error loading profile.');
            }
        });
    });
");

?>
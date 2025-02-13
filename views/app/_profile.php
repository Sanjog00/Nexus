<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $friend app\models\Usersmain */
/* @var $postsCount int */
/* @var $followersCount int */
/* @var $followingsCount int */

?>


<div class="profile-header">
    <div class="profile-avatar">
        <img src="<?= Html::encode($friend->profile_image_path) ?>" alt="User Profile" class="profile-pic">
    </div>

    <div class="profile-main-info">
        <div class="name-username">
            <h2 class="user-full-name">
                <?= Html::encode($friend->fullname) ?>
            </h2>
            <p class="username">@<?= Html::encode($friend->username) ?></p>
        </div>

        <div class="profile-stats">
            <div class="stat-item">
                <strong><?= $postsCount ?></strong>
                <span>Posts</span>
            </div>
            <div class="stat-item">
                <strong><?= $followersCount ?></strong>
                <span>Followers</span>
            </div>
            <div class="stat-item">
                <strong><?= $followingsCount ?></strong>
                <span>Following</span>
            </div>
        </div>
    </div>
</div>
<div class="profile-info">
    <p class="bio"><?= Html::encode($friend->bio) ?></p>
</div>

<div class="profile-actions">
    <?php if (!$isUser): ?>
        <?php Pjax::begin(['id' => 'pjax-follow-container']); ?>
        <?= $this->render('_followButton', ['friend' => $friend, 'isFollowing' => $isFollowing]) ?>
        <?php Pjax::end(); ?>
    <?php endif; ?>

</div>

<hr class="divider-k">
<h3 class="posts-label">Posts</h3>

<div class="friend-posts">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <?= $this->render('_post', ['post' => $post]) ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h3 style="text-align: center; color: white;">No posts available.</h3>
    <?php endif; ?>
</div>


<?php
$this->registerJs("
    $(document).on('submit', '.like-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var container = '#pjax-like-container' + form.find('input[name=\"postId\"]').val();
        $.pjax.submit(e, container, {push: false});
    });

    $(document).on('pjax:error', function(e, xhr, status, error) {
        console.error('Pjax error:', status, error);
        e.preventDefault();
    });

   
");
?>
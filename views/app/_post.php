<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\web\YiiAsset;
use app\assets\AppAsset;

/* @var $post app\models\Posts */

yii\web\YiiAsset::register($this);
AppAsset::register($this);
?>

<div class="feed-post">
    <div class="post-header">
        <img src="<?= Html::encode($post->user->profile_image_path) ?>" alt="Profile" class="post-profile-pic">
        <div>
            <strong>
                <?= Html::a(
                    Html::encode($post->user->fullname),
                    ['/app/profile-view', 'username' => $post->user->username],
                    ['class' => 'post-username']
                ) ?>
            </strong>
            <p class="post-time"><?= Yii::$app->formatter->asRelativeTime($post->created_at) ?></p>
        </div>
    </div>
    <p class="post-text"><?= Html::encode($post->content, ENT_NOQUOTES) ?></p>
    <?php if ($post->image_path): ?>
        <div class="image-container">
            <div class="loading-spinner"></div>
            <img src="<?= Html::encode($post->image_path) ?>"
                alt="Post Image"
                class="post-img"
                onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';">
        </div> <?php endif; ?>

    <div class="post-actions">
        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <?php Pjax::begin(['id' => 'pjax-like-container-' . $post->post_id, 'enablePushState' => false]); ?>
            <?php if ($post->isLikedByCurrentUser()): ?>
                <?= Html::beginForm(['app/unlike'], 'post', [
                    'data-pjax' => true,
                    'class' => 'like-form'
                ]) ?>
                <?= Html::hiddenInput('postId', $post->post_id) ?>
                <button type="submit" class="like-btn">
                    <i class='bx bxs-heart' style="color: red;"></i>
                </button>
                <?= Html::endForm() ?>
            <?php else: ?>
                <?= Html::beginForm(['app/like'], 'post', [
                    'data-pjax' => true,
                    'class' => 'like-form'
                ]) ?>
                <?= Html::hiddenInput('postId', $post->post_id) ?>
                <button type="submit" class="like-btn">
                    <i class='bx bx-heart' style="color: white;"></i>
                </button>
                <?= Html::endForm() ?>
            <?php endif; ?>
            <span class="like-count" data-post-id="<?= $post->post_id ?>"><?= Html::encode($post->getLikes()->count()) ?> likes</span>
            <?php Pjax::end(); ?>
        </div>
    </div>

    <div class="comment-section">
        <?php Pjax::begin(['id' => 'pjax-comment-form' . $post->post_id, 'enablePushState' => false]); ?>

        <?= $this->render('_comments', ['post' => $post]) ?>
        <?php Pjax::end(); ?>

    </div>

</div>
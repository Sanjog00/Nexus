<?php

use yii\helpers\Html;
?>
<div class="interaction-buttons">
    <div class="button-group">
        <div class="like-container">
            <?php if ($post->isLikedByCurrentUser()): ?>
                <?= Html::beginForm(['app/unlike'], 'post', [
                    'data-pjax' => true,
                    'class' => 'like-form'
                ]) ?>
                <?= Html::hiddenInput('postId', $post->post_id) ?>
                <button type="submit" class="action-btn like-btn">
                    <i class='bx bxs-heart' style="color: red;"></i>
                </button>
                <?= Html::endForm() ?>
            <?php else: ?>
                <?= Html::beginForm(['app/like'], 'post', [
                    'data-pjax' => true,
                    'class' => 'like-form'
                ]) ?>
                <?= Html::hiddenInput('postId', $post->post_id) ?>
                <button type="submit" class="action-btn like-btn">
                    <i class='bx bx-heart' style="color: white;"></i>
                </button>
                <?= Html::endForm() ?>
            <?php endif; ?>
            <span class="like-count"
                data-post-id="<?= $post->post_id ?>"
                data-likes-url="<?= \yii\helpers\Url::to(['app/get-likes', 'postId' => $post->post_id]) ?>">
                <?= Html::encode($post->getLikes()->count()) ?> likes
            </span>
        </div>

        <button type="button" class="action-btn send-btn" aria-label="Share">
            <i class='bx bx-send' style="color: white;"></i>
        </button>
    </div>
</div>
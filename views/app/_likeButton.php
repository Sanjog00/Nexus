<?php

use yii\helpers\Html;

if ($post->isLikedByCurrentUser()): ?>
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
<span class="like-count"><?= Html::encode($post->getLikes()->count()) ?> likes</span>
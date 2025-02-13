<?php

use yii\helpers\Html; ?>

<a href="#" class="view-comments" data-bs-toggle="modal" data-bs-target="#commentsModal<?= $post->post_id ?>">
    Show all comments (<?= Html::encode($post->getComments()->count()) ?>)
</a>
<div class="comment-entry">
    <img src="<?= Html::encode(Yii::$app->user->identity->profile_picture) ?>" alt="User" class="comment-user-pic">

    <?= Html::beginForm(['app/comment'], 'post', [
        'data-pjax' => true,
        'class' => 'w-100 comment-form'
    ]) ?>
    <?= Html::hiddenInput('postId', $post->post_id) ?>
    <input type="text" name="content" class="comment-input" placeholder="Write your comment..." onkeypress="if(event.keyCode === 13) { $(this).closest('form').submit(); return false; }">
    <?= Html::endForm() ?>

</div>


<!-- Comments Modal -->
<div class="modal" id="commentsModal<?= $post->post_id ?>" tabindex="-1" aria-labelledby="commentsModalLabel<?= $post->post_id ?>" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-mode">
            <div class="modal-header">
                <h5 class="modal-title" id="commentsModalLabel<?= $post->post_id ?>">Comments</h5>
                <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="modal-body comments-container">
                <?php if ($post->getComments()->count() > 0): ?>
                    <?php foreach ($post->getComments()->all() as $comment): ?>
                        <div class="comment-item">
                            <div class="comment-wrapper">
                                <img src="<?= Html::encode($comment->user->profile_image_path) ?>" alt="User" class="comment-user-pic">
                                <div class="comment-content-wrapper">
                                    <p class="comment-text">
                                        <span class="comment-username"><?= Html::encode($comment->user->username) ?></span>
                                        <?= Html::encode($comment->content) ?>
                                    </p>
                                    <span class="comment-time"><?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-comments">No comments yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
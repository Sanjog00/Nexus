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

        <button type="button"
            class="action-btn send-btn"
            aria-label="Share"
            onclick="openShareModal(<?= $post->post_id ?>)">
            <i class='bx bx-send' style="color: white;"></i>
        </button>
    </div>
</div>

<!-- Share Modal -->
<div id="shareModal<?= $post->post_id ?>" class="share-modal">
    <div class="share-modal-content">
        <div class="share-modal-header">
            <h3>Share to</h3>
            <button class="close-modal" onclick="closeShareModal(<?= $post->post_id ?>)">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="share-modal-body">
            <div class="search-container">
                <i class='bx bx-search search-icon'></i>
                <input type="text"
                    class="search-input"
                    placeholder="Search..."
                    onkeyup="searchFriends(this.value, <?= $post->post_id ?>)">
            </div>
            <div class="friends-list" id="friendsList<?= $post->post_id ?>">
                <?php
                $mutualFollowers = (new \app\models\User)->getMutualFollowers();
                if (empty($mutualFollowers)): ?>
                    <div class="no-friends">
                        <p>No mutual followers found</p>
                    </div>
                    <?php else:
                    foreach ($mutualFollowers as $follower): ?>
                        <div class="friend-item">
                            <div class="friend-info">
                                <img src="<?= Html::encode($follower['profile_picture']) ?>"
                                    alt="<?= Html::encode($follower['username']) ?>"
                                    class="friend-avatar">
                                <div class="friend-details">
                                    <span class="friend-name"><?= Html::encode($follower['fullname']) ?></span>
                                    <span class="friend-username">@<?= Html::encode($follower['username']) ?></span>
                                </div>
                            </div>
                            <label class="checkbox-container">
                                <input type="checkbox"
                                    class="friend-checkbox"
                                    value="<?= $follower['id'] ?>"
                                    data-post-id="<?= $post->post_id ?>">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
            <button class="share-button" onclick="sharePostToFriends(<?= $post->post_id ?>)">
                Share
            </button>
        </div>
    </div>
</div>
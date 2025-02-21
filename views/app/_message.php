<?php

use yii\helpers\Html;
use app\models\Posts;

foreach ($messages as $message): ?>
    <?php if ($message->sender_id == Yii::$app->user->id): ?>
        <div class="messaging-chat-message sent">
            <?php if ($message->message_type == 'post'): ?>
                <?php $post = Posts::findOne($message->content); ?>
                <?php if ($post): ?>
                    <div class="shared-post">
                        <div class="shared-post-header">
                            <img src="<?= Html::encode($post->user->profile_image_path) ?>" alt="Profile" class="shared-post-profile-pic">
                            <div>
                                <strong><?= Html::encode($post->user->fullname) ?></strong>
                            </div>
                        </div>
                        <p class="shared-post-text"><?= Html::encode($post->content) ?></p>
                        <?php if ($post->image_path): ?>
                            <img src="<?= Html::encode($post->image_path) ?>" alt="Post Image" class="shared-post-img">
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="messaging-message-text">Shared post not found</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="messaging-message-text"><?= Html::encode($message->content) ?></p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="messaging-chat-message received">
            <img src="<?= Html::encode($selectedUser->profile_image_path) ?>" alt="User" class="messaging-message-avatar">
            <?php if ($message->message_type == 'post'): ?>
                <?php $post = Posts::findOne($message->content); ?>
                <?php if ($post): ?>
                    <div class="shared-post">
                        <div class="shared-post-header">
                            <img src="<?= Html::encode($post->user->profile_image_path) ?>" alt="Profile" class="shared-post-profile-pic">
                            <div>
                                <strong><?= Html::encode($post->user->fullname) ?></strong>
                            </div>
                        </div>
                        <p class="shared-post-text"><?= Html::encode($post->content) ?></p>
                        <?php if ($post->image_path): ?>
                            <img src="<?= Html::encode($post->image_path) ?>" alt="Post Image" class="shared-post-img">
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="messaging-message-text">Shared post not found</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="messaging-message-text"><?= Html::encode($message->content) ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<?php

use yii\helpers\Html;

foreach ($messages as $message): ?>
    <?php if ($message->sender_id == Yii::$app->user->id): ?>
        <div class="messaging-chat-message sent">
            <p class="messaging-message-text"><?= Html::encode($message->content) ?></p>
        </div>
    <?php else: ?>
        <div class="messaging-chat-message received">
            <img src="<?= $selectedUser->profile_image_path ?>" alt="User" class="messaging-message-avatar">
            <p class="messaging-message-text"><?= Html::encode($message->content) ?></p>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
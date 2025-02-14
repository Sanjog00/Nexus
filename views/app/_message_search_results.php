<?php

use yii\helpers\Html;
use app\models\Messages;

?>

<?php foreach ($users as $user): ?>
    <div class="messaging-conversation-entry">
        <a href="#" class="friend-link" data-id="<?= $user->user_id ?>">
            <img src="<?= Html::encode($user->profile_image_path) ?>" alt="Profile Picture" class="messaging-conversation-avatar">
            <div class="messaging-conversation-info">
                <p class="messaging-conversation-name"><?= Html::encode($user->fullname) ?></p>
                <p class="messaging-conversation-snippet">
                    <?php
                    $lastMessage = Messages::find()
                        ->where([
                            'or',
                            ['sender_id' => Yii::$app->user->id, 'receiver_id' => $user->user_id],
                            ['sender_id' => $user->user_id, 'receiver_id' => Yii::$app->user->id]
                        ])
                        ->orderBy(['created_at' => SORT_DESC])
                        ->one();

                    if ($lastMessage):
                        $key = Yii::$app->params['messageEncryptionKey'];
                        $combined = base64_decode($lastMessage->content);
                        $iv = substr($combined, 0, 16);
                        $encrypted = substr($combined, 16);
                        $decryptedContent = openssl_decrypt(
                            $encrypted,
                            'AES-256-CBC',
                            $key,
                            0,
                            $iv
                        );
                    ?>
                        <?php if ($lastMessage->sender_id == Yii::$app->user->id): ?>
                            You: <?= Html::encode(strlen($decryptedContent) > 20 ? substr($decryptedContent, 0, 20) . '...' : $decryptedContent) ?>
                        <?php else: ?>
                            <?= Html::encode(strlen($decryptedContent) > 20 ? substr($decryptedContent, 0, 20) . '...' : $decryptedContent) ?>
                        <?php endif; ?>
                    <?php else: ?>
                        No messages yet
                    <?php endif; ?>
                </p>
            </div>
        </a>
    </div>
<?php endforeach; ?>
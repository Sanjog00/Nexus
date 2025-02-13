<?php

use yii\helpers\Html;
use app\models\Messages;
?>


<div class="messaging-page-main-container">

    <div class="messaging-sidebar-full-height">

        <div class="messaging-sidebar-tabs">
            <h2>Messages</h2>
        </div>


        <div class="messaging-search-bar-wrapper">
            <i class="bx bx-search messaging-search-icon"></i>
            <input type="text" class="messaging-search-input" placeholder="Search messages">
        </div>


        <div class="messaging-conversation-list ">
            <?php foreach ($users as $user): ?>
                <div class="messaging-conversation-entry">
                    <a href="#" class="friend-link" data-id="<?= $user->user_id ?>">
                        <img src="<?= Html::encode($user->profile_image_path) ?>" alt="Profile Picture" class="messaging-conversation-avatar">
                        <div class="messaging-conversation-info">
                            <p class="messaging-conversation-name"><?= Html::encode($user->fullname) ?>
                            </p>
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
                                        You: <?= Html::encode(strlen($decryptedContent) > 20 ? substr($decryptedContent, 0, 20) . '...' : $decryptedContent) ?> · <?= str_replace(
                                                                                                                                                                        [' hours', ' minutes', ' seconds', ' ago'],
                                                                                                                                                                        ['h', 'm', 's', ''],
                                                                                                                                                                        Yii::$app->formatter->asRelativeTime($lastMessage->created_at)
                                                                                                                                                                    ) ?>
                                    <?php else: ?>
                                        <?= Html::encode(strlen($decryptedContent) > 20 ? substr($decryptedContent, 0, 20) . '...' : $decryptedContent) ?> · <?= str_replace(
                                                                                                                                                                    [' hours', ' minutes', ' seconds', ' ago'],
                                                                                                                                                                    ['h', 'm', 's', ''],
                                                                                                                                                                    Yii::$app->formatter->asRelativeTime($lastMessage->created_at)
                                                                                                                                                                ) ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    No messages yet
                                <?php endif;
                                ?>
                            </p>
                        </div>
                    </a>




                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <div class="messaging-chat-window-full-height">
        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">

            <div class="text-center">
                <i class='bx bx-message' style="font-size: 50px; color: #fff;"></i>
                <p style="color: #fff; font-size: 20px;">Select a friend to view conversation.</p>
            </div>

        </div>

    </div>
</div>
</div>
</div>


<?php
$this->registerJs("
    $(document).on('click', '.friend-link', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: '" . Yii::$app->urlManager->createUrl(['app/load-chat']) . "?userId=' + id,
            type: 'GET',
            push: false,
            success: function(data) {
                $('.messaging-chat-window-full-height').html(data);
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
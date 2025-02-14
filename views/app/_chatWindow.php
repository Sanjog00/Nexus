<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<div class="messaging-chat-header">
    <div class="messaging-chat-header-info">
        <img src="<?= $selectedUser->profile_image_path ?>" alt="User" class="messaging-chat-avatar">
        <strong>
            <?= Html::a(
                Html::encode($selectedUser->fullname),
                ['/app/profile-view', 'username' => $selectedUser->username],
                ['class' => 'messaging-chat-name']
            ) ?>
        </strong>
    </div>
</div>

<div class="messaging-chat-messages-container messaging-custom-scrollbar">
    <?php
    Pjax::begin([
        'id' => 'chat-messages',
        'enablePushState' => false,
        'timeout' => false,
        'clientOptions' => ['method' => 'POST']
    ]);
    ?>
    <?= $this->render('_message', ['messages' => $messages, 'selectedUser' => $selectedUser]) ?>
    <?php Pjax::end(); ?>
</div>


<?php $form = ActiveForm::begin([
    'action' => ['app/send-message'],
    'method' => 'post',
    'options' => [
        'id' => 'message-form',
    ],
]); ?>
<div style="display: flex; align-items: center; width: 100%; position: relative;">

    <i class="bx bx-smile messaging-emoji-icon" id="emoji-icon"></i>
    <emoji-picker style="display: none; position: absolute; bottom: 100%; left: 0;" id="emoji-picker"></emoji-picker>

    <i class="bx bx-image messaging-emoji-icon"></i>

    <?= Html::hiddenInput('userId', $selectedUser->user_id) ?>

    <?= $form->field($newMessage, 'content', [
        'options' => ['class' => 'form-field-container', 'style' => 'margin: 0; flex: 1;']
    ])->textInput([
        'placeholder' => 'Message...',
        'id' => 'message-input',
        'class' => 'messaging-input-field'
    ])->label(false) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$lastMessage = end($messages);
$lastMessageTime = $lastMessage ? $lastMessage->created_at : date('Y-m-d H:i:s');

$this->registerJsFile('@web/js/chat.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJs("
    initChat({$selectedUser->user_id}, '{$lastMessageTime}');
    $(document).on('pjax:beforeReplace', function() {
        destroyChat();
    });
");
$this->registerJs("
    $('#message-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var messageContent = $('#message-input').val().trim();
        if (messageContent === '') {return false;}
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#chat-messages').html(response);
                $('#message-input').val('');}
        });
        return false;
    });
");
?>
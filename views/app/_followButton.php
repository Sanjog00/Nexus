<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $friend app\models\Usersmain */
/* @var $isFollowing boolean */

?>

<div class="profile-actions">
    <?php if ($isFollowing): ?>
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['app/unfollow']),
            'options' => [
                'class' => 'follow-form',
                'data-pjax' => true
            ]
        ]); ?>
        <?= Html::hiddenInput('id', $friend->user_id) ?>
        <?= Html::submitButton('Unfollow', ['class' => 'follow-btn']) ?>
        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['app/follow']),
            'options' => [
                'class' => 'follow-form',
                'data-pjax' => true
            ]
        ]); ?>
        <?= Html::hiddenInput('id', $friend->user_id) ?>
        <?= Html::submitButton('Follow', ['class' => 'follow-btn']) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <?= Html::a('Message', ['app/messages', 'id' => $friend->user_id], ['class' => 'follow-btn']) ?>
</div>

<?php
$this->registerJs("
    $('.follow-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $('.profile-actions').html(response.button);
                }
            }
        });
    });
");
?>
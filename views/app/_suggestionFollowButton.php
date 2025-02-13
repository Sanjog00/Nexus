<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'action' => ['app/follow-suggestion'],
    'options' => [
        'data-pjax' => true,
        'class' => 'follow-form'
    ]
]); ?>
    <?= Html::hiddenInput('id', $user->user_id) ?>
    <?= Html::submitButton($isFollowing ? 'Following' : 'Follow', [
        'class' => 'suggestion-add ' . ($isFollowing ? 'following' : ''),
        'disabled' => $isFollowing
    ]) ?>
<?php ActiveForm::end(); ?>
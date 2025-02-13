<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<?php Pjax::begin(['id' => 'password-update-form', 'enablePushState' => false]); ?>

<?php $form = ActiveForm::begin([
    'id' => 'reset-password-form',
    'options' => ['data-pjax' => true],
    'action' => ['site/reset-password'],
]); ?>
<p style="color: #1E1E1E; font-family: 'Poppins', sans-serif; font-size: 20px; text-align: left; font-weight: 600;">Set a new password</p>

<p style="color: #989898; font-family: 'Poppins', sans-serif; font-size: 15px; text-align: left;">Create a new password. Ensure it differs from
    previous ones for security</p>

<div class="password-field" style="width: 100%;">
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'style' => 'width: 100%;'])->label(false) ?>
</div>
<div class="password-field" style="width: 100%;">
    <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder' => 'Confirm Password', 'style' => 'width: 100%;'])->label(false) ?>
</div>

<?= Html::submitButton('Update Password', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>


<?php Pjax::end(); ?>
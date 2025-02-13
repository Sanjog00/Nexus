<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>

<div class="login-form">
    <?php Pjax::begin(['id' => 'verification-form', 'enablePushState' => false]); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'verify-code-form',
        'options' => ['data-pjax' => true, 'class' => 'verify-form'],
        'action' => ['site/verify-code'],

    ]); ?>

    <h3>Check your email</h3>
    <p>We sent a reset link to <?= Html::encode($email) ?>. Enter the 5-digit code mentioned in the email.</p>

    <div class="code-input">
        <?= $form->field($model, 'digit1')->textInput(['maxlength' => 1, 'class' => 'code-field'])->label(false) ?>
        <?= $form->field($model, 'digit2')->textInput(['maxlength' => 1, 'class' => 'code-field'])->label(false) ?>
        <?= $form->field($model, 'digit3')->textInput(['maxlength' => 1, 'class' => 'code-field'])->label(false) ?>
        <?= $form->field($model, 'digit4')->textInput(['maxlength' => 1, 'class' => 'code-field'])->label(false) ?>
        <?= $form->field($model, 'digit5')->textInput(['maxlength' => 1, 'class' => 'code-field'])->label(false) ?>
    </div>

    <?= Html::submitButton('Verify Code', ['class' => 'verify-btn']) ?>

    <div class="resend">
        <p>Haven't got the email yet? <?= Html::a('Resend email', ['site/resend-code'], ['class' => 'resend-link']) ?></p>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
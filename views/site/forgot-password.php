<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\base\Model\ForgotPasswordForm;

$this->registerCssFile('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap', ['depends' => [\yii\web\YiiAsset::class]]);

Html::csrfMetaTags();
$this->registerCssFile('@web/css/style-login.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->title = 'Recover Password';
?>

<div class="login-content">
    <div class="image-section">
        <img src="<?= Url::to('@web/animation/loginAnimation.gif') ?>" alt="Nexus Animation" class="animation">
    </div>

    <div class="form-section">
        <div class="app-icon">
            <img src="<?= Url::to('@web/assets/images/logo.png') ?>" alt="Nexus Icon" class="icon">
        </div>

        <?php Pjax::begin(['id' => 'forgot-password-form']); ?>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'login-form', 'data-pjax' => true]]); ?>
        <p style="color: #989898; font-family: 'Poppins', sans-serif; font-size: 15px; text-align: left;">Please enter your email/username to reset your password</p>
        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Email, Username'])->label(false) ?>
        <?= Html::submitButton('Reset Password', [
            'class' => 'btn btn-primary',

        ]) ?>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
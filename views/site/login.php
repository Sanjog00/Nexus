<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/css/style-login.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->title = 'Nexus Login';
?>

<div class="login-content">
    <div class="image-section">
        <img src="<?= Url::to('@web/animation/loginAnimation.gif') ?>" alt="Nexus Animation" class="animation">
    </div>

    <div class="form-section">
        <div class="app-icon">

            <img src="<?= Url::to('@web/assets/images/logo.png') ?>" alt="Nexus Icon" class="icon">

        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'login-form']]); ?>
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Username'])->label(false) ?>
        <div class="password-field">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'id' => 'password'])->label(false) ?>

        </div>
        <div class="options">
            <a href="<?= Url::to(['site/forgot-password']) ?>">Forgot password?</a>

        </div>
        <?= Html::submitButton('LOGIN', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <div class="register-link">
            <?php echo '<p>Don\'t have an account? ' . Html::a('Register', ['/site/signup']) . '</p>'; ?>

        </div>
    </div>
</div>
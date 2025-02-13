<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
$this->registerCssFile('@web/css/signup-styles.css', ['depends' => [\yii\web\YiiAsset::class]]);

$this->title = 'Nexus Signup';
?>
<div class="signup-content">
            <div class="image-section">
            <img src="<?= Url::to('@web/animation/loginAnimation.gif') ?>" alt="Nexus Animation" class="animation">            </div>
            <div class="form-section">
                <div class="app-icon">
                <img src="<?= Url::to('@web/assets/images/logo.png') ?>" alt="Nexus Icon" class="icon">
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'signup-form']]); ?>

                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username', 'required' => true])->label(false) ?>

                <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Email Address', 'required' => true])->label(false) ?>

                <?= $form->field($model, 'fullname')->textInput(['placeholder' => 'Fullname', 'required' => true])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'required' => true])->label(false) ?>

                <?= $form->field($model, 'gender')->dropDownList(
                    ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
                    ['prompt' => 'Select Gender']
                )->label(false) ?>

                <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>

            <?php ActiveForm::end(); ?>
         </div>
</div>
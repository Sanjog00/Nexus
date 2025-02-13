<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Friends';
?>


<div class="friends-container">




    <?= $this->render('_listviewFriends', [
        'follows' => $follows,
        'searchModel' => $searchModel,
    ]) ?>



    <!-- Profile Preview -->
    <div class="profile-preview">

        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="text-center">
                <i class='bx bx-user' style="font-size: 50px; color: #fff;"></i>
                <p style="color: #fff; font-size: 20px;">Select a friend to view their profile.</p>
            </div>
        </div>

    </div>
</div>
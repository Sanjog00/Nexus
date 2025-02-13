<?php

use yii\helpers\Html;


$this->title = "Profile";

?>

<style>
    .home-section {
        background-color: #11101d;
    }
</style>


<div class="container" style="padding-top: 5px;">
    <?= $this->render('_profile', [
        'friend' => $friend,
        'posts' => $posts,
        'postsCount' => $friend->getPosts()->count(),
        'followersCount' => $friend->getFollows0()->count(),
        'followingsCount' => $friend->getFollows()->count(),
        'isFollowing' => $isFollowing,
        'isUser' => $isUser
    ]) ?>
</div>
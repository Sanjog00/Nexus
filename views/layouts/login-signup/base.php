<?php

use yii\helpers\Url;
?>

<?php $this->beginContent('@app/views/layouts/login-signup/parent.php'); ?>


<video autoplay loop muted playsinline class="background-video">
    <source src="<?= Url::to('@web/animation/background.mp4') ?>" type="video/mp4">
</video>

<div class="container">
    <?php echo $content ?>
</div>

<footer>
    <div class="social-icons">
        <a href="#"><i class='bx bxl-facebook'></i></a>
        <a href="#"><i class='bx bxl-twitter'></i></a>
        <a href="#"><i class='bx bxl-linkedin'></i></a>
    </div>
    <p>&copy; 2024 Nexus. All rights reserved.</p>
</footer>

<?php $this->endContent(); ?>
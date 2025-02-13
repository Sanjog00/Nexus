<?php
// This file serves as the main layout template for the login and signup pages.
// It includes the necessary assets, meta tags, and structure for the HTML document.
// The content of the page will be injected where the $content variable is echoed.
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->registerCsrfMetaTags() ?>

    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <?php echo $content ?>

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>
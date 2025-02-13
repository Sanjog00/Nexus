<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = 'Page Not Found';
?>

<div class="error-container">
    <div class="error-content">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>Sorry, but the page you are looking for does not exist, has been removed, or is temporarily unavailable.</p>
        <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-primary">Go to Homepage</a>
    </div>

</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    .error-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f9f9f9 0%, #e0e0e0 100%);
        padding: 20px;
        overflow: hidden;
        position: relative;
    }

    .error-content {
        max-width: 600px;
        margin-bottom: 20px;
        z-index: 2;
    }

    .error-content h1 {
        font-size: 120px;
        color: #dc3545;
        margin: 0;
        animation: bounce 1s infinite;
    }

    .error-content h2 {
        font-size: 36px;
        color: #1E1E1E;
        margin: 10px 0;
    }

    .error-content p {
        color: #666;
        margin-bottom: 20px;
    }

    .error-content .btn-primary {
        background-color: #11101d;
        border-color: #11101d;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.3s;
    }

    .error-content .btn-primary:hover {
        background-color: #333;
        border-color: #333;
        transform: scale(1.05);
    }



    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-30px);
        }

        60% {
            transform: translateY(-15px);
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .error-container::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(220, 53, 69, 0.1);
        border-radius: 50%;
        animation: pulse 2s infinite;
        z-index: 0;
    }

    .error-container::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(220, 53, 69, 0.1);
        border-radius: 50%;
        animation: pulse 2s infinite;
        z-index: 0;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.9);
            opacity: 0.7;
        }

        70% {
            transform: scale(1);
            opacity: 0.3;
        }

        100% {
            transform: scale(0.9);
            opacity: 0.7;
        }
    }
</style>
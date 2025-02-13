<?php

use yii\helpers\Html;
?>



<div class="notification-home">
    <div class="notification-wrapper">
        <div class="notification-panel notification-general">
            <h2>General Notifications</h2>
            <div class="notifications-container">

            </div>
        </div>


        <div class="notification-panel notification-requests">
            <h2>Follow Requests</h2>
            <div class="notification-item">
                <i class="bx bx-user notification-profile"></i>
                <div class="notification-text">
                    <p><strong>Alice Green</strong> wants to follow you</p>
                    <div class="notification-actions">
                        <button class="notification-accept">Accept</button>
                        <button class="notification-decline">Decline</button>
                    </div>
                    <span class="notification-time">5 mins ago</span>
                </div>
            </div>
            <div class="notification-item">
                <i class="bx bx-user notification-profile"></i>
                <div class="notification-text">
                    <p><strong>Bob White</strong> wants to follow you</p>
                    <div class="notification-actions">
                        <button class="notification-accept">Accept</button>
                        <button class="notification-decline">Decline</button>
                    </div>
                    <span class="notification-time">30 mins ago</span>
                </div>
            </div>
        </div>
    </div>


</div>
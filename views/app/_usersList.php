<?php

use yii\helpers\Html;

if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
        <div class="friend-entry">
            <a href="#" class="friend-link" data-id="<?= $user->user_id ?>">
                <?php if ($user->profile_image_path): ?>
                    <img src="<?= Html::encode($user->profile_image_path) ?>"
                        alt="Profile"
                        class="friend-avatar"
                        onerror="this.src='/images/default-avatar.png'">
                <?php else: ?>
                    <img src="/images/default-avatar.png" alt="Profile" class="friend-avatar">
                <?php endif; ?>
                <div class="find-name-container">
                    <p class="find-name"><?= Html::encode($user->fullname) ?></p>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center p-3">
        <p class="text-muted">No users found</p>
    </div>
<?php endif; ?>
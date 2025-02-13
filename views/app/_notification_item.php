<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
?>

<div class="notification-item <?= $notification->type === 'like'  ? 'clickable' : '' ?>"
    data-notification-id="<?= $notification->notification_id ?>"
    data-post-id="<?= $notification->post_id ?>"
    data-bs-toggle="modal"
    data-bs-target="#postModal-<?= $notification->notification_id ?>"
    <?= (in_array($notification->type, ['like', 'post'])) ? '' : 'style="pointer-events: none;"' ?>>


    <div class="notification-left">
        <img src="<?= Html::encode($notification->sender->profile_image_path) ?>"
            alt="Profile"
            class="profile-icon">
    </div>
    <div class="notification-text">
        <p>
            <strong><?= Html::encode($notification->sender->fullname) ?></strong>
            <?= Html::encode($notification->notification_text) ?>
            <?php if ($notification->type === 'comment' && $notification->comment): ?>

                <?= Html::encode($notification->comment->content) ?>

            <?php endif; ?>
        </p>

        <span class="notification-time">
            <?= Yii::$app->formatter->asRelativeTime($notification->created_at) ?>
        </span>
    </div>
    <div class="notification-right">
        <?php if ($notification->post && $notification->post->image_path): ?>
            <img src="<?= Html::encode($notification->post->image_path) ?>"
                alt="Post Image"
                class="notification-post-pic">
        <?php endif; ?>
    </div>
</div>

<?php if (in_array($notification->type, ['like', 'post'])): ?>
    <?php Modal::begin([
        'id' => 'postModal-' . $notification->notification_id,
        'size' => Modal::SIZE_DEFAULT,
        'title' => 'Post',
        'options' => [
            'class' => 'dark-modal',

        ],
        'headerOptions' => ['class' => 'modal-header'],
        'closeButton' => [
            'label' => '<i class="bx bx-x"></i>',
            'class' => 'btn-close',
            'data-bs-dismiss' => 'modal',
        ],

    ]); ?>

    <?= $this->render('_notificationModalPost', [
        'post' => $notification->post
    ]) ?>

    <?php Modal::end(); ?>
<?php endif; ?>
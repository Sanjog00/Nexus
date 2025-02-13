<?php

use yii\helpers\Html;
?>

<div class="modal-header">
    <h5 class="modal-title">Confirm Delete</h5>
    <button type="button" class="close" onclick="$('#deleteModal').modal('hide'); $('.modal-backdrop').remove();">&times;</button>
</div>
<div class="modal-body">
    <?php if ($isAdmin): ?>

        Cannot delete admin user. Administrators cannot be removed from the system.

    <?php else: ?>
        Are you sure you want to remove this user? This will delete all their posts, likes, comments and notifications.
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" onclick="$('#deleteModal').modal('hide'); $('.modal-backdrop').remove();">Cancel</button>
    <?php if (!$isAdmin): ?>
        <?= Html::a('Delete', ['delete-user', 'id' => $id], [
            'class' => 'btn btn-danger',
            'data-method' => 'post'
        ]) ?>
    <?php endif; ?>
</div>
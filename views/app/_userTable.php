<?php

use yii\helpers\Html;
?>
<table class="table table-dark-custom">
    <thead>
        <tr>
            <th>#</th>
            <th>Profile</th>
            <th>Name</th>
            <th>Posts</th>
            <th>Account Created</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $index => $user): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><img src="<?= $user['profile_image_path'] ?>" alt="Profile Picture" class="profile-pic" /></td>
                <td><?= Html::encode($user['fullname']) ?></td>
                <td><?= $user['post_count'] ?></td>
                <td><?= Yii::$app->formatter->asDate($user['created_at']) ?></td>
                <td><?= $user['active_status'] ? 'Active' : 'Inactive' ?></td>
                <td class="action-icons">
                    <?= Html::a(
                        '<i class="bx bx-show" title="View"></i>',
                        '#',
                        [

                            'onclick' => 'window.open("' . \yii\helpers\Url::to(['app/profile-view', 'username' => $user['username']]) . '", "_blank")',
                        ]
                    ) ?>

                    <?= Html::a(
                        '<i class="bx bx-trash-alt"></i>',
                        ['app/delete-modal', 'id' => $user['user_id']],
                        ['class' => 'delete-user-btn', 'data-toggle' => 'modal', 'data-target' => '#deleteModal']
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$this->registerJs("
    $(document).on('click', '.delete-user-btn', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(data) {
            $('#deleteModal .modal-content').html(data);
            $('#deleteModal').modal('show');
        });
    });
");
?>
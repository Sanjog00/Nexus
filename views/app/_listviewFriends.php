   <?php

    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    ?>
   <!-- Friends Sidebar -->
   <div class="friends-sidebar">

       <h2 class="sidebar-title">All Friends</h2>

       <?php Pjax::begin(['id' => 'friends-pjax', 'enablePushState' => false]); ?>
       <!-- Search Form -->
       <div class="search-friend-wrapper">
           <?php $form = ActiveForm::begin([
                'id' => 'search-form',
                'method' => 'post',
                'options' => ['data-pjax' => true],
            ]); ?>
           <i class="bx bx-search search-icon"></i>


           <?= Html::activeTextInput($searchModel, 'fullname', [
                'class' => 'find-search-input',
                'placeholder' => 'Search friends',
                'oninput' => '$.pjax.submit(event, "#friends-pjax")'
            ]) ?>
           <?php ActiveForm::end(); ?>
       </div>

       <!-- Friends List -->
       <div class="friends-list-scroll">
           <?php if (!empty($follows)): ?>
               <ul class="friends-list">
                   <?php foreach ($follows as $follow): ?>
                       <?php $friend = $follow->followed; ?>
                       <li class="friend-entry">
                           <a href="#" class="friend-link" data-id="<?= $friend->user_id ?>">
                               <div class="friend-avatar-container">
                                   <img src="<?= Html::encode($friend->profile_image_path) ?>" alt="Profile Picture" class="friend-avatar">
                               </div>
                               <div class="friend-name-container">
                                   <p class="friend-name"><?= Html::encode($friend->fullname) ?></p>
                               </div>
                           </a>
                       </li>
                   <?php endforeach; ?>
               </ul>
           <?php else: ?>
               <p>No friends found.</p>
           <?php endif; ?>
       </div>
       <?php Pjax::end(); ?>
   </div>

   <?php
    $this->registerJs("
    $(document).on('click', '.friend-link', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        $.ajax({
            url: '" . Yii::$app->urlManager->createUrl(['app/profile']) . "?id=' + userId,
            type: 'GET',
            push: false,
            success: function(data) {
                $('.profile-preview').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading profile:', textStatus, errorThrown);
                console.error('Response:', jqXHR.responseText);
                alert('Error loading profile.');
            }
        });
    });
");


    ?>
<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Search';
?>




<div class="friends-container">


    <div class="friends-sidebar">
        <h2 class="find-sidebar-title">Find Friends</h2>

        <div class="find-search-wrapper">
            <i class="bx bx-search find-search-icon"></i>
            <input type="text" class="messaging-search-input" id="friends-search" placeholder="Search friends">
        </div>

        <div class="find-history-scroll" id="search-results">
            <div class="text-center p-3">
                <p class="text-muted">Type to search for friends</p>
            </div>
        </div>
    </div>

    <!-- Profile Preview Section -->
    <div class="profile-preview">

        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="text-center">
                <i class='bx bx-user' style="font-size: 50px; color: #fff;"></i>
                <p style="color: #fff; font-size: 20px;">Search and select a friend to view their profile.</p>
            </div>
        </div>

    </div>
</div>


<?php
$this->registerJs("
    let searchTimeout;
    $('#friends-search').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();
        
        if (query.length === 0) {
            $('#search-results').html('<div class=\"text-center p-3\"><p class=\"text-muted\">Type to search for friends</p></div>');
            return;
        }
        
        searchTimeout = setTimeout(function() {
            if (query.length >= 2) {
                $.ajax({
                    url: '" . Yii::$app->urlManager->createUrl(['app/search-users']) . "',
                    type: 'GET',
                    data: { query: query },
                    beforeSend: function() {
                        $('#search-results').html('<div class=\"text-center p-3\"><i class=\"bx bx-loader-alt bx-spin\" style=\"font-size: 24px; color: #fff;\"></i></div>');
                    },
                    success: function(response) {
                        $('#search-results').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Search error:', textStatus, errorThrown);
                        $('#search-results').html('<div class=\"text-center p-3\"><p class=\"text-danger\">Search failed. Please try again.</p></div>');
                    }
                });
            }
        }, 300);
    });

    $(document).on('click', '.friend-link', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        $.ajax({
            url: '" . Yii::$app->urlManager->createUrl(['app/profile']) . "?id=' + userId,
            type: 'GET',
            success: function(data) {
                $('.profile-preview').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading profile:', textStatus, errorThrown);
                alert('Error loading profile.');
            }
        });
    });
");

?>
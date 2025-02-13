<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


?>

<link
  href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
  rel="stylesheet" />

<title><?= Html::encode($this->title) ?></title>

<style>
  .home-section {
    background-color: #11101d;
  }

  body {
    font-family: "Roboto", sans-serif;
    background-color: #11101d;
    color: #fff;
    margin: 0;
    padding: 0;
  }


  .container-admin {
    margin-top: 0px;
    padding: 20px;
    background-color: #1c1a29;
    /* Dark background for container */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .dashboard-header {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #333;
  }

  .dashboard-header h3 {
    font-family: "Poppins", sans-serif;

    font-size: 30px;
    font-weight: 600;
    color: #fff;
  }

  /* Statistics Cards */
  .stat-card {
    background-color: #1c1a29;
    border: 2px solid #333;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
  }

  .stat-card h4 {
    font-size: 32px;
    font-weight: bold;
    margin: 0;
    color: #fff;
  }

  .stat-card p {
    font-size: 18px;
    color: #ccc;
    margin-top: 5px;
  }

  .stat-card .stat-icon {
    font-size: 40px;
    color: #3498db;
  }

  .row-stat {
    margin-bottom: 25px;
  }


  .search-bar {
    font-family: "Poppins", sans-serif;

    background-color: #1c1a29;
    border: 1px solid #444;
    padding: 12px 20px;
    border-radius: 8px;
    width: 100%;
    max-width: 400px;
    margin-bottom: 30px;
    font-size: 16px;
    box-sizing: border-box;
    color: #fff;
  }

  .search-bar::placeholder {
    color: #aaa;
  }

  .search-bar:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
  }


  .table-dark-custom {
    font-family: "Poppins", sans-serif;

    background-color: #11101d;
    color: #fff;
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    margin-bottom: 40px;
  }

  .table-dark-custom th,
  .table-dark-custom td {
    font-family: "Poppins", sans-serif;

    padding: 18px;
    text-align: center;
    vertical-align: middle;
    font-size: 14px;
    background-color: #1c1a29;
  }

  .table-dark-custom thead {
    color: #fff;
    font-weight: bold;
    border-radius: 10px 10px 0 0;
  }

  .table-striped tbody tr:hover {
    background-color: #3a3a4b;
    cursor: pointer;
  }

  .profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
  }


  .action-icons i {
    font-size: 18px;
    margin: 0 10px;
    cursor: pointer;
    color: #3498db;
    transition: all 0.3s ease;
  }

  .action-icons i:hover {
    transform: scale(1.2);
    color: #2980b9;
  }


  @media (max-width: 767px) {
    .dashboard-header h3 {
      font-size: 24px;
    }

    .stat-card h4 {
      font-size: 28px;
    }

    .search-bar {
      max-width: 50%;
    }

    .table th,
    .table td {
      font-size: 13px;
      padding: 12px;
    }

    .btn-view,
    .btn-remove {
      padding: 10px 18px;
    }
  }
</style>

<div class="container-admin">



  <div class="dashboard-header">
    <h3>Admin Dashboard</h3>
  </div>

  <div class="row row-stat">
    <div class="col-lg-4 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between">
          <h4><?= $totalUsers ?></h4>
          <div class="stat-icon">👥</div>
        </div>
        <p>Total Users</p>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between">
          <h4><?= $activeUsers ?></h4>
          <div class="stat-icon">🟢</div>
        </div>
        <p>Active Users</p>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between">
          <h4><?= $totalPosts ?></h4>
          <div class="stat-icon">📑</div>
        </div>
        <p>Total Posts</p>
      </div>
    </div>
  </div>

  <div class="search-bar-container d-flex justify-content-end"></div>

  <div class="card" style="background-color: #1c1a29; border: 2px solid #333">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h2>User Management</h2>
      <?= Html::beginForm(['admin'], 'get', [
        'data-pjax' => '#users-table-container',
        'id' => 'search-form'
      ]); ?>
      <input type="text"
        name="search"
        class="search-bar"
        placeholder="Search Users..."
        value="<?= Yii::$app->request->get('search') ?>" />
      <?= Html::endForm(); ?>
    </div>

    <?php Pjax::begin([
      'id' => 'users-table-container',
      'enablePushState' => false,
      'enableReplaceState' => false,
      'timeout' => 1000,
      'formSelector' => '#search-form'
    ]); ?>
    <div class="card-body">
      <?= $this->render('_userTable', ['users' => $users]); ?>
    </div>
    <?php Pjax::end(); ?>
  </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content dark-mode">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>
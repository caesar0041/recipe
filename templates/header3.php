<!--templates/header3.php-->
<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../class.php');
require_once(__DIR__ . '/../function.php'); 

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Chef') {
  header("Location: " . BASE_URL . "homepage/login.php");
  exit;
}

$current_page = basename($_SERVER['PHP_SELF']);
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DASHBOARD</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/adminlte/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo BASE_URL; ?>/assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
  <a href="../index.php" class="nav-link">
    <i class="nav-icon fas fa-home"></i>
    Home
  </a>
</li>
<li class="nav-item d-none d-sm-inline-block">
  <a href="../homepage/contact.php" class="nav-link">
    <i class="nav-icon fas fa-envelope"></i>
    Contact
  </a>
</li>

      <li class="nav-item d-none d-sm-inline-block">
  <a href="../logout.php" class="nav-link">
    <i class="nav-icon fas fa-sign-out-alt"></i>
    Log out
  </a>
</li>

    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="media">
              <img class="img-circle img-bordered-sm" src="<?php echo !empty($user['user_image']) ? $user['user_image'] : '../../dist/img/user4-128x128.jpg'; ?>" alt="User profile picture">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="<?php echo BASE_URL; ?>/assets/adminlte/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="<?php echo BASE_URL; ?>/assets/adminlte/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      <img src="<?php echo BASE_URL; ?>/assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
    <div style="width: 50px; height: 50px; overflow: hidden;">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="<?php echo !empty($user['user_image']) ? $user['user_image'] : '../../dist/img/user4-128x128.jpg'; ?>"
                                     alt="User profile picture"
                                     style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
    <div class="info">
          <?php 
          if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['username'])) {
            $loggedInUsername = $_SESSION['username'];
            $loggedInUser = getUserByUsername($loggedInUsername);
            if ($loggedInUser !== false && isset($loggedInUser['name'])) {
                echo '<a href="#" class="d-block">' . $loggedInUser['name'] . '</a>';
            } else {
                echo '<a href="#" class="d-block">' . $loggedInUsername . '</a>';
            }
        } else {
            echo '<a href="#" class="d-block">User</a>';
        }
        ?>
        </div>
      </div>

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item menu-open">
      <a href="<?php echo BASE_URL;?>chef_dashboard/" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
      <i class="nav-icon fas fa-user"></i>
        <p>PROFILE</p>
      </a>
    <li class="nav-item menu-open">
      <a href="<?php echo BASE_URL;?>chef_dashboard/publish.php" class="nav-link <?php echo ($current_page == 'publish.php') ? 'active' : ''; ?>">
      <i class="nav-icon fas fa-pen"></i>
        <p>
          RECIPE
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?php echo BASE_URL;?>chef_dashboard/publish.php" class="nav-link <?php echo ($current_page == 'publish.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-plus"></i>
            <p>CREATE RECIPE</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL;?>chef_dashboard/manage_recipe.php" class="nav-link <?php echo ($current_page == 'users.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-bars"></i>
            <p>MANAGE RECIPE</p>
          </a>
        </li>
      </ul>
      </li>
  </ul>
</nav>
    </div>
  </aside>
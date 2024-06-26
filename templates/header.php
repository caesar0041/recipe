<!--templates/header.php-->
<?php 
ob_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../class.php');
require_once(__DIR__ . '/../function.php'); 
$current_page = basename($_SERVER['PHP_SELF']); 
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="<?php echo BASE_URL;?>/assets/bootstrap/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>RECIPE SHARING APP</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="<?php echo BASE_URL;?>/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL?>assets/style.css">

    <link href="<?php echo BASE_URL;?>assets/bootstrap/carousel.css" rel="stylesheet">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    </svg>
    <style>
    .navbar-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .navbar-nav {
        flex-direction: row;
    }
    .nav-item {
        margin-left: 50px;
    }
    .dropdown-menu {
        right: 0;
        left: auto;
    }
    .profile-dropdown {
        margin-right: 20px; 
    }
</style>
</head>
<body>
    
<header>
<nav class="navbar navbar-expand-md navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">RECIPE SHARING APP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mb-2 mb-md-0 mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>" aria-current="page" href="<?php echo BASE_URL;?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'browse.php') ? 'active' : ''; ?>" href="<?php echo BASE_URL;?>homepage/browse.php">Browse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="<?php echo BASE_URL;?>homepage/contact.php">Contact</a>
                </li>
            </ul>
            
            <ul class="navbar-nav mb-md-0 profile-dropdown">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <?php
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['user_role'])) {
                                if ($_SESSION['user_role'] === 'Admin') {
                                    $dashboardURL = BASE_URL . 'admin_dashboard/';
                                } else if ($_SESSION['user_role'] === 'Chef') {
                                    $dashboardURL = BASE_URL . 'chef_dashboard/';
                                } else {
                                    $dashboardURL = BASE_URL . 'homepage/login.php';
                                }
                            } else {
                                $dashboardURL = BASE_URL . 'homepage/login.php';
                            }
                            ?>
                            <a class="dropdown-item" href="<?php echo $dashboardURL; ?>">Dashboard</a>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL;?>homepage/login.php">Login</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
</header>

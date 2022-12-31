<?php
// DEPENDENCIES
require('vendor/autoload.php');
require_once('class/constants.php');

use App\Users;

$Users = new Users();

// SHOW PHP ERRORS 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CURRENT USER
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $user = $Users->findOne($id);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youx</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="./images/fox.png" type="image/x-icon">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Css File -->
    <link rel="stylesheet" href="./css/component.css">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Js file -->
    <script src="./js/main.js" defer></script>
</head>

<body>
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>home.php" class="nav__logo">Youx<span>.</span></a>
            <a class="btn dark" href="<?= ROOT_URL ?>admin/add-post.php">Publier <i class="fa-sharp fa-solid fa-plus"></i></a>
            <ul class="nav__ul">
                <li><a href="<?= ROOT_URL ?>blog.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/blog.php') : ?> class="active" <?php endif ?>>Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/about.php') : ?> class="active" <?php endif ?>>A propos</a></li>
                <li><a href="<?= ROOT_URL ?>services.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/services.php') : ?> class="active" <?php endif ?>>Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/contact.php') : ?> class="active" <?php endif ?>>Contact</a></li>
                <?php if (isset($_SESSION['user-id'])) : ?>
                    <li class="nav__profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $user['avatar'] ?>" alt="user profile image">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Tableau de bord</a></li>
                            <li><a href="<?= ROOT_URL ?>admin/update-profile.php">Mon profile</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">déconnexion</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php">Connexion</a></li>
                <?php endif ?>
            </ul>
            <button><i class="fa-solid fa-bars" id="menu-btn"></i></button>
        </div>
    </nav>
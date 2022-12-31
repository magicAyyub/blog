<?php
require('../vendor/autoload.php');
require('../class/constants.php');
use App\Category;

$Category = new Category();

// SHOW PHP ERROR IF ISSET
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!$title){
        $_SESSION['add-category'] = "Veuillez entrer un titre";
    }elseif(!$description){
        $_SESSION['add-category'] = "Veuillez entrer une description";
    }

    // REDIRECTION EN CAS D'ERREUR
    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();

    } else{
        
        // INSERTION DANS LA BASE DE DONNEE
        $data = ['title' => "$title",'description' => "$description"];
        $add = $Category->add($data);

        if(!$add){
            $_SESSION['add-category'] = 'Problème lors de l\'ajout veuillez réessayer plus tard';
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        }else{
            $_SESSION['add-category-success'] = "Catégorie $title ajoutée avec succès";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }

    }
}




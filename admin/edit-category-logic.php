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

    // FORM DATA
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // CHECK AND VALIDATE DATA
    if(!$title || !$description) {
        $_SESSION['edit-category'] = 'Tous les champs sont requis !';
    } else{
        // UPDATE
        $data = ['id' => "$id",
                'title' => "$title", 
                'description' => "$description"];

        $update = $Category->update($data,$id);

        if(!$update){
            $_SESSION['edit-category'] = "échec de la mise à jour de la catégorie $title";
        } else{
            $_SESSION['edit-category-success'] = "Catégorie $title mis à jour avec succès !";
        }
    }
}

// REDIRECT TO MANAGE CATEGORIES PAGE
header('location:'. ROOT_URL . 'admin/manage-categories.php');
die();
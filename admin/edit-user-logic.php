<?php
require('../vendor/autoload.php');
require('../class/constants.php');
use App\Users;


$Users = new Users();

// SHOW PHP ERROR IF ISSET
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){
    // FORM DATA
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $l_name = filter_var($_POST['l_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $f_name = filter_var($_POST['f_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'],FILTER_SANITIZE_NUMBER_INT);

    // CHECK AND VALIDATE DATA
    if(!$f_name || !$l_name){
        $_SESSION['edit-user'] = 'Tous les champs sont requis !';
    }else{
        // UPDATE
        $data = ['firstname' => "$f_name", 
                'lastname' => "$l_name", 
                'is_admin' => $is_admin];

        $update = $Users->update($data,$id);

        if(!$update){
            $_SESSION['edit-user'] = "échec de la mise à jour de $f_name";
        } else{
            $_SESSION['edit-user-success'] = "$f_name mis à jour avec succès !";
        }
    }
}

header('location:'. ROOT_URL . 'admin/manage-users.php');
die();

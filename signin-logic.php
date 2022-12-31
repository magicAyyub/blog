<?php
require('vendor/autoload.php');
require('./class/constants.php');
use App\Users;

$Users = new Users();

// Show if is set PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {

    // RECUPERATION DES DONNEES DU FORMULAIRE
    $u_name_email = filter_var($_POST['u_name_email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);

    // VALIDATION DES INPUTS
    if (!$u_name_email) { 
        $_SESSION['signin'] = "nom d'utilisateur ou email obligatoire ";
    } elseif (!$pass) {
        $_SESSION['signin'] = "Mot de passe obligatoire ";
    } else {

        // VERIFIER LA PRESENCE DES DONNEES DANS LA BASE DE 
        $user_db_data = $Users->loginPassword($u_name_email, $u_name_email);
    
        if($user_db_data) {
            if (password_verify($pass, $user_db_data['password'])) {

                // SAUVEGARDE DE L'ID DE L'UTILISATEUR 
                $_SESSION['user-id'] = $user_db_data['id'];

                // METTRE LE TYPE D'UTILISATEUR
                if($user_db_data['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                // LOG USER IN
                header('location: '. ROOT_URL.'home.php');
            } else {
                $_SESSION['signin'] = "email ou mot de passe incorect !";
            }
        } else {
            $_SESSION['signin'] = "utilisateur non trouvé !";
        }
    }
    // REDIRECTION EN CAS D'ERREUR
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data'] = $_POST;
        header('location: '. ROOT_URL.'signin.php');
        die();
    }
} else {
    // REDIRECTION DANS LES AUTRES CAS
    header('location: ' . ROOT_URL . 'signin.php');
}

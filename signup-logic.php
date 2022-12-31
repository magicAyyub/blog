<?php
require('vendor/autoload.php');
require('./class/constants.php');
use App\Users;

$Users = new Users();

// SHOW PHP ERROR IF ISSET
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {

    // FORM DATA
    $lastName = filter_var($_POST['l_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_var($_POST['f_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $userName = filter_var($_POST['u_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password= filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $cpassword = filter_var($_POST['cpass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];


    // INPUT VALIDATION
    if(!$firstName){
        $_SESSION['signup'] = "Veuillez entrer votre nom";
    } elseif(!$lastName){
        $_SESSION['signup'] = "Veuillez entrer votre prénom";
    } elseif(!$email){
        $_SESSION['signup'] = "Veuillez entrer votre email";
    } elseif(strlen($password) < 8 || strlen($cpassword) < 8){
        $_SESSION['signup'] = "Le mot de passe doit faire au moins 8 caractères";
    } elseif(!$avatar['name']){
        $_SESSION['signup'] = "Veuillez ajouter un avatar";
    } else{
        // CHECK IF PASSWORDS MATCH
        if($password !== $cpassword){
            $_SESSION['signup'] = "Les mots de passes ne correspondent pas !";
        } else{
            // HASH PASSWORD
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // CHECK IF USER ALREADY EXISTS 
            if($Users->dataAlreadyExist($userName,$email)){
                $_SESSION['signup'] = "Ce email ou nom d'utilisateur existe déjà !";
            } else{

                // WORKING WITH AVATAR
                // rename image to avoid duplicates
                $time = time(); 
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/'.$avatar_name;

                // CHECK IF FILE IS AN IMAGE
                $allowed_files = ['png','jpg','jpeg'];
                $extention = explode('.',$avatar_name);// ex: fox.png >> ['fox','png']
                $extention = end($extention);// return le dernier (png)

                if(in_array($extention, $allowed_files)){

                    // CHECK IF FILE IS NOT TOO BIG
                    if($avatar['size'] < 1000000){

                        // UPLOAD FILE
                        move_uploaded_file($avatar_tmp_name,$avatar_destination_path);

                    } else{
                        $_SESSION['signup'] = "L'image est trop grande (1mo au maximum)";
                    }
                }else{
                    $_SESSION['signup'] = "Le fichier doit être une image(png, jpg ou jpeg)";
                }
            }

        }

    }

    // REDIRECT TO SIGNUP PAGE IF ERROR
    if(isset($_SESSION['signup'])){
        $_SESSION['signup-data'] = $_POST;
        header('location: '. ROOT_URL.'signup.php');
        die();
    } else{

        // ADD USER TO DATABASE
        $data = ['firstname' => "$firstName", 
        'lastname' => "$lastName", 
        'username' => "$userName", 
        'email' => "$email",
        'password' => "$hashed_password",
        'avatar' => "$avatar_name",
        'is_admin' => 0];

        $signUp = $Users->add($data);
       

        if($signUp){
            $_SESSION['signup-success'] = "Inscription avec succès !";
            header('location: '. ROOT_URL.'signin.php');
            die();
        }

    }

    
}else{
    // REDIRECT TO SIGNUP PAGE IF ERROR
    header('location: '. ROOT_URL.'signup.php');
}

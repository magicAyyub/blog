<?php
require('../vendor/autoload.php');
require('../class/constants.php');
use App\users;

$Users = new Users();

// SHOW PHP ERROR IF ISSET 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])){

    // VARIABLES D'INSCRIPTION
    $lastName = filter_var($_POST['l_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_var($_POST['f_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $userName = filter_var($_POST['u_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password= filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $cpassword = filter_var($_POST['cpass'], FILTER_SANITIZE_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // VALIDATION DES INPUTS
    if(!$firstName){
        $_SESSION['add-user'] = "Veuillez entrer votre nom";
    } elseif(!$lastName){
        $_SESSION['add-user'] = "Veuillez entrer votre prénom";
    } elseif(!$email){
        $_SESSION['add-user'] = "Veuillez entrer votre email";
    }
    elseif(strlen($password) < 8 || strlen($cpassword) < 8){
        $_SESSION['add-user'] = "Le mot de passe doit faire au moins 8 caractères";
    } elseif(!$avatar['name']){
        $_SESSION['add-user'] = "Veuillez ajouter un avatar";
    } else{
        // VERIFIER SI LES MDP CORRESPONDENT
        if($password !== $cpassword){
            $_SESSION['add-user'] = "Les mots de passes ne correspondent pas !";
        } else{
            // CHIFFRER LE MOT DE PASSE
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // VOIR SI EMAIL OU MOT DE PASSE EXITE DEJA 
            if($Users->dataAlreadyExist($userName,$email)){
                $_SESSION['add-user'] = "Ce email ou nom d'utilisateur existe déjà !";
            } else{

                // TRAVAIL SUR L'IMAGE
                // renomination
                $time = time(); // faire de chaque image une unique
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/'.$avatar_name;

                // S'ASSURER QUE L'UPLOAD EST BIEN UNE IMAGE
                $allowed_files = ['png','jpg','jpeg'];
                $extention = explode('.',$avatar_name);// ex: fox.png >> ['fox','png']
                $extention = end($extention);// retourne le dernier (png)

                if(in_array($extention, $allowed_files)){

                    // S'ASSURER N'EST PAS TROP LARGE
                    if($avatar['size'] < 1000000){

                        // UPLOADER L'IMAGE
                        move_uploaded_file($avatar_tmp_name,$avatar_destination_path);

                    } else{
                        $_SESSION['add-user'] = "L'image est trop grande (1mo au maximum)";
                    }
                }else{
                    $_SESSION['add-user'] = "Le fichier doit être une image(png, jpg ou jpeg)";
                }
            }

        }

    }
   
    // REDIRECTION EN CAS D'ERREUR
    if(isset($_SESSION['add-user'])){
        $_SESSION['add-user-data'] = $_POST;
        header('location: '. ROOT_URL.'admin/add-user.php');
        die();
    } else{

        // INSERTION DANS LA BASE DE DONNEE
        $data = ['firstname' => "$firstName", 
        'lastname' => "$lastName", 
        'username' => "$userName", 
        'email' => "$email",
        'password' => "$hashed_password",
        'avatar' => "$avatar_name",
        'is_admin' => $is_admin];
        $signUp = $Users->add($data);
       

        if($signUp){
            $_SESSION['add-user-success'] = "$lastName $firstName ajouté avec succès";
            header('location: '. ROOT_URL.'admin/manage-users.php');
            die();
        }

    }
     

    
}else{
    // REDIRECTION DANS LES AUTRES CAS
    header('location: '. ROOT_URL.'admin/add-user.php');
    die();
}

?>

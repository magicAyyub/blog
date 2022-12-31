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

        // VARIABLES
        $user_id = $_SESSION['user-id'];
        $l_name = filter_var($_POST['l_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $f_name = filter_var($_POST['f_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $u_name = filter_var($_POST['u_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_old_password = filter_var($_POST["user_old_pass"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $old_password = filter_var($_POST["old_pass"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $new_password = filter_var($_POST["pass"], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        $cpassword = filter_var($_POST["cpass"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES["avatar"];
        $previous_avatar_name = filter_var($_POST["old_avatar"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        // validate form data
        if(!$f_name){
            $_SESSION['update-profile'] = "Veuillez entrer votre nom";
        } elseif(!$l_name){
            $_SESSION['update-profile'] = "Veuillez entrer votre prénom";
        } elseif(!$email){
            $_SESSION['update-profile'] = "Veuillez entrer votre email";
        }elseif((password_hash($user_old_password, PASSWORD_DEFAULT) !== $old_password) && empty($user_old_password) && empty($avatar['name'])){
            $_SESSION['update-profile-success'] = "Vous n'avez rien changé revenez quand vous voulez 🙂"; 
        } elseif((password_hash($user_old_password, PASSWORD_DEFAULT) !== $old_password) &&  empty($avatar['name'])){
            $_SESSION['update-profile'] = "L'ancien mot de passe est incorrect"; 
        }else{

            // VERIFIER SI LES MDP CORRESPONDENT
            if(!empty($new_password)){
                if($new_password !== $cpassword){
                    $_SESSION['update-profile'] = "La confirmation du mot de passe est incorrecte";
                } elseif(strlen($new_password) < 8 || strlen($cpassword) < 8){
                    $_SESSION['update-profile'] = "Le mot de passe doit faire au moins 8 caractères";
                } else{

                    // CHIFFRER LE MOT DE PASSE
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                }
            
            }

            // delete existing avatar if new avatar is available
            if (!empty($avatar['name'])) {
                $previous_avatar_path = '../images/' . $previous_avatar_name;
                if ($previous_avatar_path) {
                    unlink($previous_avatar_path);
                }

                // WORK ON avatar
                // rename image
                $time = time(); // make each image name unique
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/'.$avatar_name;

                // Make sure file is an image
                $allowed_files = ['png','jpg','jpeg'];
                $extention = explode('.',$avatar_name);// ex: fox.png >> ['fox','png']
                $extention = end($extention);// retourne le dernier (png)

                if(in_array($extention, $allowed_files)){

                    // make sure image is not too big (max:2mo)
                    if($avatar['size'] < 2000000){

                        // upload avatar
                        move_uploaded_file($avatar_tmp_name,$avatar_destination_path);

                    } else{
                        $_SESSION['update-profile'] = "L'image est trop grande (2mo au maximum)";
                    }
                }else{
                    $_SESSION['update-profile'] = "Le fichier doit être une image(png, jpg ou jpeg)";
                }
            }

            // Récupération des données saisie au préalable en cas d'erreur
            if(isset($_SESSION['update-profile'])){
                header('location: '. ROOT_URL.'admin/update-profile.php');
                die();
            } else{

            // set avatar name if a new one was uploaded, else keep old  avatar name
            $avatar_to_insert = $avatar_name ?? $previous_avatar_name;
            if($hashed_password){
                $password = $hashed_password;
            } else{
                $password = $old_password;
            }
            

            // Update
            $data = [
                'lastname' => $l_name,
                'firstname' => $f_name,
                'username' => $u_name,
                'email' => $email,
                'password' => $password,
                'avatar' => $avatar_to_insert
            ];

            $updated = $Users->update($data,$user_id);
            
            if($updated){
                $_SESSION['update-profile-success'] = "Votre profile a bien été modifié. 😉";
            } 
 
        } 
     
    } 
}

// redirect if user not send data by form
header('location: '. ROOT_URL.'admin/update-profile.php');
die();



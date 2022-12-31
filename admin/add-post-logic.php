<?php
require('../vendor/autoload.php');
require('../class/constants.php');
use App\Posts;

$Posts = new Posts();

if(!isset($_SESSION['user-id'])){
    $_SESSION['login'] = "Veuillez vous connecter pour poster 🫡";
    header('location: '. ROOT_URL.'signin.php');
    die();
}

// SHOW PHP ERROR IF ISSET
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){


    // VARIABLES
    $user_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST["body"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = str_replace('\n', '
    ', $body);
    $is_featured = filter_var($_POST["is_featured"], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES["thumbnail"];
    $category_id = filter_var($_POST["category"], FILTER_SANITIZE_NUMBER_INT);

 
    
    // set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // validate form data
    if(!$title){
        $_SESSION['add-post'] = "Veuillez entrer le titre de votre post";
    }elseif(!$category_id){
        $_SESSION['add-post'] = "Veuillez choisir la catégorie dans laquelle se trouve votre post";
    }
    elseif($category_id === "@"){
        $_SESSION['add-post'] = "Veuillez choisir la catégorie dans laquelle se trouve votre post";
    }
    elseif(!$body){
        $_SESSION['add-post'] = "Veuillez entrer le corp de votre post";
    }elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = "Veuillez ajouter une image au post";
    } else{
            // WORK ON THUMBNAIL
            // rename image
            $time = time(); // make each image name unique
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/'.$thumbnail_name;

            // Make sure file is an image
            $allowed_files = ['png','jpg','jpeg'];
            $extention = explode('.',$thumbnail_name);// ex: fox.png >> ['fox','png']
            $extention = end($extention);// retourne le dernier (png)

            if(in_array($extention, $allowed_files)){

                // make sure image is not too big (max:2mo)
                if($thumbnail['size'] < 2000000){

                    // upload thumbnail
                    move_uploaded_file($thumbnail_tmp_name,$thumbnail_destination_path);

                } else{
                    $_SESSION['add-post'] = "L'image est trop grande (2mo au maximum)";
                }
            }else{
                $_SESSION['add-post'] = "Le fichier doit être une image(png, jpg ou jpeg)";
            }
        }

        // redirect back(with form data) to add-post page if there is any problem
        if(isset($_SESSION['add-post'])){
            $_SESSION['add-post-data'] = $_POST;
            header('location: '. ROOT_URL.'admin/add-post.php');
            die();
        }else{

            // Mettre le is_featured de tous les autres élément à 0 si celui d'un seul est à 1
            $featured_data = ["is_featured" => 0];
            if($is_featured == 1){
                $zero_all = $Posts->update_is_featured($featured_data);
            }
            // Insert post to database
            $data = [
                "title" => "$title",
                "body" => "$body",
                "thumbnail" => "$thumbnail_name",
                "category_id" => $category_id,
                "user_id" => $user_id,
                "is_featured" => $is_featured 
            ];
            $posted = $Posts->add($data);
            
            if($posted){
                $_SESSION['add-post-success'] = "Votre message a bien été posté !🎊🎉";
                header('location: '. ROOT_URL.'admin/index.php');
                die();
            }
    

        }
              

}  
    
// REDIRECTION DANS LES AUTRES CAS
header('location: '. ROOT_URL.'admin/add-post.php');
die();

    

    


    

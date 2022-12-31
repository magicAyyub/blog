<?php
require('../vendor/autoload.php');
require('../class/constants.php');
use App\Posts;

$Posts = new Posts();

// SHOW PHP ERROR IF ISSET
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){

    // VARIABLES
    $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST["body"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $thumbnail = $_FILES["thumbnail"];
    $category_id = filter_var($_POST["category"], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST["is_featured"], FILTER_SANITIZE_NUMBER_INT);
    
    // is_featured égale à 1 si il est coché
    $is_featured = $is_featured == 1 ?: 0; 

    // VALIDATION DU FORMULAIRE
    if(!$title){
        $_SESSION['edit-post'] = "Veuillez entrer le titre de votre post";
    }elseif(!$category_id){
        $_SESSION['edit-post'] = "Veuillez choisir la catégorie dans laquelle se trouve votre post";
    }
    elseif(!$body){
        $_SESSION['edit-post'] = "Veuillez entrer le corps de votre post";
    }else{

            // delete existing thumbnail if new thumbnail is available
            if (!empty($thumbnail['name'])) {
                $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
                if ($previous_thumbnail_path) {
                    unlink($previous_thumbnail_path);
                }
                
            // WORK ON NEW THUMBNAIL
            // rename image
            $time = time(); // make each image name upload unique using current timestamp
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/'.$thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png','jpg','jpeg'];
            $extention = explode('.',$thumbnail_name);// ex: fox.png >> ['fox','png']
            $extention = end($extention);// ex: (png)

            if(in_array($extention, $allowed_files)){

                // make sure avatar(user profile picture) is not too large(max : 2mb)
                if($thumbnail['size'] < 2000000){

                    // Upload avatar
                    move_uploaded_file($thumbnail_tmp_name,$thumbnail_destination_path);

                } else{
                    $_SESSION['edit-post'] = "L'image est trop grande (2mo au maximum)";
                }
            }else{
                $_SESSION['edit-post'] = "Le fichier doit être une image(png, jpg ou jpeg)";
            }
        }   
               
                // Récupération des données saisie au préalable en cas d'erreur
                if(isset($_SESSION['edit-post'])){
                    $_SESSION['edit-post-data'] = $_POST;
                    header('location: '. ROOT_URL.'admin/edit-post.php');
                    die();
                } else{
        
                // set is_featured of all posts to 0 if is_featured for this post is 1
                $featured_data = ["is_featured" => 0];
                if($is_featured == 1){
                    $zero_all = $Posts->update_is_featured($featured_data);
                }
        
                // set thumbnail name if a new one was uploaded, else keep old  thumbnail name
                $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
        
                // Update
                $data = [
                    "title" => "$title",
                    "body" => "$body",
                    "thumbnail" => "$thumbnail_to_insert",
                    "category_id" => "$category_id",
                    "is_featured" => "$is_featured" 
                ];
        
                $posted = $Posts->update($data,$id);
                   
                if($posted){
                    $_SESSION['edit-post-success'] = "Votre message a bien été modifié. 😉";
                } 
            
                } 
            } 
    } 

    // redirect if user not send data by form
    header('location: '. ROOT_URL.'admin/index.php');
    die();
   
    
   
    


    

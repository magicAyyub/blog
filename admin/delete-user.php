<?php 
require('../vendor/autoload.php');
require_once('../class/constants.php');
use App\Users;

$Users = new Users();

if(isset($_GET['delete'])){
    $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    $user = $Users->findOne($delete_id);
    if($user){
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/'.$avatar_name;

        // DELETE USER AVATAR
        if($avatar_path){
            unlink($avatar_path);
        }
    }

    // DELETE USER POSTS
    $thumbnails_to_delete = $Users->thumbnail_delete($delete_id);
    foreach($thumbnails_to_delete as $thumbnail){
        $thumbnail_path = '../images/'.$thumbnail['thumbnail'];
        if(isset($thumbnail_path)){
            unlink($thumbnail_path);
        }
    }




    // DELETE USER DATA
    $user_name = $user['firstname'];
    $delete = $Users->delete($delete_id);
    if(!$delete){
        $_SESSION['delete-user'] = "Un problème s'est produit veuillez réessayer plus tard";

    }else{
        $_SESSION['delete-user-success'] = "Utilisateur $user_name supprimer avec succès !";
    }

}

header('location:' . ROOT_URL . 'admin/manage-users.php');
die();
<?php 
require('../vendor/autoload.php');
require_once('../class/constants.php');
use App\Posts;

$Posts = new Posts();

if(isset($_GET['delete'])){
    $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    $post_data = $Posts->findOne($delete_id);
    $thumbnail_path = '../images/'.$post_data['thumbnail'];
    if(isset($thumbnail_path)){
       unlink($thumbnail_path);
    }
    // DELETE CATEGORY DATA
    $delete = $Posts->delete($delete_id);
    if(!$delete){
        $_SESSION['delete-post'] = "Un problème s'est produit veuillez réessayer plus tard";

    }else{
        $_SESSION['delete-post-success'] = "Votre message a bien été supprimé 😉";
    }

}
header('location:' . ROOT_URL . 'admin/index.php');
die();
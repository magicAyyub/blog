<?php 
require('../vendor/autoload.php');
require_once('../class/constants.php');
use App\Category;

$Category = new Category();

if(isset($_GET['delete'])){
    $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    $current = $Category->findOne($delete_id);
    $category_title = $current['title'];
   
    // IF DELETE UPDATE ID OF POST WHO WAS IN (plus tard)
    $update_post_id = $Category->updateCategoryID($delete_id);


    // DELETE CATEGORY DATA
    $delete = $Category->delete($delete_id);
    if($delete){
        $_SESSION['delete-category-success'] = "Catégorie $category_title supprimé avec succès !";
    }
    

}
header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
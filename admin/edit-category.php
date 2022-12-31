<?php 
include('partials/header.php');
use App\Category;

$Category = new Category();

if(isset($_GET['update'])){
    $id = filter_var($_GET['update'], FILTER_SANITIZE_NUMBER_INT);
    $info_category = $Category->findOne($id);
}else{
    header('location:'. ROOT_URL . 'admin/manage-users.php');
    die();
}
?>


<section class="form__section">
    <div class="container form__section-container">
        <h2>Modification de catégorie</h2>
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $info_category['id']; ?>">
            <input type="text" name="title" value="<?= $info_category['title']; ?>" placeholder="Titre">
            <textarea rows="4" name="description" placeholder="Description"><?= $info_category['description']; ?></textarea>
            <button type="submit" class="btn" name="submit">Modifier la catégorie</button>
        </form>
    </div>
</section>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

<?php 
require('partials/header.php'); 
use App\Posts;

$Posts = new Posts();
$info_posts = $Posts->allCategories();


 // get back form data if there was an error
 $title = $_SESSION['add-post-data']['title'] ?? null;
 $body = $_SESSION['add-post-data']['body'] ?? null;

 // delete session data after using 
 unset($_SESSION['add-post-data']);

?>
<!-- End Nav -->

<section class="form__section">
    
    <div class="container form__section-container">
        <h2>Publication</h2>
        <?php if(isset($_SESSION['add-post'])) : ?>
        <div class="alert__message absolute error">
            <p>
                <?= $_SESSION['add-post'];?>   
                <?php unset($_SESSION['add-post']); ?>         
            </p>
        </div>
        <?php elseif(!isset($_SESSION['user-id'])) : ?>
        <div class="alert__message success">
            <p>
                Vous devez être connecté pour publier un article. <br> <a href="<?= ROOT_URL ?>signin.php">Se connecter</a> | <a href="<?= ROOT_URL ?>signup.php">S'inscrire</a>            
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title; ?>" placeholder="Titre">
            <select name="category">
                <option value="@">choisir une catégorie</option>
                <?php foreach($info_posts as $post): ?>
                <option value="<?= $post['id']; ?>"><?= $post['title']; ?></option>   
                <?php endforeach ?>   
            </select>
            <textarea rows="10" name="body" placeholder="Corps"><?= $body; ?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])):?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Mettre à la une</label>
            </div>
            <?php endif?>
            <div class="form__control">
                <label for="thumbnail">Ajouter une image</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Publier</button>
        </form>
    </div>
</section>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

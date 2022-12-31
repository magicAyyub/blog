<?php 
        require('partials/header.php'); 
        use App\Posts;
        $Posts = new Posts();

       if(isset($_GET['update'])){
        $id = filter_var($_GET['update'], FILTER_SANITIZE_NUMBER_INT);
        $info_post = $Posts->findOne($id);
        $posts = $Posts->allCategories();
    }else{
        header('location:'. ROOT_URL . 'admin/index.php');
        die();
    }
?>
<!-- End header -->

<section class="form__section">
    <div class="container form__section-container">
        <h2>Modification de post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden"  name="id" value="<?= $info_post['id'] ?>">
            <input type="hidden"  name="previous_thumbnail_name" value="<?= $info_post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= $info_post['title'] ?>" placeholder="Titre">
            <select name="category">
                <?php foreach($posts as $post): ?>
                    <option value="<?= $post['id']; ?>"><?= $post['title']; ?></option>   
                <?php endforeach ?> 
            </select>
            <textarea rows="10" name="body" placeholder="Corps"><?= $info_post['body'] ?></textarea>
            <div class="form__control inline">
                <input type="checkbox" value="1" name="is_featured"  id="is_featured" checked>
                <label for="is_featured">Mettre à la une</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Changer l'image</label>
                <input type="file"  name="thumbnail"  id="thumbnail">
            </div>
            <button type="submit" name="submit"  class="btn">Modifier la publication</button>
        </form>
    </div>
</section>


<?php include('../partials/footer.php'); ?>
<!-- End footer -->

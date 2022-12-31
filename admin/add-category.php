<?php
 require('./partials/header.php');

 // get back form data if there was an error
 $title = $_SESSION['add-category-data']['title'] ?? null;
 $description = $_SESSION['add-category-data']['description'] ?? null;

 // delete session data after using 
 unset($_SESSION['add-category-data']);

?>
<!-- End Nav -->

<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout de Catégorie</h2>
        <?php if(isset($_SESSION['add-category'])) : ?>
            <div class="alert__message absolute error">
                <p>
                    <?= 
                        $_SESSION['add-category'];
                        unset($_SESSION['add-category']);
                     ?>
                </p>
            </div>
        <?php endif?>
        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
            <input type="text" name="title" value="<?= $title ;?>" placeholder="Titre">
            <textarea rows="4"name="description"  value="<?= $description ;?>" placeholder="Description"></textarea>
            <button type="submit" class="btn" name="submit">Ajouter la catégorie</button>
        </form>
    </div>
</section>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

<?php
    require('vendor/autoload.php');
    use App\Posts;
    if(!isset($Posts)){
        $Posts = new Posts();
    } 

?>

<?php $categories = $Posts->allCategories(); ?>
<section class="category__buttons">
    <div class="container center">
        <h2>Catégories :</h2> 
    </div>
    <div class="container category__buttons-container">
        <?php foreach($categories as $category):?>
        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category["title"]?> </a>
        <?php endforeach ?>
    </div>
</section>
<!-- End category buttons -->
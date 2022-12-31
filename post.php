<?php 
require('vendor/autoload.php');
include('partials/header.php');
use App\Posts;

$Posts = new Posts();

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $posted = $Posts->findOne($id);

}else{
    header('Location: '. ROOT_URL.'blog.php');
    die();
}

?>
<!-- End header -->

<section class="singlepost">
<?php
    $post_category_id = $posted["category_id"];
    $post_category = $Posts->oneCategory($post_category_id);  
    
    $post_user_id = $posted['user_id'];
    $post = $Users->findOne($post_user_id);
?>
    <div class="container singlepost__container">
        <h2><?= $posted["title"] ?></h2>
        <div class="post__author">
            <div class="post__author-avatar">
                <img src="images/<?= $post["avatar"] ?>" alt="">
            </div>
            <div class="post__author-info">
                <h5>Par ~ <?= $post["username"] ?></h5>
                <small>
                    <?= date("d M, Y - H:i", strtotime($posted['date_time'])) ?>
                </small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="images/<?= $posted["thumbnail"] ?>" alt="">
        </div>
        <article><?= nl2br($posted['body']) ?></article>
    </div>
</section>
<!-- End single post -->

<?php include('partials/footer.php'); ?>
<!-- End footer -->
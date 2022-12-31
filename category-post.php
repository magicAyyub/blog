<?php 
require('vendor/autoload.php');
include('partials/header.php');
use App\Posts;

$Posts = new Posts();

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);   
    $user_posts = $Posts->postByCategory($id);
   
    $category = $Posts->oneCategory($id); 
}else{
    header('Location: '. ROOT_URL.'blog.php');
    die();
}


?>
<!-- End header -->

<header class="category__title">

    <h2>Catégorie <?= $category["title"] ?></h2>
</header>
<!-- End category title -->

<?php if($user_posts): ?>
<section class="posts">
    <div class="container posts__container">
        <?php foreach($user_posts as $user_post): ?>
            <?php
                $post_category_id = $user_post["category_id"];
                $post_category = $Posts->oneCategory($post_category_id);  
                
                $post_user_id = $user_post['user_id'];
                $post = $Users->findOne($post_user_id);
            ?>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./images/<?= $user_post["thumbnail"] ?>" alt="">
            </div>
            <div class="post__info">
                <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $user_post["id"] ?>"><?= $user_post["title"] ?></a></h3>
                <p class="post__body">
                <?= substr($user_post["body"], 0,300); ?>...
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="images/<?= $post["avatar"] ?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>Par ~ <?= $post["username"] ?></h5>
                        <small> 
                            <?= date("d M, Y - H:i", strtotime($user_post['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach ?>
    </div>
</section>
<?php else : ?>
    <br>
    <div class="alert__message container success">
        <p>Aucun post dans cette catégorie pour le moment🙂.</p>         
    </div> 
<?php endif ?>

<!-- End posts -->

<?php include('category_buttons.php'); ?>
<!-- End category buttons -->

<?php include('partials/footer.php'); ?>
<!-- End footer -->
<?php 
    require('vendor/autoload.php');
    include('./partials/header.php'); 
    use App\Posts;

    if(isset($_SESSION['user-id'])){
        $current_user_id = $_SESSION['user-id'];
    }
    
    $Posts = new Posts();
    
    // Featured part
    $post_featured = $Posts->post_featured();
    if($post_featured){
        $category_id = $post_featured["category_id"];
        $category = $Posts->oneCategory($category_id);
        $user_featured_id = $post_featured['user_id'];
        $user_featured = $Users->findOne($user_featured_id);
    }   
    // 9 posts
    $user_posts = $Posts->all_posts();
?>
<!-- End header -->

<section class="search__bar">
    <form class="container search__bar-container" action="search.php" method="GET">
        <div>
            <span class="material-icons-outlined">search</span>
            <input type="search" name="search" placeholder="recherche">
        </div>
        <button type="submit" name="submit" class="btn">Go</button>
    </form>
</section>
<!-- End search -->

<section class="posts <?= $post_featured ? '' : 'section__extra-margin' ?> ">
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
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $user_post["category_id"] ?>" class="category__button"><?= $post_category["title"] ?></a>
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
<!-- End posts -->

<?php include('category_buttons.php'); ?>
<!-- End category buttons -->

<?php include('partials/footer.php'); ?>
<!-- End footer --
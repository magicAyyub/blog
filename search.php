<?php
require('vendor/autoload.php');
include('./partials/header.php');
use App\Posts;

$Posts = new Posts();

// SHOW PHP ERROR IF ISSET
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['search']) && isset($_GET['submit'])) {
    if (!empty($_GET['search'])) {
        $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $posts = $Posts->searchPost($search);
    }
} else {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}

?>
<!-- End header -->

<?php if ($posts) : ?>
    <section class="posts section__extra-margin">
        <div class="container posts__container">
            <?php foreach ($posts as $user_post) : ?>
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
                            <?= substr($user_post["body"], 0, 300); ?>...
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
    <section class="posts section__extra-margin">
        <div class="alert__message container error">
            <p>Aucune résultat trouvé pour "<?= $search ?>"</p>
        </div>
    </section>
<?php endif ?>


<div class="container category__buttons-container m">
    <a href="<?= ROOT_URL ?>category-post.php" class="btn danger"><i class="fa-solid fa-backward"></i> revenir </a>
</div>
<?php include('partials/footer.php'); ?>
<!-- End footer -->
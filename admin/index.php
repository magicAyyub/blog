<?php 
    include('./partials/header.php'); 
    use App\Posts;
    $current_user_id = $_SESSION['user-id'];

    $Posts = new Posts();
    
    $data = ["id","title","category_id","is_featured"];
    $user_posts = $Posts->findJoin($data,$current_user_id);

?>


<!-- End header -->

<section class="dashboard">
    <?php if(isset($_SESSION['add-post-success'])) : // MESSAGE DE SUCCES DE L'AJOUT?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['add-post-success']; ?></p>
            <?php unset($_SESSION['add-post-success']); ?>
        </div>
    <?php elseif(isset($_SESSION['add-post'])) : // MESSAGE DE SUCCES DE L'AJOUT?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['add-post']; ?></p>
            <?php unset($_SESSION['add-post']); ?>
        </div>
    <?php elseif(isset($_SESSION['edit-post-success'])) : // MESSAGE DE SUCCES DE LA MODIF?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['edit-post-success']; ?></p>
            <?php unset($_SESSION['edit-post-success']); ?>
        </div>
    <?php elseif(isset($_SESSION['edit-post'])) : // MESSAGE DE SUCCES DE LA MODIF?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['edit-post']; ?></p>
            <?php unset($_SESSION['edit-post']); ?>
        </div>
    <?php elseif(isset($_SESSION['delete-post-success'])) : // MESSAGE DE SUCCES DE LA MODIF?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['delete-post-success']; ?></p>
            <?php unset($_SESSION['delete-post-success']); ?>
        </div>
    <?php elseif(isset($_SESSION['delete-post'])) : // MESSAGE DE SUCCES DE LA MODIF?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['delete-post']; ?></p>
            <?php unset($_SESSION['delete-post']); ?>
        </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button class="angle"><i class="fa-solid fa-angle-left" id="dashbord-btn"></i></button>
        <?php require('./partials/aside.php'); ?>
        <main>
            <h2>Mes posts</h2>
            <?php if($Posts->numberPost($current_user_id) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>catégorie</th>
                        <th>Modifier</th>
                        <th>supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($user_posts as $user_post): ?>
                    <?php 
                        $id = $user_post['category_id'];
                        $is_featured = $user_post['is_featured'];
                     ?>
                    <tr>
                        <td><?php if($is_featured === "1"): ?>⭐<?php endif?><?=$user_post['title']?></td>
                        <td><?= $Posts->oneCategory($id)['title']?></td>
                        <td><a href="edit-post.php?update=<?= $user_post['id'] ?>" class="btn sm">Modifier</a></td>
                        <td><a href="delete-post.php?delete=<?= $user_post['id'] ?>" class="btn sm danger" onclick='return confirm("Voulez-vous vraiment supprimer ce post ?");'>Supprimer</a></td>
                    </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__message success">
                    <p>Aucune publication pour le moment🙂.</p>         
                </div> 
            <?php endif ?>
        </main>
    </div>
</section>

<div class="container category__buttons-container container">
    <a href="<?= ROOT_URL ?>home.php" class="btn danger"><i class="fa-solid fa-backward"></i> Voir les posts </a>
</div>
<br>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

<?php 
include('./partials/header.php');
use App\Category;

$current_user_id = $_SESSION['user-id'];
$Category = new Category();

$categories = $Category->categoriesByOrder();
?>

<!-- End header -->

<section class="dashboard">
    <?php if(isset($_SESSION['add-category-success'])) : // MESSAGE DE SUCCES DE L'AJOUT?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['add-category-success']; ?></p>
            <?php unset($_SESSION['add-category-success']); ?>
        </div>
    <?php elseif(isset($_SESSION['add-category'])) : // MESSAGE DE SUCCES DE L'AJOUT?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['add-category']; ?></p>
            <?php unset($_SESSION['add-category']); ?>
        </div>
    <?php elseif (isset($_SESSION['edit-category-success'])) : // MESSAGE DE SUCCES DE LA MAJ?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['edit-category-success']; ?></p>
            <?php unset($_SESSION['edit-category-success']); ?>
        </div>
    <?php elseif (isset($_SESSION['edit-category'])) : // MESSAGE D'ERREUR DE LA MAJ ?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['edit-category']; ?></p>
            <?php unset($_SESSION['edit-category']); ?>
        </div>
    <?php elseif (isset($_SESSION['delete-category-success'])) : // MESSAGE DE SUCCES DE LA MAJ?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['delete-category-success']; ?></p>
            <?php unset($_SESSION['delete-category-success']); ?>
        </div>
    <?php elseif (isset($_SESSION['delete-category'])) : // MESSAGE D'ERREUR DE LA MAJ ?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['delete-category']; ?></p>
            <?php unset($_SESSION['delete-category']); ?>
        </div>
    <?php endif?>
    <div class="container dashboard__container">
        <button class="angle"><i class="fa-solid fa-angle-left" id="dashbord-btn"></i></button>
        <?php require('./partials/aside.php'); ?>
        <main>
            <h2>Catégories</h2>
            <?php if(count($categories)>0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>modifier</th>
                        <th>supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $categorie): ?>
                        <?php $title = $categorie['title']; ?>
                    <tr>
                        <td><?= $title ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php?update=<?= $categorie['id']; ?>" class='btn sm'>Modifier</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-category.php?delete=<?= $categorie['id']; ?>" class='btn sm danger' onclick='return confirm("Voulez-vous vraiment supprimer la catégorie <?= $title ?>?");'>Supprimer</a></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert__message success">
                    <p>Aucune catégorie trouvé pour le moment.🙂</p>         
                </div> 
            <?php endif?>
        </main>
    </div>
</section>


<?php include('../partials/footer.php'); ?>
<!-- End footer -->

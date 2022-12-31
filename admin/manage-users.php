<?php
require('partials/header.php');
$current_admin_id = $_SESSION['user-id'];

$users = $Users->findAll($current_admin_id);
?>
<!-- End header -->
<section class="dashboard">
    <?php if(isset($_SESSION['add-user-success'])) : // MESSAGE DE SUCCES DE L'AJOUT?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['add-user-success']; ?></p>
            <?php unset($_SESSION['add-user-success']); ?>
        </div>
    <?php elseif (isset($_SESSION['edit-user-success'])) : // MESSAGE DE SUCCES DE LA MAJ?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['edit-user-success']; ?></p>
            <?php unset($_SESSION['edit-user-success']); ?>
        </div>
    <?php elseif (isset($_SESSION['edit-user'])) : // MESSAGE D'ERREUR DE LA MAJ ?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['edit-user']; ?></p>
            <?php unset($_SESSION['edit-user']); ?>
        </div>
    <?php elseif (isset($_SESSION['delete-user-success'])) : // MESSAGE DE SUCCES DE LA MAJ?>
        <div class="alert__message success  container">
            <p><?= $_SESSION['delete-user-success']; ?></p>
            <?php unset($_SESSION['delete-user-success']); ?>
        </div>
    <?php elseif (isset($_SESSION['delete-user'])) : // MESSAGE D'ERREUR DE LA MAJ ?>
        <div class="alert__message error  container">
            <p><?= $_SESSION['delete-user']; ?></p>
            <?php unset($_SESSION['delete-user']); ?>
        </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button class="angle"><i class="fa-solid fa-angle-left" id="dashbord-btn"></i></button>
        <?php require('./partials/aside.php'); ?>
        <main>
            <h2>Utilisateurs</h2>
            <?php if(count($users) > 0) :?>
            <table>
                <thead>
                    <tr>
                        <th>Nom - Prénom</th>
                        <th>Nom d'utilisateur</th>
                        <th>Modifier</th>
                        <th>supprimer</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['lastname']; ?> - <?= $user['firstname']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-user.php?update=<?= $user['id']; ?>" class="btn sm">Modifier</a></td>
                        <td><a href="<?= ROOT_URL?>admin/delete-user.php?delete=<?= $user['id']; ?>" class="btn sm danger" onclick='return confirm("Voulez-vous vraiment supprimer <?= $user["firstname"]; ?> ?");'>Supprimer</a></td>
                        <td><?php if($user['is_admin'] == 0):?>
                                Non
                            <?php else:?>
                                Oui
                            <?php endif ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__message error">
                    <p>Aucun utilisateur trouvé.</p>         
                </div> 
            <?php endif ?>
        </main>
    </div>
</section>

<?php include('../partials /footer.php'); ?>
<!-- End footer -->

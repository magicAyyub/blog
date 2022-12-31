<?php 
include('partials/header.php');

if(isset($_GET['update'])){
    $id = filter_var($_GET['update'], FILTER_SANITIZE_NUMBER_INT);
    $user = $Users->findOne($id);
}else{
    header('location:'. ROOT_URL . 'admin/manage-users.php');
    die();
}
?>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Utilisateurs</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" name="id" value="<?=$user["id"];?>">
            <input type="text" name="l_name" value="<?=$user["lastname"];?>" placeholder="Nom">
            <input type="text" name="f_name" value="<?=$user["firstname"];?>" placeholder="Prenom">

            <label for="role">rôle</label>
            <select id="role" name="userrole">
                <option value="0">user</option>
                <option value="1">admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Modifier l'utilisateur</button>
        </form>
    </div>
</section>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

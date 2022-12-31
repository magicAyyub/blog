<?php  
    include('partials/header.php');

    if(isset($_SESSION['user-id'])){
        $id = $_SESSION['user-id'];
        $user = $Users->findOne($id);
    }

?>
<!-- End header -->
<section class="form__section"> 
        <div class="preview_profile">
            <img src="../images/<?= $user['avatar'] ?>" alt="preview user profile">
        </div>
    <div class="container form__section-container">
        <h2>Mon profile</h2>
        <?php if(isset($_SESSION['update-profile'])) : ?>
        <div class="alert__message absolute error">
            <p>
                <?= $_SESSION['update-profile']; ?> 
                <?php  unset($_SESSION['update-profile']); ?>           
            </p>
        </div>
        <?php elseif(isset($_SESSION['update-profile-success'])) : ?>
        <div class="alert__message absolute success">
            <p>
                <?= $_SESSION['update-profile-success']; ?> 
                <?php  unset($_SESSION['update-profile-success']); ?>           
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/update-profile-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="l_name" value="<?= $user["lastname"] ?>" placeholder="Nom">
            <input type="text" name="f_name" value="<?= $user["firstname"]  ?>" placeholder="Prenom">
            <input type="text" name="u_name" value="<?= $user["username"]  ?>" placeholder="Nom d'utilisateur">
            <input type="email" name="email" value="<?= $user["email"]  ?>" placeholder="Email">
            <input type="password" name="user_old_pass" placeholder="Entrer l'ancien mot de passe">
            <input type="password" name="pass" placeholder="Entrer un mot de passe">
            <input type="hidden" name="old_pass" value="<?= $user["password"] ?>">
            <input type="password" name="cpass"placeholder="Confirmer le mot de passe">
            <div class="form__control">
                <label for="avatar">Nouvelle photo de profile</label>
                <input type="file" name="avatar" accept="image/jpg, image/jpeg, image/png" id="avatar">
                <input type="hidden" name="old_avatar" value="<?= $user["avatar"] ?>">
            </div>
            <button type="submit" class="btn" name="submit">Enregistrer</button>
        </form>
    </div>
</section>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

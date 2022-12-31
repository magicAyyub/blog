<?php  
    include('partials/header.php');

    // get back form data if there was an error
    $f_name = $_SESSION['add-user-data']['f_name'] ?? null;
    $l_name = $_SESSION['add-user-data']['l_name'] ?? null;
    $u_name = $_SESSION['add-user-data']['u_name'] ?? null;
    $email = $_SESSION['add-user-data']['email'] ?? null;
    $pass = $_SESSION['add-user-data']['pass'] ?? null;
    $cpass = $_SESSION['add-user-data']['cpass'] ?? null;
    
    // delete session data after using 
    unset($_SESSION['add-user-data']);

?>
<!-- End header -->

<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'utilisateur</h2>
        <?php if(isset($_SESSION['add-user'])) : ?>
        <div class="alert__message absolute error">
            <p>
                <?= $_SESSION['add-user']; 
                    unset($_SESSION['add-user']); ?>           
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="l_name" value="<?= $l_name ?>" placeholder="Nom">
            <input type="text" name="f_name" value="<?= $f_name ?>" placeholder="Prenom">
            <input type="text" name="u_name" value="<?= $u_name ?>" placeholder="Nom d'utilisateur">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password" name="pass" value="<?= $pass ?>" placeholder="Entrer un mot de passe">
            <input type="password" name="cpass" value="<?= $cpass ?>" placeholder="Confirmer le mot de passe">
            <select name="userrole">
                <option value="0">user</option>
                <option value="1">admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">Photo de profile</label>
                <input type="file" name="avatar" accept="image/jpg, image/jpeg, image/png" id="avatar">
            </div>
            <button type="submit" class="btn" name="submit">Ajouter l'utilisateur</button>
        </form>
    </div>
</section>

<?php include('../partials/footer.php'); ?>
<!-- End footer -->

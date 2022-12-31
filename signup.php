<?php
    require('./class/constants.php');

    // get back form data if there was an error
    $f_name = $_SESSION['signup-data']['f_name'] ?? null;
    $l_name = $_SESSION['signup-data']['l_name'] ?? null;
    $u_name = $_SESSION['signup-data']['u_name'] ?? null;
    $email = $_SESSION['signup-data']['email'] ?? null;
    $pass = $_SESSION['signup-data']['pass'] ?? null;
    $cpass = $_SESSION['signup-data']['cpass'] ?? null;

    // delete user data
    unset($_SESSION['signup-data']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youx</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/fox.png" type="image/x-icon">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Css File -->
    <link rel="stylesheet" href="<?= ROOT_URL?>css/component.css">
    <link rel="stylesheet" href="<?= ROOT_URL?>css/style.css">
    <!-- Js file -->
    <script src="<?= ROOT_URL?>/main.js" defer></script>
</head>

<body>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Inscription</h2>
            <?php if(isset($_SESSION['signup'])) :?>
            <div class="alert__message absolute error">
                <p>
                    <?= $_SESSION['signup'];?> 
                    <?php unset($_SESSION['signup']); ?>                   
                </p>
            </div>               
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signup-logic.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="l_name" value="<?=$l_name?>" placeholder="Nom">
                <input type="text" name="f_name" value="<?=$f_name?>" placeholder="Prenom">
                <input type="text" name="u_name" value="<?=$u_name?>" placeholder="Nom d'utilisateur">
                <input type="email" name="email" value="<?=$email?>" placeholder="Email">
                <input type="password" name="pass" value="<?=$pass?>" placeholder="Entrer un mot de passe">
                <input type="password" name="cpass" value="<?=$cpass?>" placeholder="Confirmer le mot de passe">
                <div class="form__control">
                    <label for="avatar">Photo de profile</label>
                    <input type="file" name="avatar" id="avatar" accept="image/jpg, image/jpeg, image/png">
                </div>
                <button type="submit" class="btn" name="submit">S'inscrire</button>
                <small>Vous avez déjà un compte ? <a href="signin.php">Se connecter</a></small>
            </form>
        </div>
    </section>
</body>

</html>
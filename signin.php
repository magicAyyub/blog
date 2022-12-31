<?php 
require('class/constants.php');

 // EN CAS D'ERREUR DANS LE TRAITEMENT SUR L'AUTRE PAGE
 $u_name_email = $_SESSION['signin-data']['u_name_email'] ?? null;
 $pass = $_SESSION['signin-data']['pass'] ?? null;

 // SUPPRESSION APRES UTILISATION
 unset($_SESSION['sigin-data']);
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
    <link rel="stylesheet" href="css/component.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Js file -->
    <script src="js/main.js" defer></script>
</head>

<body>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Connexion</h2>
            <?php if(isset($_SESSION['signup-success'])): ?>
            <div class="alert__message absolute success">
                <p><?= $_SESSION['signup-success']; ?></p>
                <?php unset($_SESSION['signup-success']); ?>
            </div>               
            <?php elseif(isset($_SESSION['signin'])):?>
                <div class="alert__message absolute error">
                <p><?= $_SESSION['signin']; ?></p>
                <?php unset($_SESSION['signin']); ?>
            </div> 
            <?php elseif(isset($_SESSION['login'])) : ?>
            <div class="alert__message absolute error">
                <p>
                    <?= $_SESSION['login'];?>   
                    <?php unset($_SESSION['login']); ?>         
                </p>
            </div>
        
            <?php endif ?>    
            <form action="<?= ROOT_URL?>signin-logic.php" method="POST">
                <input type="text" name="u_name_email" value="<?=$u_name_email?>" placeholder="Email ou Nom d'utilisateur">
                <input type="password" name="pass"  value="<?=$pass?>" placeholder="Entrer un mot de passe">
                <button type="submit" class="btn" name="submit">Se connecter</button>
                <small>Vous n'avez pas de compte ? <a href="signup.php">S'inscrire</a></small>
            </form>
        </div>
    </section>
</body>

</html>
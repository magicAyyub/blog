<aside>
    <ul>
        <li>
            <a href="add-post.php">
                <i class="material-icons-outlined">post_add</i>
                <h5>Publier</h5>
            </a>
        </li>
        <li>
            <a href="index.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/admin/index.php') : ?> class="active" <?php endif ?>>
                <i class="material-icons-outlined">article</i>
                <h5>Mes publications</h5>
            </a>
        </li>
        <?php if (isset($_SESSION['user_is_admin'])) : ?>
            <li>
                <a href="add-user.php">
                    <i class="material-icons-outlined">person_add_alt</i>
                    <h5>Ajout d'utilisateur</h5>
                </a>
            </li>
            <li>
                <a href="manage-users.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/admin/add-user.php') : ?> class="active" <?php endif ?>>
                    <i class="material-icons-outlined">manage_accounts</i>
                    <h5>Utilisateurs</h5>
                </a>
            </li>
            <li>
                <a href="add-category.php">
                    <i class="material-icons-outlined">queue</i>
                    <h5>Ajout de catégorie</h5>
                </a>
            </li>
            <li>
                <a href="manage-categories.php" <?php if ($_SERVER['SCRIPT_NAME'] === '/TP/admin/manage-categories.php') : ?> class="active" <?php endif ?>>
                    <i class="material-icons-outlined">format_list_bulleted</i>
                    <h5>Catégories</h5>
                </a>
            </li>
        <?php endif ?>
    </ul>
</aside>
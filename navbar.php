<style>
    <?php include 'static/css/index.css'; ?>
</style>
<div class="navbar">
    <a href="/php_forum/login.php">Connexion</a>
    <a href="/php_forum/register.php">Inscription</a>
    <a href="/php_forum/home.php">Accueil</a>
    <a href="/php_forum/new.php">Nouveau Post</a>
    <a href="/php_forum/account.php">Compte</a>
    <a href="/php_forum/login_admin.php">Connexion Admin</a>
    <a href="/php_forum/register_admin.php">Inscription Admin</a>
    <a href="/php_forum/panel_admin.php">Panel Admin</a>
    <form class="searchbar" method="get" action="/php_forum/home.php">
        <input type="text" placeholder="Cherchez un article" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <input type="submit">
    </form>
    <form method="POST">
        <?php if (isset($_COOKIE['UserId']) || isset($_COOKIE['AdminId'])) : ?>
            <button type="submit" class="disconnectbtn" name="deconnexion">Deconnexion</button>
            <?php
            if (isset($_POST['deconnexion'])) {
                setcookie('UserId', '', time() - 3600);
                setcookie('AdminId', '', time() - 3600);
                header('location: index.php');
            }
            ?>
        <?php endif ?>
    </form>
</div>
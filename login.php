<?php
$errors = array();
if (isset($_POST['login_user'])) {
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"

    $email = mysqli_real_escape_string($mysqli, $_POST['user_mail']);
    $password = mysqli_real_escape_string($mysqli, $_POST['user_password']);

    // $md5password = md5($password);

    $bcryptpassword = password_hash($password, PASSWORD_BCRYPT);

    $results = $mysqli->query("SELECT UserId, Password FROM Users WHERE Email='$email'");
    // echo mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 1) {


        // Numeric array
        $data = mysqli_fetch_array($results);

        if (password_verify($password, $data['Password'])) {

            setcookie('UserId', $data['UserId']);
            setcookie('AdminId', '', time() - 3600);
            header('location: index.php');
        } else {
            array_push($errors, "Wrong email/password combination");
        }
    } else {
        array_push($errors, "Wrong email/password combination");
    }
}

?>

<?php if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php endif ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Forum</title>
    <link rel="icon" href="/static/img/icon/forum.png">
    <link rel="stylesheet" href="/static/css/logincss.php">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <style>
        <?php include 'static/css/login.css'; ?>
    </style>
</head>

<body>
    <div class="navbar">
        <a href="/php_forum/login.php">Connexion</a>
        <a href="/php_forum/register.php">Inscription</a>
        <a href="/php_forum/home.php">Accueil</a>
        <a href="/php_forum/new.php">Nouveau Post</a>
        <a href="/php_forum/details.php">Details</a>
        <a href="/php_forum/edit.php">Modifier</a>
        <a href="/php_forum/account.php">Compte</a>
        <a href="/php_forum/login_admin.php">Connexion Admin</a>
        <a href="/php_forum/panel_admin.php">Panel Admin</a>
        <form class="searchbar" method="post">
            <input type="text" placeholder="Cherchez un article" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <input type="submit" name="submit">
        </form>
        
    </div>
    <div class="connexion">
        <h1 class="pageTitle">Connexion</h1>
        <div class="loginForm">
            <form action="" method="POST">
                <div id="mail">
                    <br>
                    <label for="mail"> E-mail : </label>
                    <br>
                    <input type="email" id="mail" name="user_mail" required>
                </div>
                <div id="mdp">
                    <label for="password"> Mot de passe : </label>
                    <br>
                    <input type="password" id="password" name="user_password" required>
                </div>
                <div class="btnLogin">
                    <button class="LOGIN" type="submit" name="login_user">Se connecter</button>
                </div>
            </form>
        </div>
        <div class="otherLogin padding flex">
            <div class="O-inscription">
                <p>Vous n'avez pas de compte ?</p>
                <a class="REGISTER" href="/php_forum/register.php">Inscrivez-vous ici</a>
            </div>
        </div>
    </div>
</body>

</html>
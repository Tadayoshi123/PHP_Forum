<?php include('functions.php'); ?>

<?php
$errors = array();
if (isset($_POST['login_user'])) {
    //----------------------------------
    $email = string_db($_POST['user_mail']);
    $password = string_db($_POST['user_password']);
    $bcryptpassword = password_hash($password, PASSWORD_BCRYPT);
    $results = select_db("SELECT UserId, Password FROM Users WHERE Email='$email'");

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
    <title>Connexion</title>
    <style>
        <?php include 'static/css/login.css'; ?>
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
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
        <div class="otherLogin">
            <p>Vous n'avez pas de compte ?</p>
            <a class="REGISTER" href="/php_forum/register.php">Inscrivez-vous ici</a>
        </div>
    </div>
</body>

</html>
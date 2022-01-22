<?php
$errors = array();
if (isset($_POST['admin_login'])) {
    //-----------------------------------------------------
    $admin_name = mysqli_real_escape_string($mysqli, $_POST['admin_name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['admin_password']);
    $results = select_db("SELECT AdminId, Password FROM Admins WHERE AdminName='$admin_name'");

<<<<<<< HEAD
=======

    $results = $mysqli->query("SELECT AdminId, Password FROM Admin WHERE AdminName='$admin_name'");

>>>>>>> 724fed4670108f4aee28a335cd9c816983638acf
    if (mysqli_num_rows($results) == 1) {

        // Numeric array
        $data = mysqli_fetch_array($results);


        if (password_verify($password, $data['Password'])) {

            setcookie('AdminId', $data['AdminId']);
            setcookie('UserId', '', time() - 3600);
            header('location: index.php');
        } else {
            array_push($errors, "Wrong email/password combination");
        }
    } else {
        array_push($errors, "Wrong email/password combination");
    }
}

?>

<<<<<<< HEAD
<?php print_error($errors); ?>
=======
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
    <title>Connexion Admin</title>
    <style>
        <?php include 'static/css/login.css'; ?>
    </style>
</head>


<body>
    <?php include('navbar.php'); ?>
    <div class="connexion">
        <h1 class="pageTitle">Connexion Admin</h1>
        <div class="loginForm">
            <form action="" method="POST">
                <div id="mail">
                    <br>
                    <label for="admin"> Admin Name : </label>
                    <br>
                    <input id="admin" name="admin_name" required>
                </div>
                <div id="mdp">
                    <label for="password"> Mot de passe : </label>
                    <br>
                    <input type="password" id="password" name="admin_password" required>
                </div>
                <div class="btnLogin">
                    <button class="LOGIN" type="submit" name="admin_login">Connexion</button>
                </div>
            </form>
        </div>
        <div class="otherLogin">
            <p>Vous n'avez pas de compte ?</p>
            <a class="REGISTER" href="/php_forum/register_admin.php">Inscrivez-vous ici</a>
        </div>
    </div>
</body>

</html>
>>>>>>> 724fed4670108f4aee28a335cd9c816983638acf

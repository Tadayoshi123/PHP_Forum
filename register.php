<?php include('functions.php'); ?>

<?php

$errors = array();



if (isset($_POST['reg_user'])) {

    $username = string_db($_POST['username']);
    $email = string_db($_POST['email']);
    $psw = string_db($_POST['psw']);
    $psw_repeat = string_db($_POST['psw_repeat']);


    if ($psw != $psw_repeat) {

        array_push($errors, "The two passwords do not match");
    }
    //test if user or email already exist ----------------------------------------------------
    $results = select_db("SELECT * FROM Users WHERE Email='$email' OR UserName='$username'");

    if (mysqli_num_rows($results) > 0) {
        array_push($errors, "email or username already exist");
    }


    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        //-------------------------------------------
        $bcryptpassword = password_hash($psw, PASSWORD_BCRYPT);
        insert_db("INSERT INTO Users (UserName,Password,Email) VALUES ('$username', '$bcryptpassword', '$email')");
        echo "inscription réussie";
    }
}

?>

<?php print_error($errors); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        <?php include 'static/css/register.css'; ?>
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="registration">
        <h1 class="pageTitle">Inscription</h1>
        <p class="obligation">Remplissez ce formulaire d'adhésion</p>
        <br>
        <div class="loginForm">
            <form method="POST">
                <div class="username">
                    <label for="username"> Pseudo : </label>
                    <input type="text" placeholder="Entrez un Pseudo" name="username" required>
                </div>
                <div class="email">
                    <label for="email"> Email : </label>
                    <input type="email" placeholder="Entrez votre email" name="email" required>
                </div>
                <div class="password">
                    <label for="password"> Mot de Passe : </label>
                    <input type="password" placeholder="Entrez un mot de passe" name="psw" required>
                </div>
                <div class="psw_repeat">
                    <label for="psw_repeat"> Confirmez le Mot de Passe : </label>
                    <input type="password" placeholder="Réecrivez le mot de passe" name="psw_repeat" required>
                </div>
                <div class="register">
                    <button type="submit" class="signupbtn" name="reg_user">Inscription</button>
                    <a href="/php_forum/index.php" class="cancelbtn">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
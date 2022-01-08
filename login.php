<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Forum</title>
    <link rel="icon" href="/static/img/icon/forum.png">
    <link rel="stylesheet" href="/static/css/logincss.php">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>


<body>
    <header>
        <nav class="navbar">
            <div id="forum_tittle">
                <a href="/php_forum/index.php">Forum</a>
            </div>
        </nav>
    </header>
    <div class="connexion">
        <div class="L-Title flex padding">
            <h1>Connexion</h1>
        </div>
        <div class="loginForm padding flex">
            <form action="" method="GET">
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
                <div class="btnLogin flex">
                    <button class="LOGIN" type="submit" name="login_user">Connexion</button>
                </div>
            </form>
        </div>
        <div class="otherLogin padding flex">
            <div class="O-inscription">
                <p>Vous n'avez pas de compte ?</p>
                <p>Incrivez-vous ici</p>
                <br>
                <div class="flex">
                    <a class="REGISTER" href="/php_forum/register.php">Inscription</a>
                </div>
            </div>
        </div>
    </div>
</body>



<?php
$errors = array();
if (isset($_GET['login_user'])) {
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"

    $email = mysqli_real_escape_string($mysqli, $_GET['user_mail']);
    $password = mysqli_real_escape_string($mysqli, $_GET['user_password']);

    $password = md5($password);
    $query = "SELECT UserId FROM Users WHERE Email='$email' AND Password='$password'";
    $results = mysqli_query($mysqli, $query);
    // echo mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 1) {

        // Numeric array
        $row = $results->fetch_array(MYSQLI_NUM);
        // Free result set
        $results->free_result();

        setcookie('UserId', $row[0]);
        header('location: index.php');
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
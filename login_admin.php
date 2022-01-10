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
                <div class="btnLogin flex">
                    <button class="LOGIN" type="submit" name="admin_login">Connexion</button>
                </div>
            </form>
        </div>
    </div>
</body>



<?php
$errors = array();
if (isset($_POST['admin_login'])) {
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"

    $admin_name = mysqli_real_escape_string($mysqli, $_POST['admin_name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['admin_password']);

    $md5password = md5($password);
    $bcryptpassword = password_hash($md5password, PASSWORD_BCRYPT);

    $query = "SELECT AdminId FROM Admin WHERE AdminName='$admin_name' AND Password='$password'";
    $results = mysqli_query($mysqli, $query);
    // echo mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 1) {

        // Numeric array
        $row = $results->fetch_array(MYSQLI_NUM);
        // Free result set
        $results->free_result();

        setcookie('AdminId', $row[0]);
        setcookie('UserId', '', time() - 3600);
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
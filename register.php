<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Forum</title>
    <link rel="icon" href="/static/img/icon/forum.png">
    <link rel="stylesheet" href="/static/css/registercss.php">
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

    <div class="registration">
        <div class="L-Title flex padding">
            <h1>Inscription</h1>
        </div>
        <p class="obligation">Remplissez ce formulaire d'adhésion</p>
        <br>
        <div class="RegisterForm flex padding">
            <form method="GET">
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
                <div class="psw-repeat">
                    <label for="psw-repeat"> Confirmez le Mot de Passe : </label>
                    <input type="password" placeholder="Réecrivez le mot de passe" name="psw_repeat" required>
                </div>
                <div class="clear flex">
                    <button type="submit" class="signupbtn">Inscription</button>
                    <a href="/php_forum/index.php" class="cancelbtn">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>


<?php

$username = $_GET['username'];
$email = $_GET['email'];
$psw = $_GET['psw'];
$psw_repeat = $_GET['psw_repeat'];


if ($psw==$psw_repeat){
    
    
    try {
        $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // // Ecriture de la requête
    // $sqlQuery = "INSERT INTO users (UserName,Password,Email,IsAdmin) VALUES ('UserName','Password','Email','IsAdmin')";

    $stmt = $mysqli->prepare('INSERT INTO Users (UserName,Password,Email) VALUES (?, ?, ?)');
    $stmt->bind_param("sss",$username, $psw, $email);
    $stmt->execute();

    echo "test";
    $stmt->close();
    $mysqli->close();

    // $mysql->query($sql);

    // echo "test";
    // $mysql->close();
    
    // // Préparation
    // $insert = $mysqli->prepare($sqlQuery);
    // echo "success";
    // // Exécution ! La recette est maintenant en base de données
    // $insert->execute([
    //     'UserName' => $username,
    //     'Password' => $email,
    //     'Email' => $psw,
    //     'IsAdmin' => false, // 1 = true, 0 = false
    // ]);
    
}



?>

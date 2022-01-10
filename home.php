<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div id="forum_tittle">
                <form method="POST">
                    <a href="/php_forum/index.php">Forum</a>
                    <?php if (isset($_COOKIE['UserId'])) : ?>
                        <button type="submit" class="signupbtn" name="deconnexion">Deconnexion</button>
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
        </nav>
    </header>



    <?php


    $mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
    // si vous avez une erreur ici, remplacez le deuxième "root" par une string vide

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $result = $mysqli->query("SELECT * From Articles ORDER BY CreationDate DESC"); // On utilise l'instance créée pour faire une requête
    $nb_articles = mysqli_num_rows($result);

    if ($nb_articles == 0) {
        echo "No article has been created yet";
    } else {
    ?>
        <table width="500" border="1">
            <tr>
                <td>
                    Auteur
                </td>
                <td>
                    Titre
                </td>
                <td>
                    Date de publication
                </td>
            </tr>
            <?php
            while ($data = mysqli_fetch_array($result)) {

                // on affiche les résultats
                echo '<tr>';
                echo '<td>';

                // on affiche le nom de l'auteur de l'article
                echo htmlentities(trim($data['UserId']));
                echo '</td><td>';

                //TODO
                // on affiche le titre du sujet, et sur cet article, on insère le lien qui nous permettra de voir en détail l'article
                echo '<a href="/php_forum/details.php?ArticleId=', $data['ArticleId'], '">', htmlentities(trim($data['Title'])), '</a>';

            // on affiche le titre du sujet, et sur cet article, on insère le lien qui nous permettra de voir en détail l'article
            echo '<a href="/php_forum/details.php?ArticleId=', $data['ArticleId'], '">', htmlentities(trim($data['Title'])), '</a>';

            echo '</td><td>';

            // on affiche la date de création de l'article
            echo $data['CreationDate'];
        }
        ?>
        </td>
        </tr>
    </table>
<?php
}
$mysqli->close();
?>
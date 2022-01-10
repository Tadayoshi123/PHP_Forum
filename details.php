<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="leftnav">
                <div id="forum_tittle">
                    <a href="/php_forum/index.php">Forum</a>
                </div>
            </div>
        </nav>
    </header>

</body>

</html>

<?php

$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
// si vous avez une erreur ici, remplacez le deuxième "root" par une string vide

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$result = $mysqli->query("SELECT Title, Description, CreationDate FROM Articles INNER JOIN Users ON Articles.UserId = Articles.UserId WHERE Articles.ArticleId =" . $_GET['ArticleId']); // On utilise l'instance créée pour faire une requête

if (!isset($_GET['ArticleId'])) {
    echo 'Article does not exist';
} else {
?>
    <table width="500" border="1">
        <tr>
            <td>
                Auteur
            </td>
            <td>
                Description
            </td>
            <td>
                Date de création
            </td>
        </tr>
        <?php

        while ($data = mysqli_fetch_array($result)) {

            // on affiche le titre du sujet
            echo '<h1>', htmlentities(trim($data['Title'])), '</h1>';

            // on affiche le résultat
            echo '<tr>';
            echo '<td>';

            // on affiche le nom de l'auteur de l'article
            echo htmlentities(trim($data['UserName']));
            echo '</td><td>';

            // on affiche la description de l'article
            echo nl2br(htmlentities(trim($data['Description'])));
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
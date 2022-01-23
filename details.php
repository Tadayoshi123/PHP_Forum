<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <style>
        <?php include 'static/css/home.css'; ?>
    </style>
</head>

<?php include('navbar.php'); ?>
<?php include('functions.php'); ?>
<?php redirect_to_login(); ?>


<?php


if (!isset($_GET['ArticleId'])) {
    echo 'Article does not exist';
} else {
    //----------------------------------------------------
    $results = select_db("SELECT Title, Description, CreationDate , UserName, ArticleId FROM Articles  INNER JOIN Users ON Users.UserId = Articles.UserId "); // On utilise l'instance créée pour faire une requête

    while ($data = mysqli_fetch_array($results)) {
        if ($data['ArticleId'] == $_GET['ArticleId']) {
?>
    <table width="500" border="1">
        <thead>
            <tr>
                <td>
                    Titre
                </td>
                <td>
                    Description
                </td>
                <td>
                    Auteur
                </td>
                <td>
                    Date de création
                </td>
            </tr>
        </thead>
        <tbody>
            <?php

            

                    echo "<td>";
                    // on affiche le nom de l'auteur de l'article
                    echo nl2br(htmlentities(trim($data['UserName'])));
                    echo '</td><td>';
                    // on affiche le titre du sujet
                    echo htmlentities(trim($data['Title']));
                    echo '</td><td>';

                    // on affiche la description de l'article
                    echo htmlentities(trim($data['Description']));
                    echo '</td><td>';

                    // on affiche la date de création de l'article
                    echo $data['CreationDate'];
                    echo '</td></tr>';
                
            ?>
            </td>
            </tr>
        </tbody>
    </table>
<?php
        }
    }
}
?>
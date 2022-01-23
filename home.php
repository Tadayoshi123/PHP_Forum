<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<?php include('functions.php'); ?>


<?php


if (isset($_GET['search'])) {
    //------------------------------------
    $strSearch = $_GET["search"];
    $result = select_db("SELECT Title, Description, CreationDate , UserName, ArticleId FROM Articles INNER JOIN Users ON Users.UserId = Articles.UserId  WHERE Title = '$strSearch'"); // On utilise l'instance créée pour faire une requête
    $nb_articles = mysqli_num_rows($result);
} else {
    //----------------------------------
    $result = select_db("SELECT Title, Description, CreationDate , UserName, ArticleId FROM Articles  INNER JOIN Users ON Users.UserId = Articles.UserId "); // On utilise l'instance créée pour faire une requête
    $nb_articles = mysqli_num_rows($result);
}

if ($nb_articles == 0) {
    echo "No article found";
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
            echo htmlentities(trim($data['UserName']));
            echo '</td><td>';

            // on affiche le titre du sujet, et sur cet article, on insère le lien qui nous permettra de voir en détail l'article
            echo '<a href="/php_forum/details.php?ArticleId=', $data['ArticleId'], '">', htmlentities(trim($data['Title'])), '</a>';

            echo '</td><td>';

            // on affiche la date de création de l'article
            echo $data['CreationDate'];


            if (isset($_COOKIE['UserId'])) {

                echo '</td><td>';
                //---------------------------------------------------------------
                $article_id = string_db( $data['ArticleId']);
                $user_id = string_db( $_COOKIE['UserId']);
                $Favourite = select_db("SELECT FavouriteId FROM Favourites WHERE UserId='$user_id' AND ArticleId = '$article_id'");
                
                if (mysqli_num_rows($Favourite) == 0) {

        ?>
                    <form method="POST" enctype="multipart/form-data" id="form">
                        <button type="submit" name="addFav" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Add Favourite</button>
                    </form>
                    <?php
                } else {
                    while ($data = mysqli_fetch_array($Favourite)) {
                    ?>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <button type="submit" name="delFav" value="<?php echo $data['FavouriteId']; ?>">delete Favourite</button>
                        </form>
        <?php

                    }
                }
            }
        }

        if (isset($_POST['addFav'])) {
            //-----------------------------------------
            $article_id = string_db( $_POST['addFav']);
            $user_id = string_db( $_COOKIE['UserId']);
            insert_db("INSERT INTO Favourites (UserId,ArticleId) VALUES  ('$user_id', '$article_id')");
            header('location: home.php');
        }

        if (isset($_POST['delFav'])) {
            //---------------------------
            $favourite_id = string_db( $_POST['delFav']);
            insert_db("DELETE FROM Favourites WHERE FavouriteId = '$favourite_id'");
            header('location: home.php');
        }
        ?>
        </td>
        </tr>
    </table>
<?php
}


?>
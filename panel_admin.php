<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
</head>

<body>

</body>

</html>
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
<?php $errors = array();
if (isset($_COOKIE['AdminId'])) : ?>
    Article list:
    <?php

    try {
        $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
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
                    Titre
                </td>
                <td>
                    Description
                </td>
                <td>
                    Date de publication
                </td>
            </tr>
            <?php
            while ($data = mysqli_fetch_array($result)) {

                // on affiche les résultats
            ?>
                <tr>
                    <td>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <input type="text" id="Titret" name="Titre" value="<?php echo  htmlentities(trim($data['Title'])); ?>" required>


                    <td>
                        <input type="text" id="description" name="description" value="<?php echo htmlentities(trim($data['Description'])); ?>" required>
                    <td>
                        <?php echo $data['CreationDate']; ?>
                    <td>
                        <button class="Newpost_submit" type="submit" name="addTopic">Edit Article</button>
                        </form>
                    <?php } ?>
                    </td>
                </tr>
        </table>

        <?php
        if (isset($_POST['editTopic'])) {


            try {
                $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            $title = mysqli_real_escape_string($mysqli, $_POST['Titre']);
            $description = mysqli_real_escape_string($mysqli, $_POST['message_newpost']);
            $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);
            $article_id = mysqli_real_escape_string($mysqli, $_GET['ArticleId']);

            $stmt = $mysqli->prepare("UPDATE Articles SET Title = '$title', Description = '$description' WHERE ArticleId = '$article_id'");
            $stmt->execute();


            echo "Add successfull";
            $stmt->close();
            $mysqli->close();
            header('location: edit.php?ArticleId=' . $article_id);
        }
        ?>

    <?php
    }

    $result = $mysqli->query("SELECT * From Users"); // On utilise l'instance créée pour faire une requête
    $nb_users = mysqli_num_rows($result);

    if ($nb_users == 0) {
        echo "No users has been created yet";
    } else {
    ?>
        <table width="500" border="1">
            <tr>
                <td>
                    Name
                </td>
                <td>
                    Email
                </td>

            </tr>
            <?php
            while ($data = mysqli_fetch_array($result)) {

                // on affiche les résultats
                echo '<tr>';
                echo '<td>';

                echo '<a href="/php_forum/edit.php?ArticleId=', $data['UserId'], '">', htmlentities(trim($data['UserName'])), '</a>';
                echo '</td><td>';

                // on affiche le nom de l'auteur de l'article
                echo htmlentities(trim($data['Email']));
                echo '</td>';
            }
            ?>
            </tr>
        </table>

    <?php
    }

    $mysqli->close();


    ?>



<?php else : ?>
    <?php array_push($errors, "vous devez être connectés pour acceder a cette page") ?>
<?php endif ?>

<?php if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php endif ?>
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
if (isset($_COOKIE['UserId'])) : ?>
    <?php

    $mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"

    $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);

    $query = "SELECT * FROM Users WHERE UserId='$user_id'";
    $results = mysqli_query($mysqli, $query);
    // echo mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 1) {

        // Numeric array
        $row = $results->fetch_array(MYSQLI_NUM);
        // Free result set
        $results->free_result();
    } else {
        array_push($errors, "Account can't be finded");
    }
    ?>




    <div>
        Actual UserName: <?php echo $row[1]; ?>
    </div>
    <div>
        Actual Email: <?php echo $row[3]; ?>
    </div>


    <form method="POST">
        <div class="username">
            <label for="username">change UserName : </label>
            <input type="text" placeholder="UserName" name="username" required>
        </div>
        <div class="clear flex">
            <button type="submit" class="signupbtn" name="new_user_name">Change UserName</button>
        </div>
    </form>

    <form method="POST">
        <div class="email">
            <label for="email"> change Email : </label>
            <input type="text" placeholder="Email" name="email" required>
        </div>
        <div class="clear flex">
            <button type="submit" class="signupbtn" name="new_email">Change Email</button>
        </div>
    </form>
    <form method="POST">
        <div class="password">
            <label for="password">change Password : </label>
            <input type="password" placeholder="Entrez un mot de passe" name="psw" required>
        </div>
        <div class="psw-repeat">
            <label for="psw-repeat"> Confirm new password : </label>
            <input type="password" placeholder="Réecrivez le mot de passe" name="psw_repeat" required>
        </div>
        <div class="clear flex">
            <button type="submit" class="signupbtn" name="new_password">Change Password</button>
        </div>
    </form>

    <?php



    $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);


    try {
        $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    if (isset($_POST['new_user_name'])) {
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $query = "SELECT * FROM Users WHERE UserName='$username'";
        $results = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($results) > 0) {
            array_push($errors, "username already exist");
        } else {
            $stmt = $mysqli->prepare("UPDATE Users SET UserName = '$username' WHERE UserId = '$user_id'");
            // $stmt->bind_param("s", $username);
            $stmt->execute();
            header('location: account.php');
            $stmt->close();
        }
    }

    if (isset($_POST['new_email'])) {
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $query = "SELECT * FROM Users WHERE Email='$email'";
        $results = mysqli_query($mysqli, $query);
        if (mysqli_num_rows($results) > 0) {
            array_push($errors, "email already exist");
        } else {
            $stmt = $mysqli->prepare("UPDATE Users SET Email = '$email' WHERE UserId = '$user_id'");
            $stmt->execute();
            header('location: account.php');
            $stmt->close();
        }
    }

    if (isset($_POST['new_password'])) {
        $psw = mysqli_real_escape_string($mysqli, $_POST['psw']);
        $psw_repeat = mysqli_real_escape_string($mysqli, $_POST['psw_repeat']);
        if ($psw != $psw_repeat) {

            array_push($errors, "The two passwords do not match");
        } else {
            $md5password = md5($psw);
            $stmt = $mysqli->prepare("UPDATE Users SET Password = '$md5password' WHERE UserId = '$user_id'");
            $stmt->execute();
            header('location: account.php');
            $stmt->close();
        }
    }


    $result = $mysqli->query("SELECT * From Articles WHERE UserId = '$user_id' ORDER BY CreationDate DESC"); // On utilise l'instance créée pour faire une requête
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
            <?php while ($data = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <?php echo  htmlentities(trim($data['Title'])); ?>
                    <td>
                        <?php echo htmlentities(trim($data['Description'])); ?>
                    <td>
                        <?php echo $data['CreationDate']; ?>
                    <td>
                        <button class="Newpost_submit" type="submit" name="deleteTopic" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Delete Article</button>
                        </form>
                    <?php } ?>
                    </td>
                </tr>
        </table>
        <?php
        if (isset($_POST['deleteTopic'])) {

            try {
                $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            $article_id = mysqli_real_escape_string($mysqli, $_POST['deleteTopic']);
            $stmt = $mysqli->prepare("DELETE FROM Articles WHERE ArticleId = '$article_id'");
            $stmt->execute();


            echo "Delete successfull";
            header('location: account.php');
            $stmt->close();
            $mysqli->close();
        }
    }


    $result = $mysqli->query("SELECT Title, Description, CreationDate , Favourites.ArticleId , Users.UserName FROM Articles INNER JOIN Users ON Users.UserId = Articles.UserId INNER JOIN Favourites ON Favourites.UserId = Users.UserId"); // On utilise l'instance créée pour faire une requête
    $nb_articles = mysqli_num_rows($result);

    if ($nb_articles != 0) {
        
        ?>
        <div>Favourite articles</div>
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

                // on affiche le titre du sujet, et sur cet article, on insère le lien qui nous permettra de voir en détail l'article
                echo '<a href="/php_forum/details.php?ArticleId=', $data['ArticleId'], '">', htmlentities(trim($data['Title'])), '</a>';

                echo '</td><td>';

                // on affiche la date de création de l'article
                echo $data['CreationDate'];


                if (isset($_COOKIE['UserId'])) {

                    echo '</td><td>';
                    $article_id = mysqli_real_escape_string($mysqli, $data['ArticleId']);
                    $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);

                    $query = "SELECT FavouriteId FROM Favourites WHERE UserId='$user_id' AND ArticleId = '$article_id'";
                    $Favourite = mysqli_query($mysqli, $query);
                    if (mysqli_num_rows($Favourite) == 0) {

            ?>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <button type="submit" name="addFav" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Add Favourite</button>
                        </form>
                        <?php

                        if (isset($_POST['addFav'])) {

                            $article_id = mysqli_real_escape_string($mysqli, $_POST['addFav']);
                            $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);
                            $stmt = $mysqli->prepare("INSERT INTO Favourites (UserId,ArticleId) VALUES  ($user_id, $article_id)");
                            $stmt->execute();
                            $stmt->close();
                            header('location: account.php');
                        }
                    } else {
                        while ($data = mysqli_fetch_array($Favourite)) {
                        ?>
                            <form method="POST" enctype="multipart/form-data" id="form">

                                <button type="submit" name="delFav" value="<?php echo $data['FavouriteId']; ?>">delete Favourite</button>
                            </form>
            <?php
                            if (isset($_POST['delFav'])) {
                                $favourite_id = mysqli_real_escape_string($mysqli, $_POST['delFav']);
                                $stmt = $mysqli->prepare("DELETE FROM Favourites WHERE FavouriteId = '$favourite_id'");
                                $stmt->execute();
                                $stmt->close();
                                header('location: account.php');
                            }
                        }
                    }
                }
            }
            ?>
            </td>
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
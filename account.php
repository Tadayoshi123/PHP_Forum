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


<?php include('navbar.php'); ?>


<?php $errors = array();
if (isset($_COOKIE['UserId'])) : ?>
    <?php

    //----------------------------
    $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);
    $results = select_db("SELECT * FROM Users WHERE UserId='$user_id'");
    // echo mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 1) {

        // Numeric array
        // $row = $results->fetch_array(MYSQLI_NUM);
        $data = mysqli_fetch_array($results);
        // Free result set
        $results->free_result();
    } else {
        array_push($errors, "Account can't be finded");
    }
    ?>




    <div>
        Actual UserName: <?php echo trim($data['UserName']); ?>
    </div>
    <div>
        Actual Email: <?php echo trim($data['Email']); ?>
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


    if (isset($_POST['new_user_name'])) {
        //---------------------------
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $query = "SELECT * FROM Users WHERE UserName='$username'";
        $results = select_db($query);
        if (mysqli_num_rows($results) > 0) {
            array_push($errors, "username already exist");
        } else {
            //--------------------------------------------
            $mysqli = initiate_db();
            $stmt = $mysqli->prepare("UPDATE Users SET UserName = '$username' WHERE UserId = '$user_id'");
            // $stmt->bind_param("s", $username);
            $stmt->execute();
            header('location: account.php');
            $stmt->close();
            $mysqli->close();
        }
        
    }

    if (isset($_POST['new_email'])) {
        //--------------------------------------------
        $mysqli = initiate_db();
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $results = select_db("SELECT * FROM Users WHERE Email='$email'");
        if (mysqli_num_rows($results) > 0) {
            array_push($errors, "email already exist");
        } else {
            $stmt = $mysqli->prepare("UPDATE Users SET Email = '$email' WHERE UserId = '$user_id'");
            $stmt->execute();
            header('location: account.php');
            $stmt->close();
        }
        $mysqli->close();
    }

    if (isset($_POST['new_password'])) {
        //--------------------------------------------
        $mysqli = initiate_db();
        $psw = mysqli_real_escape_string($mysqli, $_POST['psw']);
        $psw_repeat = mysqli_real_escape_string($mysqli, $_POST['psw_repeat']);
        if ($psw != $psw_repeat) {

            array_push($errors, "The two passwords do not match");
        } else {
            
            $bcryptpassword = password_hash($psw, PASSWORD_BCRYPT);
            $stmt = $mysqli->prepare("UPDATE Users SET Password = '$bcryptpassword' WHERE UserId = '$user_id'");
            $stmt->execute();
            header('location: account.php');
            $stmt->close();
            
        }
        $mysqli->close();
    }

    //----------------------------------
    $result = select_db("SELECT * From Articles WHERE UserId = '$user_id' ORDER BY CreationDate DESC"); // On utilise l'instance créée pour faire une requête
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
            //-----------------------------------------------
            $mysqli = initiate_db();
            $article_id = mysqli_real_escape_string($mysqli, $_POST['deleteTopic']);
            $stmt = $mysqli->prepare("DELETE FROM Articles WHERE ArticleId = '$article_id'");
            $stmt->execute();


            echo "Delete successfull";
            header('location: account.php');
            $stmt->close();
            $mysqli->close();
        }
    }
    //-----------------------------------------------
    $result = select_db("SELECT Title, Description, CreationDate , Favourites.ArticleId , Users.UserName FROM Articles INNER JOIN Users ON Users.UserId = Articles.UserId INNER JOIN Favourites ON Favourites.UserId = Users.UserId"); // On utilise l'instance créée pour faire une requête
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

                    //------------------------------------------
                    $article_id = mysqli_real_escape_string($mysqli, $data['ArticleId']);
                    $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);

                    $Favourite = select_db("SELECT FavouriteId FROM Favourites WHERE UserId='$user_id' AND ArticleId = '$article_id'");
                    
                    if (mysqli_num_rows($Favourite) == 0) {

            ?>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <button type="submit" name="addFav" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Add Favourite</button>
                        </form>
                        <?php

                        if (isset($_POST['addFav'])) {
                            //-----------------------------------
                            $mysqli = initiate_db();
                            $article_id = mysqli_real_escape_string($mysqli, $_POST['addFav']);
                            $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);
                            insert_db("INSERT INTO Favourites (UserId,ArticleId) VALUES ($user_id, $article_id)");
                            header('location: account.php');
                            $mysqli->close();
                        }
                        $mysqli->close();
                    } else {
                        while ($data = mysqli_fetch_array($Favourite)) {
                        ?>
                            <form method="POST" enctype="multipart/form-data" id="form">

                                <button type="submit" name="delFav" value="<?php echo $data['FavouriteId']; ?>">delete Favourite</button>
                            </form>
            <?php
                            if (isset($_POST['delFav'])) {
                                //--------------------------------
                                $mysqli = initiate_db();
                                $favourite_id = mysqli_real_escape_string($mysqli, $_POST['delFav']);
                                $stmt = $mysqli->prepare("DELETE FROM Favourites WHERE FavouriteId = '$favourite_id'");
                                $stmt->execute();
                                $stmt->close();
                                header('location: account.php');
                                $mysqli->close();
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

<?php print_error($errors); ?>
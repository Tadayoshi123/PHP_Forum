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


<!-- <?php include('navbar.php'); ?> -->
<?php include('functions.php'); ?>



<?php $errors = array();
if (isset($_COOKIE['UserId'])) : ?>
    <?php

    //----------------------------
    $user_id = string_db($_COOKIE['UserId']);
    $results = select_db("SELECT * FROM Users WHERE UserId='$user_id'");
    if (mysqli_num_rows($results) == 1) {


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



    $user_id = string_db($_COOKIE['UserId']);


    if (isset($_POST['new_user_name'])) {
        //---------------------------
        $username = string_db($_POST['username']);
        $query = "SELECT * FROM Users WHERE UserName='$username'";
        $results = select_db($query);
        if (mysqli_num_rows($results) > 0) {
            array_push($errors, "username already exist");
        } else {
            insert_db("UPDATE Users SET UserName = '$username' WHERE UserId = '$user_id'");
            header('location: account.php');
        }
    }

    if (isset($_POST['new_email'])) {
        //--------------------------------------------
        $email = string_db($_POST['email']);
        $results = select_db("SELECT * FROM Users WHERE Email='$email'");
        if (mysqli_num_rows($results) > 0) {
            array_push($errors, "email already exist");
        } else {
            insert_db("UPDATE Users SET Email = '$email' WHERE UserId = '$user_id'");
            header('location: account.php');
        }
    }

    if (isset($_POST['new_password'])) {
        $psw = string_db($_POST['psw']);
        $psw_repeat = string_db($_POST['psw_repeat']);
        if ($psw != $psw_repeat) {

            array_push($errors, "The two passwords do not match");
        } else {

            $bcryptpassword = password_hash($psw, PASSWORD_BCRYPT);
            insert_db("UPDATE Users SET Password = '$bcryptpassword' WHERE UserId = '$user_id'");
            header('location: account.php');
        }
    }

    //----------------------------------
    $result = select_db("SELECT * From Articles WHERE UserId = '$user_id' ORDER BY CreationDate DESC"); // On utilise l'instance créée pour faire une requête

    if (mysqli_num_rows($result) == 0) {
        echo "No article has been created yet";
    } else {

        if (isset($_POST['deleteTopic'])) {
            //-----------------------------------------------
            $article_id = string_db($_POST['deleteTopic']);
            insert_db("DELETE FROM Articles WHERE ArticleId = '$article_id'");


            echo "Delete successfull";
            header('location: account.php');
        }
        if (isset($_POST['delFav'])) {
            //--------------------------------
            $favourite_id = string_db($_POST['delFav']);
            insert_db("DELETE FROM Favourites WHERE FavouriteId = '$favourite_id'");
            header('location: account.php');
        }

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
                            <?php echo '<a href="/php_forum/details.php?ArticleId=', $data['ArticleId'], '">', htmlentities(trim($data['Title'])), '</a>'; ?>

                    </td>
                    <td>
                        <?php echo htmlentities(trim($data['Description'])); ?>
                    </td>
                    <td>
                        <?php echo $data['CreationDate']; ?>
                    </td>

                    <td>
                        <button class="Newpost_submit" type="submit" name="deleteTopic" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Delete Article</button>
                        </form>
                    </td>
                    <td>
                        <form method="GET" enctype="multipart/form-data" id="form" action="/php_forum/edit.php">
                            <button class="Newpost_submit" type="submit" name="ArticleId" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Edit Article</button>
                        </form>
                    </td>
                <?php } ?>
                </td>
                </tr>
        </table>
    <?php

    }
    //-----------------------------------------------
    echo $user_id;
    $result = select_db("SELECT Articles.Title, Articles.Description, Articles.CreationDate , Articles.ArticleId , Users.UserName FROM Articles INNER JOIN Users ON Users.UserId = Articles.UserId INNER JOIN Favourites ON Favourites.ArticleId = Articles.ArticleId WHERE Favourites.UserId = $user_id"); // On utilise l'instance créée pour faire une requête
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

                echo '</td><td>';

                // on affiche la date de création de l'article
                echo $data['CreationDate'];


                if (isset($_COOKIE['UserId'])) {

                    echo '</td><td>';

                    //------------------------------------------
                    $article_id = string_db($data['ArticleId']);
                    $user_id = string_db($_COOKIE['UserId']);

                    $Favourite = select_db("SELECT FavouriteId FROM Favourites WHERE UserId='$user_id' AND ArticleId = '$article_id'");

                    
                    while ($data = mysqli_fetch_array($Favourite)) {
                    ?>
                        <form method="POST" enctype="multipart/form-data" id="form">

                            <button type="submit" name="delFav" value="<?php echo $data['FavouriteId']; ?>">delete Favourite</button>
                        </form>
                    <?php                        
                    }
                }
            }
            ?>
            </td>
            </tr>
        </table>
    <?php
    }
    ?>



<?php else : ?>
    <?php array_push($errors, "vous devez être connectés pour acceder a cette page") ?>
<?php endif ?>

<?php print_error($errors); ?>
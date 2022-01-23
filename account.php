<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <style>
        <?php include 'static/css/account.css'; ?>
    </style>
</head>

<body>

    <?php include('navbar.php'); ?>
    <?php include('functions.php'); ?>


    <?php $errors = array();
    if (isset($_COOKIE['UserId'])) : ?>
        <?php

        //----------------------------
        $user_id = string_db($_COOKIE['UserId']);
        $results = select_db("SELECT * FROM Users WHERE Users.UserId='$user_id'");
        if (mysqli_num_rows($results) == 1) {


            $data = mysqli_fetch_array($results);
            // Free result set
            $results->free_result();
        } else {
            array_push($errors, "Account can't be found");
        }
        ?>



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

        if (isset($_POST['new_avatar'])) {
            //---------------------------
            $image_size = getimagesize($_FILES['userImage']['tmp_name']);
            if ($image_size !== false) {
                //Récupère le contenu de l'image
                $file = $_FILES['userImage']['tmp_name'];
                $image = addslashes(file_get_contents($file));

                $query = "SELECT * FROM Images WHERE UserId='$user_id'";
                $results = select_db($query);
                if (mysqli_num_rows($results) > 0) {
                    insert_db("UPDATE Images SET ImageBlob = '$image' WHERE UserId = '$user_id'");
                    header('location: account.php');
                } else {
                    insert_db("INSERT into Images (ImageBlob ,UserId) VALUES ('$image' , '$user_id')");
                    header('location: account.php');
                }
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



        ?>

        <div class="info_user">
            <h1 class="pageTitle">Mon Compte</h1>
            <div class="information">
                Nom Utilisateur: <?php echo trim($data['UserName']); ?>
            </div>
            <br>
            <div class="information">
                Mail: <?php echo trim($data['Email']); ?>
            </div>
            <div class="information">
                Avatar: <?php
                        if (get_image_db($data['UserId']) !== null) {
                            echo '<img src="data:image/jpg;base64,' .  base64_encode(get_image_db($data['UserId']))  . '" />';
                        } else {
                            echo "<img src='static/image/img_avatar.png' />";
                        }

                        ?>
            </div>
            <br>

            <div>
                Nouvel Avatar
            </div>

            <form enctype="multipart/form-data" method="post">
                <label>Télécharger un fichier image:</label>
                <br>
                <input name="userImage" type="file" />
                <button type="submit" class="signupbtn" name="new_avatar">Soumettre</button>
            </form>

            <form method="POST">
                <div class="information">
                    <label for="username">Changer de Nom Utilisateur : </label>
                    <input type="text" placeholder="Nouveau nom" name="username" required>
                    <button type="submit" class="signupbtn" name="new_user_name">Soumettre</button>
                </div>
            </form>
            <br>
            <form method="POST">
                <div class="information">
                    <label for="email"> Changer de mail : </label>
                    <input type="text" placeholder="Nouveau mail" name="email" required>
                    <button type="submit" class="signupbtn" name="new_email">Soumettre</button>
                </div>
            </form>
            <br>
            <form method="POST">
                <div class="information">
                    <label for="password">Changer de Mot de passe : </label>
                    <input type="password" placeholder="Entrez un mot de passe" name="psw" required>
                </div>
                <div class="information">
                    <label for="psw-repeat"> Confirmer le Mot de passe : </label>
                    <input type="password" placeholder="Réecrivez le mot de passe" name="psw_repeat" required>
                    <button type="submit" class="signupbtn" name="new_password">Soumettre</button>
                </div>
            </form>
        </div>
        <?php
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
            <div class="myArticles">
                <h2 class="subPageTitle">Mes Articles</h2>
                <table>
                    <thead>
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
                    </thead>
                    <tbody>
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
                                    <button class="Newpost_submit" type="submit" name="deleteTopic" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Supprimer l'article</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="GET" enctype="multipart/form-data" id="form" action="/php_forum/edit.php">
                                        <button class="Newpost_submit" type="submit" name="ArticleId" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Modifier l'article</button>
                                    </form>
                                </td>
                            <?php } ?>
                            </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        <?php

        }
        //-----------------------------------------------
        $result = select_db("SELECT Articles.Title, Articles.Description, Articles.CreationDate , Articles.ArticleId , Users.UserName FROM Articles INNER JOIN Users ON Users.UserId = Articles.UserId INNER JOIN Favourites ON Favourites.ArticleId = Articles.ArticleId WHERE Favourites.UserId = $user_id"); // On utilise l'instance créée pour faire une requête
        $nb_articles = mysqli_num_rows($result);

        if ($nb_articles != 0) {

        ?>
            <h2 class="subPageTitle">Articles favoris</h2>
            <table>
                <thead>
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
                </thead>
                <tbody>
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
                </tbody>
            </table>
        <?php
        }
        ?>

    <?php else : ?>
        <?php array_push($errors, "vous devez être connectés pour acceder a cette page") ?>
    <?php endif ?>

    <?php print_error($errors); ?>

</body>

</html>
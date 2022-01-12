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
            <?php while ($data = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <input type="text" id="Titret" name="Titre" value="<?php echo  htmlentities(trim($data['Title'])); ?>" required>
                    <td>
                        <input type="text" id="description" name="description" value="<?php echo htmlentities(trim($data['Description'])); ?>" required>
                    <td>
                        <?php echo $data['CreationDate']; ?>
                    <td>
                        <button class="Newpost_submit" type="submit" name="editTopic" value=" <?php echo htmlentities(trim($data['ArticleId'])); ?>">Edit Article</button>
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
            header('location: panel_admin.php');
            $stmt->close();
            $mysqli->close();
        }
        if (isset($_POST['editTopic'])) {


            try {
                $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            $title = mysqli_real_escape_string($mysqli, $_POST['Titre']);
            $description = mysqli_real_escape_string($mysqli, $_POST['description']);
            $article_id = mysqli_real_escape_string($mysqli, $_POST['editTopic']);

            $stmt = $mysqli->prepare("UPDATE Articles SET Title = '$title', Description = '$description' WHERE ArticleId = '$article_id'");
            $stmt->execute();


            echo "Edit successfull";
            header('location: panel_admin.php');
            $stmt->close();
            $mysqli->close();
        }
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
                    UserName
                </td>
                <td>
                    Email
                </td>
            </tr>
            <?php while ($data = mysqli_fetch_array($result)){ ?>
                <tr>
                    <td>
                        <form method="POST" enctype="multipart/form-data" id="form">
                            <input type="text" id="user_name" name="user_name" value="<?php echo htmlentities(trim($data['UserName'])); ?>" required>
                    <td>
                        <input type="text" id="email" name="email" value="<?php echo htmlentities(trim($data['Email'])); ?>" required>
                    <td>
                        <button class="Newpost_submit" type="submit" name="edit_user" value="<?php echo htmlentities(trim($data['UserId'])); ?>">Edit User</button>
                    <td>
                        <button class="Newpost_submit" type="submit" name="delete_user" value="<?php echo htmlentities(trim($data['UserId'])); ?>">Delete User</button>
                        </form>
                    <?php } ?>
                    </td>
                </tr>
        </table>

    <?php
        if (isset($_POST['delete_user'])) {

            try {
                $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            $user_id = mysqli_real_escape_string($mysqli, $_POST['delete_user']);
            $stmt = $mysqli->prepare("DELETE FROM Users WHERE UserId = '$user_id'");
            $stmt->execute();


            echo "Delete successfull";
            header('location: panel_admin.php');
            $stmt->close();
            $mysqli->close();
        }
        if (isset($_POST['edit_user'])) {


            try {
                $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            // $user_id = ;
            $user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);

            $email = mysqli_real_escape_string($mysqli, $_POST['email']);

            $user_id = mysqli_real_escape_string($mysqli, $_POST['edit_user']);

            $stmt = $mysqli->prepare("UPDATE Users SET UserName = '$user_name', Email = '$email' WHERE UserId = '$user_id'");
            $stmt->execute();


            echo "Add successfull";
            header('location: panel_admin.php');
            $stmt->close();
            $mysqli->close();
        }
    }
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
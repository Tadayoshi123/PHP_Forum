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
<?php include('functions.php'); ?>


<?php $errors = array();
if (isset($_COOKIE['AdminId'])) : ?>
    Article list:
    <?php
    //--------------------------------------
    $result = select_db("SELECT * From Articles ORDER BY CreationDate DESC"); // On utilise l'instance créée pour faire une requête

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

            //--------------------------------------------
            $article_id = string_db( $_POST['deleteTopic']);
            insert_db("DELETE FROM Articles WHERE ArticleId = '$article_id'");
            header('location: panel_admin.php');
        }
        if (isset($_POST['editTopic'])) {

            //--------------------------------------------
            $title = string_db( $_POST['Titre']);
            $description = string_db( $_POST['description']);
            $article_id = string_db( $_POST['editTopic']);
            insert_db("UPDATE Articles SET Title = '$title', Description = '$description' WHERE ArticleId = '$article_id'");
            header('location: panel_admin.php');
        }
    }

    //------------------------------------
    $result = select_db("SELECT * From Users"); // On utilise l'instance créée pour faire une requête
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
            <?php while ($data = mysqli_fetch_array($result)) { ?>
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

            //-----------------------------------------
            $user_id = string_db( $_POST['delete_user']);
            insert_db("DELETE FROM Users WHERE UserId = '$user_id'");
            header('location: panel_admin.php');
        }
        if (isset($_POST['edit_user'])) {
            //----------------------------------
            $user_name = string_db( $_POST['user_name']);
            $email = string_db( $_POST['email']);
            $user_id = string_db( $_POST['edit_user']);
            insert_db("UPDATE Users SET UserName = '$user_name', Email = '$email' WHERE UserId = '$user_id'");
            header('location: panel_admin.php');
        }
    }
    ?>


<?php else : ?>
    <?php array_push($errors, "vous devez être connectés pour acceder a cette page") ?>
<?php endif ?>

<?php print_error($errors); ?>
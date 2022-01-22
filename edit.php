<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Forum</title>
    <link rel="icon" href="/static/img/icon/forum.png">
    <!-- fontstyle -->
    <link rel="stylesheet" href="/static/css/newpost.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@300&display=swap" rel="stylesheet">
</head>

<?php include('navbar.php'); ?>

<?php $errors = array();
if (isset($_COOKIE['UserId']) || isset($_COOKIE['AdminId'])) {
    if (isset($_GET['ArticleId'])) {
        //----------------------------------------------------
        $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);
        $article_id = mysqli_real_escape_string($mysqli, $_GET['ArticleId']);
        $results = select_db("SELECT * FROM Articles WHERE UserId='$user_id' AND ArticleId = '$article_id'");
        if (mysqli_num_rows($results) == 1) {

            $data = mysqli_fetch_array($result);
        } else {
            array_push($errors, "You can't edit this article");
        }
    } else {
        array_push($errors, "Article is not available");
    }
} else {
    array_push($errors, "You have to be logged to edit this article");
}
?>

<?php if (count($errors) == 0) : ?>

    <body>
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
        <div class="new__post">
            <div class="N-title flex padding">
                <h1>Edit Topic</h1>
            </div>
            <!-- <p class="obligation">{{.Error}}</p> -->
            <div class="NewpostForm flex padding">
                <form method="POST" enctype="multipart/form-data" id="form">
                    <div class="Titre_post">
                        <label for="titre-sujet" id="titre-sujet">Titre du Sujet : </label>
                        <br>
                        <input type="text" id="Titre_sujet" name="Titre_sujet" value="<?php echo $data['Title']; ?>" required>
                        <br>
                    </div>
                    <div class=" text_area">
                        <label for="message">Message : </label>
                        <br>
                        <textarea name="message_newpost" id="message_newpost" cols="30" rows="10" required><?php echo $data['Description']; ?></textarea>
                    </div>
            </div>
            <div class="btn-newpost flex">
                <div>
                    <button class="Newpost_submit" type="submit" name="editTopic">Soumettre</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </body>

    <?php
    if (isset($_POST['editTopic'])) {

        //------------------------------
        $mysqli = initiate_db();
        $title = mysqli_real_escape_string($mysqli, $_POST['Titre_sujet']);
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

<?php else : ?>
    <?php print_error($errors); ?>
<?php endif ?>
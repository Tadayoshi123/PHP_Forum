

<?php

include('functions.php'); ?>

<?php redirect_to_login(); ?>

<?php
$errors = array();
if (isset($_POST['addPost'])) {
    if (isset($_COOKIE['UserId'])) {
    } else {
        array_push($errors, "You have to be logged to post a new Article");
    }

    $title = string_db($_POST['article_Title']);
    $description = string_db($_POST['message_newpost']);
    $creation_date = string_db(date("Y-m-d-H-i-s"));
    $user_id = string_db($_COOKIE['UserId']);
    if (count($errors) == 0) {
        insert_db("INSERT INTO Articles (Title,Description,CreationDate,UserId) VALUES ('$title', '$description', now(), '$user_id')");
        header('location: index.php');
    }
}
print_error($errors);
?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Post</title>
    <style>
        <?php include 'static/css/new.css'; ?>
    </style>
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="new__post">
        <h1 class="pageTitle">Nouvel Article</h1>
        <!-- <p class="obligation">{{.Error}}</p> -->
        <div class="newpostForm">
            <form method="POST" enctype="multipart/form-data" id="form">
                <div class="post_Title">
                    <label for="articleTitle" id="articleTitle">Titre de l'article : </label>
                    <br>
                    <input type="text" id="article_Title" name="article_Title" placeholder="Entrez le titre de l'article" required>
                    <br>
                </div>
                <div class="text_area">
                    <label for="message">Message : </label>
                    <br>
                    <textarea name="message_newpost" id="message_newpost" cols="30" rows="10" value="Ecrivez quelque chose ..." required></textarea>
                </div>
        </div>
        <button class="Newpost_submit" type="submit" name="addPost">Soumettre</button>
        </form>
    </div>
</body>

</html>
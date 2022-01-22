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

<body>

    <?php include('navbar.php'); ?>

    <div class="new__post">
        <div class="N-title flex padding">
            <h1>Nouveau Topic</h1>
        </div>
        <!-- <p class="obligation">{{.Error}}</p> -->
        <div class="NewpostForm flex padding">
            <form method="POST" enctype="multipart/form-data" id="form">
                <div class="Titre_post">
                    <label for="titre-sujet" id="titre-sujet">Titre du Sujet : </label>
                    <br>
                    <input type="text" id="Titre_sujet" name="Titre_sujet" required>
                    <br>
                </div>
                <div class="text_area">
                    <label for="message">Message : </label>
                    <br>
                    <textarea name="message_newpost" id="message_newpost" cols="30" rows="10" value="Ecrivez quelque chose ..." required></textarea>
                </div>
        </div>
        <div class="btn-newpost flex">
            <div>
                <button class="Newpost_submit" type="submit" name="addTopic">Soumettre</button>
            </div>
        </div>
        </form>
    </div>
    </div>
</body>

<?php

$errors = array();
if (isset($_POST['addTopic'])) {
    if (isset($_COOKIE['UserId'])) {
    } else {
        array_push($errors, "You have to be logged to pos a new Article");
    }

    //-------------------------A ranger ? ----------------------------

    $mysqli = initiate_db();

    $title = mysqli_real_escape_string($mysqli, $_POST['Titre_sujet']);
    $description = mysqli_real_escape_string($mysqli, $_POST['message_newpost']);
    $creation_date = mysqli_real_escape_string($mysqli, date("Y-m-d H:i:s"));
    $user_id = mysqli_real_escape_string($mysqli, $_COOKIE['UserId']);
    $mysqli->close();
    if (count($errors) == 0) {
        insert_db("INSERT INTO Articles (Title,Description,CreationDate,UserId) VALUES ('$title', '$description', '$creation_date', '$user_id')");
        header('location: index.php');
    }
    $mysqli->close();
    //----------------------------------------------------
}
print_error($errors);
?>


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
    <header>
        <nav class="navbar">
            <div class="leftnav">
                <div id="forum_tittle">
                    <a href="/php_forum/index.php">Forum</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="new__post">
        <div class="N-title flex padding">
            <h1>Nouveau Topic</h1>
        </div>
        <!-- <p class="obligation">{{.Error}}</p> -->
        <div class="NewpostForm flex padding">
            <form method="GET" enctype="multipart/form-data" id="form">
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
                        <button class="Newpost_submit" type="submit">Soumettre</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<?php
echo $_GET['Titre_sujet'];
echo $_GET['message_newpost'];
?>

</html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Forum</title>
    <link rel="icon" href="/static/img/icon/forum.png">
    <!-- fontstyle -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Montserrat+Alternates:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/index.css">
</head>

<body>
    <header>
        <nav class="firstblock">
            <div class="forum_title">
                <!-- <div class="leftnav">
                    <img src="/static/img/icon/forum.png" alt="ForumIcon">
                    <a href="/index">Forum</a>
                </div> -->
                <div class="rightnav">
                    <div id="menu">
                        <!-- <a class="UserName" id="UserName" href="/user"><img src="/static/img/icon/usericon.png" alt="iconuser"> {{.User.Username}}</a> -->
                        <a href="/php_forum/login.php" id="Connexion" class="Connexion">Connexion</a>
                        <a href="/php_forum/register.php" id="Inscription" class="Inscription">Inscription</a>
                        <form method="post">
                            <button class="Deconnexion" id="Deconnexion" name="Deconnexion" value="run">Deconnexion</a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</body>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>

</body>

</html>



<?php


        $mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
        // si vous avez une erreur ici, remplacez le deuxième "root" par une string vide

        // Check connection
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        $result = $mysqli->query("SELECT * From Articles"); // On utilise l'instance créée pour faire une requête
        echo $result;
        $mysqli->close();
        ?>
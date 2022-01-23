<?php
function insert_db($insert_string)
{
    $mysqli  = initiate_db();
    $stmt = $mysqli->prepare($insert_string);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}
function select_db($select_string)
{
    $mysqli  = initiate_db();
    $results = $mysqli->query($select_string);
    $mysqli->close();
    return $results;
}

function initiate_db()
{
    try {
        $mysqli  = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $mysqli;
}

function print_error($errors)
{
    if (count($errors) > 0) {
?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error ?></p>
            <?php endforeach ?>
        </div>
    <?php
    }
}

function string_db($str)
{
    $mysqli  = initiate_db();
    $db_str = mysqli_real_escape_string($mysqli, $str);
    $mysqli->close();
    return $db_str;
}

function redirect_to_login(){
    
    if ( ! (isset($_COOKIE['UserId']) || isset($_COOKIE['AdminId']))) {
        echo "test";
        header('location: login.php');
    }
}




?>
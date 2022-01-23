<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <style>
        <?php include 'static/css/edit.css'; ?>
    </style>
</head>

<?php include('functions.php'); ?>
<?php redirect_to_login(); ?>


<?php
$errors = array();
if (isset($_COOKIE['UserId']) || isset($_COOKIE['AdminId'])) {
    if (isset($_GET['ArticleId'])) {
        //----------------------------------------------------
        $user_id = string_db($_COOKIE['UserId']);
        $article_id = string_db($_GET['ArticleId']);
        $results = select_db("SELECT * FROM Articles WHERE UserId='$user_id' AND ArticleId = '$article_id'");
        if (mysqli_num_rows($results) == 1) {

            $data = mysqli_fetch_array($results);
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

<?php
if (isset($_POST['editPost'])) {

    //------------------------------
    $title = string_db($_POST['article_Title']);
    $description = string_db($_POST['message_newpost']);
    $user_id = string_db($_COOKIE['UserId']);
    $article_id = string_db($_GET['ArticleId']);
    insert_db("UPDATE Articles SET Title = '$title', Description = '$description' WHERE ArticleId = '$article_id'");
    header('location: edit.php?ArticleId=' . $article_id);
}
?>

<?php if (count($errors) == 0) : ?>

    <body>
        <?php include('navbar.php'); ?>
        <div class="new__post">
            <h1 class="pageTitle">Modifier l'article</h1>
            <!-- <p class="obligation">{{.Error}}</p> -->
            <div class="newpostForm">
                <form method="POST" enctype="multipart/form-data" id="form">
                    <div class="post_Title">
                        <label for="articleTitle" id="articleTitle">Titre de l'article : </label>
                        <br>
                        <input type="text" id="article_Title" name="article_Title" value="<?php echo htmlentities(trim($data['Title'])); ?>" required>
                        <br>
                    </div>
                    <div class="text_area">
                        <label for="message">Message : </label>
                        <br>
                        <textarea name="message_newpost" id="message_newpost" cols="30" rows="10" required><?php echo htmlentities(trim($data['Description'])); ?></textarea>
                    </div>
            </div>
            <button class="Newpost_submit" type="submit" name="editPost">Soumettre</button>
            </form>
        </div>
    </body>



<?php else : ?>
    <?php print_error($errors); ?>
<?php endif ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Index</title>
	<style>
		<?php include 'static/css/index.css'; ?>
	</style>
</head>

<body>
	<div class="navbar">
		<a href="/php_forum/login.php">Connexion</a>
		<a href="/php_forum/register.php">Inscription</a>
		<a href="/php_forum/home.php">Accueil</a>
		<a href="/php_forum/new.php">Nouveau Post</a>
		<a href="/php_forum/details.php">Details</a>
		<a href="/php_forum/edit.php">Modifier</a>
		<a href="/php_forum/account.php">Compte</a>
		<a href="/php_forum/login_admin.php">Connexion Admin</a>
		<a href="/php_forum/panel_admin.php">Panel Admin</a>
		<form class="searchbar" method="post">
			<input type="text" placeholder="Cherchez un article" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
			<input type="submit" name="submit">
		</form>
	</div>

</body>

</html>

<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"

if (isset($_POST["submit"])) {
	$str = $_POST["search"];
	$results = $mysqli->query("SELECT Title FROM Articles WHERE Title LIKE '$str'");

	while ($data = mysqli_fetch_array($results)) {
		if ($str == $data['ArticleId']) {
			header("Location : http://localhost/php_forum/details.php?ArticleId=" . $data['ArticleId']);
		}
	}
}
?>
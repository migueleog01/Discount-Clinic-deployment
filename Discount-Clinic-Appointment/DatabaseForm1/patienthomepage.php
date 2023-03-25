<?php 
session_start();
//ob_start();

	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<a href="form.php">Click to Fill Out Patient Form<a><br><br>
	<a href="logout.php">Logout</a>
	<h1>Home page</h1>

	<br>
	Hello, <?php echo $user_data['username']; ?>
</body>
</html>

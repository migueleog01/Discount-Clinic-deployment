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
	<title>Medical Clinic Home Page</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<header>
		<h1><center>Discount Clinic</center></h1>
		<nav>
			<ul>
				<li class ="active"><a href="doctorhomepage.php">Home</a></li>
				<li><a href="doctorappointments.php">Appointments</a></li>
                <li><a href="./doctorprofile.php">Profile</a></li>
			</ul>
		</nav>
	</header>
    <main>
		<h2><center>Hello, <?php echo $user_data['username']; ?></center></h2>

</body>
</html>

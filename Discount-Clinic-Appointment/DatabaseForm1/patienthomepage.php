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
				<li class ="active"><a href="#">Home</a></li>
			<!-- <li><a href="patient_appointment_list.php">Appointments</a></li> -->
				<li><a href="./patientappointments.php">Schedule Appointment</a></li>
                <li><a href="transactions.php">Transactions</a></li>
               <!-- <li><a href="patientprofile.php">Profile</a></li> -->
				<li><a href ="form.php">Patient Form</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<h2><center>Welcome, <?php echo $user_data['username']; ?></center></h2>
        <h4>About Us</h4>
		<p>Our clinic provides high-quality medical services to patients of all ages at a minimal cost. We have a team of experienced doctors who are dedicated to your health and well-being. Book an appointment at your convenience at one of our various offices across the nation. </p>
		<div class="services">
			<h3>Our Services</h3>
				<p>General Medicine</p>
				<p>Pediatrics</p>
				<p>Cardiology</p>
				<p>Dermatology</p>
		</div>
</html>


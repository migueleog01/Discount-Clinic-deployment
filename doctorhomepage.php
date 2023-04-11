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
				<li><a href="logout.php">Logout</a></li>

	<?php
	
	    $TEST = $user_data['username'];
		$query = "SELECT user_id FROM user WHERE username = '$TEST'";
		$result = mysqli_query($conn, $query);
		if($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			$user_id = $user_data['user_id'];
		} 

		$query = "SELECT doctor.doctor_id FROM doctor,patient WHERE doctor.user_id = '$user_id' AND doctor.doctor_id=patient.primary_doctor_id";
		$result = mysqli_query($conn, $query);

		if($result && mysqli_num_rows($result) > 0) {
			$doctor_data = mysqli_fetch_assoc($result);
			$doctor_id = $doctor_data['doctor_id'];
			echo "<li><a href='approval.php'>Approval</a></li>";
		}
	
	?>

			</ul>
		</nav>
	</header>
    <main>
		<h2><center>Hello, <?php echo $TEST; ?></center></h2>
	</main>

</body>
</html>

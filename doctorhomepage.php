<?php 
session_start();

	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);

	$TEST = $user_data['username'];
	$query = "SELECT user_id FROM user WHERE username = '$TEST'";
	$result = mysqli_query($conn, $query);
	if($result && mysqli_num_rows($result) > 0) {
		$user_data = mysqli_fetch_assoc($result);
		$user_id = $user_data['user_id'];
	} 

	$query = "SELECT doctor_id FROM doctor WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $query);

	if($result && mysqli_num_rows($result) > 0) {
		$doctor_data = mysqli_fetch_assoc($result);
		$doctor_id = $doctor_data['doctor_id'];
	}

	$other_query = "SELECT specialty FROM doctor WHERE doctor_id = '$doctor_id'";
	$res = $conn->query($other_query);
	
	$sql = "SELECT * FROM appointment WHERE doctor_id = '$doctor_id' AND deleted = FALSE";

	$sql = "SELECT * 
	FROM discount_clinic.appointment, discount_clinic.office, discount_clinic.address, discount_clinic.doctor, discount_clinic.patient
	WHERE doctor.doctor_id = '$doctor_id' AND office.address_id = address.address_id AND appointment.office_id = office.office_id AND appointment.doctor_id = doctor.doctor_id AND patient.patient_id = appointment.patient_id";
	$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Medical Clinic Home Page</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<style>
	table {
		border-collapse: collapse;
		width: 100%;
	}

	th, td {
		text-align: center;
		padding: 8px;
		border: 1px solid #ddd;
	}

	tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	h1 {
		font-size: 50px;
		margin-bottom: 20px;
	}

	.container {
		margin: auto;
		max-width: 800px;
		padding: 20px;
	}
</style>
<body>
	<header>
		<h1><center>Discount Clinic</center></h1>
		<nav>
			<ul>
				<li class ="active"><a href="doctorhomepage.php">Home</a></li>
				<li><a href="doctor_profile.php">Profile</a></li>
				<li><a href="doctorappointments.php">Appointments</a></li>
				
				
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
</body>
    
	
</html>

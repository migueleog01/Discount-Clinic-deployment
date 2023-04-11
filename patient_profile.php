<?php
	session_start();
	include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id = $user_data['user_ID'];

    $patient = "SELECT first_name, middle_initial, last_name, gender, patient.phone_number AS patient_phone_number, DOB, total_owe, e_first_name, e_middle_initial, e_last_name, emergency_contact.phone_number AS ec_phone_number, relationship, street_address, zip, state, city
	FROM discount_clinic.patient, discount_clinic.emergency_contact, discount_clinic.user, discount_clinic.address
	WHERE patient.patient_id = emergency_contact.patient_id AND user.user_id = patient.user_id AND patient.address_id = address.address_id AND user.user_id = '$user_id'";
	 
   	

    $patient_result = mysqli_query($conn, $patient);

	if($patient_result && mysqli_num_rows($patient_result) > 0) {
		$user_data = mysqli_fetch_assoc($patient_result);
		$user_first_name = $user_data['first_name'];
		$user_middle_initial =  $user_data['middle_initial'];
		$user_last_name =  $user_data['last_name'];
		$gender = $user_data['gender'];
		$phone_number = $user_data['patient_phone_number'];
		$DOB = $user_data['DOB'];
		$total_owe = $user_data['total_owe'];


		$street_address = $user_data['street_address'];
		$city = $user_data['city'];
		$state = $user_data['state'];
		$zip = $user_data['zip'];


		$e_first_name = $user_data['e_first_name'];
		$e_middle_initial = $user_data['e_middle_initial'];
		$e_last_name = $user_data['e_last_name'];
		$e_phone_number = $user_data['ec_phone_number'];
		$relationship = $user_data['relationship'];
	} 


	$output = $row['first_name'];
	$output = $row['last_name'];
	echo $output;
	
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Patient Profile</title>
	<header>
		<h1><center>Patient Profile</center></h1>
		<nav>
			<ul>
				<li class ="active"><a href="index.php">Home</a></li>
				<li><a href="patient_profile.php">Profile</a></li>
				<li><a href="patientappointments.php">Schedule Appointment</a></li>
        		<li><a href="transactions.php">Transactions</a></li>
				<li><a href ="form.php">Patient Form</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
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
</head>
<body>
	<h2>Personal Information</h2>
	<?php 

		echo "Name: " . $user_first_name . " " . $user_middle_initial . " " . $user_last_name . "<br>";
		echo "Address: " . $street_address . " " . $city . ", " . $state . " " . $zip . "<br>";
		echo "Gender: " . $gender . "<br>";
		echo "Date of Birth: " . $DOB . "<br>";
		echo "Phone Number: " . $phone_number . "<br>";

	 ?>
	 <h2>Emergency Contact Information</h2>
	 <?php 

	 	echo "Name: " . $e_first_name . " " . $e_middle_initial . " " . $e_last_name . "<br>";
	 	echo "Phone Number: " . $e_phone_number . "<br>";
	 	echo "Relationship: " . $relationship . "<br>";
	  ?>
</body>
</html>

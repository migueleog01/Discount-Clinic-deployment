<?php
ob_start();
session_start();
include("dbh-inc.php");
include("functions.php");

$user_data = check_login($conn);
$user_id = $user_data['user_ID'];

$patient = "SELECT patient.first_name AS patient_first_name, patient.middle_initial AS patient_middle_initial, patient.last_name AS patient_last_name, patient.gender AS patient_gender, patient.phone_number AS patient_phone_number, patient.DOB AS patient_dob, total_owe, e_first_name, e_middle_initial, e_last_name, emergency_contact.phone_number AS ec_phone_number, relationship, street_address, zip, state, city, doctor.first_name AS doctor_first_name, doctor.middle_initial AS doctor_middle_intital, doctor.last_name AS doctor_last_name, doctor.phone_number AS doctor_phone_number, specialty
FROM discount_clinic.patient, discount_clinic.emergency_contact, discount_clinic.user, discount_clinic.address, discount_clinic.doctor
WHERE patient.patient_id = emergency_contact.patient_id AND user.user_id = patient.user_id AND patient.address_id = address.address_id AND doctor.doctor_id = patient.primary_doctor_id AND doctor.deleted = FALSE AND user.user_id = '$user_id'";


$patient_information = "SELECT patient.first_name AS patient_first_name, patient.middle_initial AS patient_middle_initial, patient.last_name AS patient_last_name, patient.gender AS patient_gender, patient.phone_number AS patient_phone_number, patient.DOB AS patient_dob, total_owe, e_first_name, e_middle_initial, e_last_name, emergency_contact.phone_number AS ec_phone_number, relationship, street_address, zip, state, city
FROM discount_clinic.patient, discount_clinic.emergency_contact, discount_clinic.user, discount_clinic.address
WHERE patient.patient_id = emergency_contact.patient_id AND user.user_id = patient.user_id AND patient.address_id = address.address_id AND user.user_id = '$user_id'";



$patient_result = mysqli_query($conn, $patient_information);

if ($patient_result && mysqli_num_rows($patient_result) > 0) {
	$patient_result = mysqli_fetch_assoc($patient_result);
	$user_first_name = $patient_result['patient_first_name'];
	$user_middle_initial =  $patient_result['patient_middle_initial'];
	$user_last_name =  $patient_result['patient_last_name'];
	$gender = $patient_result['patient_gender'];
	$phone_number = $patient_result['patient_phone_number'];
	$DOB = $patient_result['patient_dob'];
	$total_owe = $patient_result['total_owe'];


	$street_address = $patient_result['street_address'];
	$city = $patient_result['city'];
	$state = $patient_result['state'];
	$zip = $patient_result['zip'];


	$e_first_name = $patient_result['e_first_name'];
	$e_middle_initial = $patient_result['e_middle_initial'];
	$e_last_name = $patient_result['e_last_name'];
	$e_phone_number = $patient_result['ec_phone_number'];
	$relationship = $patient_result['relationship'];
} 

?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Patient Profile</title>
	<header>
		<h1>
			<center>Patient Profile</center>
		</h1>
		<nav>
			<ul>
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="patient_profile.php">Profile</a></li>
				<li><a href="patientappointments.php">Schedule Appointment</a></li>
				<li><a href="transactions.php">Transactions</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th,
		td {
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

		a.delete {
			display: inline-block;
			padding: 10px 20px;
			background-color: #f44336;
			color: white;
			text-align: center;
			text-decoration: none;
			font-size: 16px;
			border-radius: 4px;
			border: none;
			cursor: pointer;
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
	<h2>Primary Doctor Information</h2>
	<?php	

	$primary_doctor_information = "SELECT doctor.first_name AS D_first_name, doctor.middle_initial AS D_middle_initial, doctor.last_name AS D_last_name, doctor.phone_number AS D_phone_number, specialty
	FROM discount_clinic.doctor, discount_clinic.patient
	WHERE patient.primary_doctor_id = doctor.doctor_id AND doctor.deleted = FALSE AND patient.user_id = '$user_id'";

	$primary_doctor_result = mysqli_query($conn, $primary_doctor_information);


	if($primary_doctor_result && mysqli_num_rows($primary_doctor_result) > 0){
		$primary_doctor_result = mysqli_fetch_assoc($primary_doctor_result);
		$doctor_first_name = $primary_doctor_result['D_first_name'];
		$doctor_mi = $primary_doctor_result['D_middle_initial'];
		$doctor_last_name = $primary_doctor_result['D_last_name'];
		$doctor_phone_number = $primary_doctor_result['D_phone_number'];
		$specialty = $primary_doctor_result['specialty'];
		echo "Primary Doctor Name: " . $doctor_first_name . " " . $doctor_mi . " " . $doctor_last_name . "<br>";
		echo "Phone Number: " . $doctor_phone_number . "<br>";
		echo "Specialty: " . $specialty . "<br>";
	} else {
		echo "No primary doctor assigned.";
	}
	?>
	<?php
	if (!isset($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	?>
	<h2>Edit Information</h2>
	<form method="post" action="" onsubmit="window.location.reload()">
		<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
		<label for="field">Select field to update:</label>
		<select id="field" name="field">
			<option value="first_name">First Name</option>
			<option value="middle_initial">Middle Initial</option>
			<option value="last_name">Last Name</option>
			<option value="gender">Gender</option>
			<option value="phone_number">Phone Number</option>
			<option value="DOB">Date of Birth</option>
			<option value="street_address">Street Address</option>
			<option value="city">City</option>
			<option value="state">State</option>
			<option value="zip">Zip Code</option>
			<option value="e_first_name">Emergency Contact First Name</option>
			<option value="e_middle_initial">Emergency Contact Middle Initial</option>
			<option value="e_last_name">Emergency Contact Last Name</option>
			<option value="ec_phone_number">Emergency Contact Phone Number</option>
			<option value="relationship">Relationship</option>
		</select>
		<label for="new_value">Enter new value:</label>
		<input type="text" id="new_value" name="new_value">
		<input type="submit" value="Update">
	</form>


	<a class = "delete" href="patient_change_doctor.php">Click to Change Primary Doctor</a>


	<h2>Delete Account</h2>
	<a class = "delete" href="delete_account.php">Click to Delete Account</a>


</body>
</html>


<?php
ob_start();
include("dbh-inc.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
		die('Invalid CSRF token');
	}
}
$user_data = check_login($conn);
$user_id_fk = $user_data['user_ID'];


//get patient id using user id
$sql = "SELECT patient_id FROM patient WHERE user_id = '$user_id_fk'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$patient_id_fk = $row['patient_id'];


//get address id using user id
$sql = "SELECT address_id FROM patient WHERE user_id = '$user_id_fk'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$address_id_fk = $row['address_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$field = $_POST['field'];
	switch ($field) {
		case "first_name":
			if(ctype_alpha($_POST['new_value'])){
				$sql = "UPDATE patient SET first_name = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Refresh:0");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				header("Refresh:0");
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit middle initial
		case "middle_initial":
			if(ctype_alpha($_POST['new_value'])){
				$sql = "UPDATE patient SET middle_initial = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit last name
		case "last_name":
			if(ctype_alpha($_POST['new_value'])){
				$sql = "UPDATE patient SET last_name = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit gender
		case "gender":
			if(ctype_alpha($_POST['new_value'])) {
				$sql = "UPDATE patient SET gender = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit phone number
		case "phone_number":
			$sql = "UPDATE patient SET phone_number = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
			if (mysqli_query($conn, $sql)) {
				echo "Record updated successfully";
				header("Location: patient_profile.php");
			} else {
				echo "Error updating record: " . mysqli_error($conn);
			}
			break;
			// edit street address
		case "street_address":
			if(ctype_alnum(str_replace(' ', '', $_POST['new_value']))) {
				$sql = "UPDATE address SET street_address = '$_POST[new_value]' WHERE address_id = '$address_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
		case "city":
			if(ctype_alpha(str_replace(' ', '', $_POST['new_value']))) {
				$sql = "UPDATE address SET city = '$_POST[new_value]' WHERE address_id = '$address_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit state
		case "state":
			if(ctype_alpha($_POST['new_value'])) {
				$sql = "UPDATE address SET state = '$_POST[new_value]' WHERE address_id = '$address_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit zip code
		case "zip":
			if(ctype_digit($_POST['new_value'])) {
				$sql = "UPDATE address SET zip = '$_POST[new_value]' WHERE address_id = '$address_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit emergency contact name
		case "e_first_name":
			if(ctype_alpha($_POST['new_value'])) {
				$sql = "UPDATE emergency_contact SET e_first_name = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
			//edit emergency middle initial
		case "e_middle_initial":
			if(ctype_alpha($_POST['new_value'])) {
				$sql = "UPDATE emergency_contact SET e_middle_initial = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
		
		//edit emergency last name
		case "e_last_name":
			if(ctype_alpha($_POST['new_value'])) {
				$sql = "UPDATE emergency_contact SET e_last_name = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
		//edit emergency phone number
		case "ec_phone_number":
			$sql = "UPDATE emergency_contact SET phone_number = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
			if (mysqli_query($conn, $sql)) {
				echo "Record updated successfully";
				header("Location: patient_profile.php");
			} else {
				echo "Error updating record: " . mysqli_error($conn);
			}
			break;
		
			//edit relationship from emergency contact
		case "relationship":
			if(ctype_alpha(str_replace(' ', '', $_POST['new_value']))) {
				$sql = "UPDATE emergency_contact SET relationship = '$_POST[new_value]' WHERE patient_id = '$patient_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: patient_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			} else {
				echo "Invalid input";
				break;
			}
	}
}
ob_flush();
?>

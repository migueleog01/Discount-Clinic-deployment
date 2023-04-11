<?php
	session_start();
	include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id = $user_data['user_ID'];
    $username = $user_data['username'];


    $patient = "SELECT *
				FROM discount_clinic.doctor, discount_clinic.user
				WHERE doctor.user_id = user.user_id AND user.username = '$username'";
	 
   	
    $patient_result = mysqli_query($conn, $patient);

	if($patient_result && mysqli_num_rows($patient_result) > 0) {
		$user_data = mysqli_fetch_assoc($patient_result);
		$user_first_name = $user_data['first_name'];
		$user_middle_initial =  $user_data['middle_initial'];
		$user_last_name =  $user_data['last_name'];
		$gender = $user_data['gender'];
		$specialty = $user_data['specialty'];
		$phone_number = $user_data['phone_number'];
		$DOB = $user_data['DOB'];
	} 

	$sql = "SELECT * 
	FROM discount_clinic.doctor_office, discount_clinic.office, discount_clinic.address, discount_clinic.doctor
	WHERE doctor_office.OID = office.office_id AND office.address_id = address.address_id AND doctor.doctor_id = doctor_office.DID AND doctor.doctor_id = 3";
	$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Doctor Profile</title>
	<header>
		<h1><center>Doctor Profile</center></h1>
		<nav>
			<ul>
				<li class ="active"><a href="doctorhomepage.php">Home</a></li>
				<li><a href="doctor_profile.php">Profile</a></li>
				<li><a href="doctorappointments.php">Appointments</a></li>
                <li><a href="approval.php">Approvals</a></li>
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
		echo "Specialty: " . $specialty . "<br>";
		echo "Gender: " . $gender . "<br>";
		echo "Date of Birth: " . $DOB . "<br>";
		echo "Phone Number: " . $phone_number . "<br>";
	 ?>
	 <h2>Office Locations</h2>
	 <?php 
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>" . "<br>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td colspan='5'>This doctor does not work at any offices.</td></tr>";
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
			<option value="specialty">Specialty</option>
		</select>
		<label for="new_value">Enter new value:</label>
		<input type="text" id="new_value" name="new_value">
		<input type="submit" value="Update">
	</form>
</body>
</html>

<?php	
	ob_start();
	include("dbh-inc.php");
	$user_data = check_login($conn);
	$user_id_fk = $user_data['user_ID'];

	//get patient id using user id
	$sql = "SELECT doctor_id FROM doctor WHERE user_id = '$user_id_fk'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$doctor_id_fk = $row['doctor_id'];

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$field = $_POST['field'];
		switch ($field) {
			case "first_name":
				$sql = "UPDATE doctor SET first_name = '$_POST[new_value]' WHERE doctor_id = '$doctor_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Refresh:0");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				header("Refresh:0");
				break;
			case "middle_initial":
				$sql = "UPDATE doctor SET middle_initial = '$_POST[new_value]' WHERE doctor_id = '$doctor_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: doctor_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			case "last_name":
				$sql = "UPDATE doctor SET last_name = '$_POST[new_value]' WHERE doctor_id = '$doctor_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: doctor_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			case "gender":
				$sql = "UPDATE doctor SET gender = '$_POST[new_value]' WHERE doctor_id = '$doctor_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: doctor_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			case "phone_number":
				$sql = "UPDATE doctor SET phone_number = '$_POST[new_value]' WHERE doctor_id = '$doctor_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: doctor_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
			case "specialty":
				$sql = "UPDATE specialty SET specialty = '$_POST[new_value]' WHERE doctor_id = '$doctor_id_fk'";
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
					header("Location: doctor_profile.php");
				} else {
					echo "Error updating record: " . mysqli_error($conn);
				}
				break;
		}
	}
	ob_flush();
?>
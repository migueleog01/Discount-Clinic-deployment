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
				<li class ="active"><a href="#">Home</a></li>
			<!-- <li><a href="patient_appointment_list.php">Appointments</a></li> -->
				<li><a href="patient_profile.php">Profile</a></li>
				<li><a href="patientappointments.php">Schedule Appointment</a></li>
                <li><a href="transactions.php">Transactions</a></li>
               <li><a href="patientprofile.php">Profile</a></li>
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
<h3> UPCOMING Appointments</h3>
<table>
  <thead>
    <tr>
      <th>Appointment ID</th>
      <th>Doctor Name</th>
      <th>Office ID</th>
      <th>Date</th>
      <th>Time</th>
      <th>Address</th>
      <th>City</th>
      <th>State</th>
      <th>Zipcode</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
	<?php
		

		$TEST = $user_data['username'];
		$query = "SELECT user_id FROM user WHERE username = '$TEST'";
		$result = mysqli_query($conn, $query);
		echo $TEST;
		if($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			$user_id = $user_data['user_id'];
			echo "User ID for $user_id";
		} 



		$query = "SELECT patient_id FROM patient WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $query);

		if($result && mysqli_num_rows($result) > 0) {
			$patient_data = mysqli_fetch_assoc($result);
			$patient_id = $patient_data['patient_id'];
			echo  $patient_id;
		}
		

		$sql = "SELECT * FROM appointment WHERE patient_id = '$patient_id'";
		/*
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['appointment_id'] . "</td>";
				
				echo "<td>" . $row['office_id'] . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>" . $row['time'] . "</td>";
				
				echo "</tr>";
			}
		} else {
			echo "<tr><td colspan='4'>No appointments found.</td></tr>";
		}
		*/
		/*
		$sql = "SELECT appointment.*, doctor.doctor_id, doctor.d_first_name, doctor.d_last_name 
		FROM appointment 
		INNER JOIN doctor ON appointment.doctor_id = doctor.doctor_id 
		WHERE appointment.patient_id = '$patient_id'";
		*/
		$sql = "SELECT * 
		FROM discount_clinic.appointment, discount_clinic.office, discount_clinic.address, discount_clinic.doctor
		WHERE patient_id = '$patient_id' AND office.address_id = address.address_id AND appointment.office_id = office.office_id AND appointment.doctor_id = doctor.doctor_id" ;

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				
				echo "<td>" . $row['appointment_id'] . "</td>";
				echo "<td>" . $row['d_first_name'] . " " . $row['d_last_name'] ."</td>";

				//echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
				
				echo "<td>" . $row['office_id'] . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>" . $row['time'] . "</td>";
				echo "<td>" . $row['street_address'] . "</td>";
				echo "<td>" . $row['city'] . "</td>";
				echo "<td>" . $row['state'] . "</td>";
				echo "<td>" . $row['zip'] . "</td>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td colspan='5'>No appointments found.</td></tr>";
		}
		
		





		// close connection
		$conn->close();
		






	?>

  </tbody>
</table>
</body>









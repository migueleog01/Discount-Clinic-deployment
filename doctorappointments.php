<?php
ob_start();
session_start();

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

<?php
include("isnotspecialist.php");

	$sql = "SELECT * 
	FROM discount_clinic.appointment, discount_clinic.office, discount_clinic.address, discount_clinic.doctor, discount_clinic.patient
	WHERE doctor.doctor_id = '$doctor_id' AND office.address_id = address.address_id AND appointment.office_id = office.office_id AND appointment.doctor_id = doctor.doctor_id AND patient.patient_id = appointment.patient_id";
	$result = $conn->query($sql);
?>

				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
</body>
    
	<h2><center>Hello, <?php $user_data = check_login($conn); echo $user_data['username']; ?></center></h2>
	<h3>Upcoming Appointments</h3>
	<table>
		<thead>
		    <tr>
		      <th>Appointment ID</th>
		      <th>Patient Name</th>
		      <th>Date</th>
		      <th>Time</th>
		      <th>Office Location</th>
		    </tr>
	  	</thead>
	  	<tbody>	
	<?php
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['appointment_id'] . "</td>";
				echo "<td>" . $row['first_name'] . " " . $row['last_name'] ."</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>" . $row['time'] . "</td>";
				echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td colspan='5'>No appointments found.</td></tr>";
		}
		$conn->close();
	?>
	

	  	</tbody>
	</table>

</html>
<!DOCTYPE html>
<html>
<head>
	<title>Doctor Appointment Viewer</title>
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
		}
	</style>
</head>
<body>
	<h1><center>Discount Clinic</center></h1>
	<h2>Scheduled Appointments</h2>
	<table>
		<thead>
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Patient Name</th>
				<th>Reason for Visit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// replace with your database credentials
			session_start();
			include("dbh-inc.php");
			include("functions.php");

			$user_data = check_login($conn);
			// retrieve appointments for the currently logged in doctor
			//$doctor_id = $user_data['username']; // replace with the doctor's ID
			//echo $doctor_id;
			$username = $user_data['username'];
			$query = "SELECT user_id FROM user WHERE username = '$username'";
			$result = mysqli_query($conn, $query);

			// Check if the query was successful
			if ($result && mysqli_num_rows($result) > 0) {
				$user_data = mysqli_fetch_assoc($result);
				$doctor_id = $user_data['user_id'];
				echo "User ID for $doctor_id";
			} else {
				echo "User not found";
			}


			//$doctor_id = 305; // replace with the doctor's ID
			//echo $doctor_id;
			//$sql = "SELECT * FROM appointment WHERE doctor_id = $doctor_id";
			$sql = "SELECT *
			FROM discount_clinic.patient
			JOIN discount_clinic.appointment ON appointment.patient_id = patient.patient_id
			WHERE appointment.doctor_id = $doctor_id";
			$result = $conn->query($sql);

			// display each appointment as a row in the table
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $row["date"] . "</td>";
					echo "<td>" . $row["time"] . "</td>";
					echo "<td>" . $row["first_name"] . "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='4'>No appointments found.</td></tr>";
			}

			// close connection
			$conn->close();
			?>
		</tbody>
	</table>
</body>
</html>


<?php 
	//echo "Hello World";
	include("dbh-inc.php");

?>
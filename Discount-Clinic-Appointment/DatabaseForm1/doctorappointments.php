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
			include("dbh-inc.php");

			// retrieve appointments for the currently logged in doctor
			$doctor_id = 305; // replace with the doctor's ID
			$sql = "SELECT * FROM appointment WHERE doctor_id = $doctor_id";
			$result = $conn->query($sql);

			// display each appointment as a row in the table
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $row["date"] . "</td>";
					echo "<td>" . $row["time"] . "</td>";
					echo "<td>" . $row["patient_id"] . "</td>";
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
<?php
ob_start();
session_start();

include("dbh-inc.php");
include("functions.php");

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
</style>

<script>
	// Update the approval status and primary doctor ID
	function approveAppointment(approval_id, doctor_id) {
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "update_approval.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
				alert(this.responseText);
				location.reload();
			}
		};
		xhr.send("approval_id=" + approval_id + "&doctor_id=" + doctor_id);
	}
</script>

<body>
	<header>
		<h1>
			<center>Discount Clinic</center>
		</h1>
		<nav>
			<ul>
				<li class="active"><a href="doctorhomepage.php">Home</a></li>
				<li><a href="doctor_profile.php">Profile</a></li>
				<li><a href="doctorappointments.php">Appointments</a></li>
				<li><a href="approval.php">Approvals</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
</body>

<h2>
	<center>Hello, <?php $user_data = check_login($conn);
					echo $user_data['username']; ?></center>
</h2>

<h3>Requested Specialist Appointments</h3>
<table>
	<thead>
		<tr>
			<th>Appointment ID</th>
			<th>Patient Name</th>
			<th>Doctor</th>
			<th>Date</th>
			<th>Time</th>
			<th>Office Location</th>
			<!-- <th>Approval ID</th> -->
			<th>Approval Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		
		$user_data = check_login($conn);

		// Get the doctor ID
		$TEST = $user_data['username'];
		$query = "SELECT user_id FROM user WHERE username = '$TEST'";
		$result = mysqli_query($conn, $query);
		if ($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			$user_id = $user_data['user_id'];
		}

		$query = "SELECT doctor_id FROM doctor WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $query);

		if ($result && mysqli_num_rows($result) > 0) {
			$doctor_data = mysqli_fetch_assoc($result);
			$doctor_id = $doctor_data['doctor_id'];
		}

		$awaiting_approval = "
		SELECT
			appointment.*,
			office.*,
			doctor.first_name AS doctor_first_name,
			doctor.last_name AS doctor_last_name,
			patient.first_name AS patient_first_name,
			patient.last_name AS patient_last_name,
			approval.*,
			address.*
		FROM
			discount_clinic.appointment
			INNER JOIN discount_clinic.office ON appointment.office_id = office.office_id
			INNER JOIN discount_clinic.doctor ON appointment.doctor_id = doctor.doctor_id
			INNER JOIN discount_clinic.patient ON appointment.patient_id = patient.patient_id
			INNER JOIN discount_clinic.approval ON appointment.doctor_id = approval.specialist_doctor_id AND patient.patient_id = approval.patient_id
			INNER JOIN discount_clinic.address ON office.address_id = address.address_id
		WHERE
			approval.approval_bool = false
			AND doctor.specialty <> 'primary'
			AND patient.primary_doctor_id = '$doctor_id'
		ORDER BY
			TIMESTAMP(appointment.date, appointment.time) ASC
	";

		$res = $conn->query($awaiting_approval);

		if ($res->num_rows > 0) {
			while ($row = $res->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['appointment_id'] . "</td>";
				$pf_name = $row['patient_first_name'];
				$pl_name = $row['patient_last_name'];
				$d_first = $row['doctor_first_name'];
				$d_last = $row['doctor_last_name'];
				echo "<td>" . $pf_name . " " . $pl_name . "</td>";
				echo "<td>" . $d_first . " " . $d_last . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>" . $row['time'] . "</td>";
				echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
				$approval_status = $row['approval_bool'];
				if ($approval_status == 1) {
					$approval_status = "Approved";
				} else {
					$approval_status = "Not Approved";
				}
				echo "<td>" . $approval_status . "</td>";
				echo "<td><button onclick=\"approveAppointment(" . $row['approval_id'] . ", " . $doctor_id . ")\">Approve</button></td>";
				echo "</tr>";
			}
		}
		?>
	</tbody>
</table>

<h3>Approved Specialist Appointments</h3>
<table>
	<thead>
		<tr>
			<th>Appointment ID</th>
			<th>Patient Name</th>
			<th>Doctor</th>
			<th>Date</th>
			<th>Time</th>
			<th>Office Location</th>
			<!-- <th>Approval ID</th> -->
			<th>Approval Status</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$user_data = check_login($conn);

		// Get the doctor ID
		$TEST = $user_data['username'];
		$query = "SELECT user_id FROM user WHERE username = '$TEST'";
		$result = mysqli_query($conn, $query);
		if ($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			$user_id = $user_data['user_id'];
		}

		$query = "SELECT doctor_id FROM doctor WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $query);

		if ($result && mysqli_num_rows($result) > 0) {
			$doctor_data = mysqli_fetch_assoc($result);
			$doctor_id = $doctor_data['doctor_id'];
		}

		$awaiting_approval = "
		SELECT
			appointment.*,
			office.*,
			doctor.first_name AS doctor_first_name,
			doctor.last_name AS doctor_last_name,
			patient.first_name AS patient_first_name,
			patient.last_name AS patient_last_name,
			approval.*,
			address.*
		FROM
			discount_clinic.appointment
			INNER JOIN discount_clinic.office ON appointment.office_id = office.office_id
			INNER JOIN discount_clinic.doctor ON appointment.doctor_id = doctor.doctor_id
			INNER JOIN discount_clinic.patient ON appointment.patient_id = patient.patient_id
			INNER JOIN discount_clinic.approval ON appointment.doctor_id = approval.specialist_doctor_id AND patient.patient_id = approval.patient_id
			INNER JOIN discount_clinic.address ON office.address_id = address.address_id
		WHERE
			approval.approval_bool = true
			AND doctor.specialty <> 'primary'
			AND patient.primary_doctor_id = '$doctor_id'
		ORDER BY
			TIMESTAMP(appointment.date, appointment.time) ASC
	";

		$res = $conn->query($awaiting_approval);

		if ($res->num_rows > 0) {
			while ($row = $res->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['appointment_id'] . "</td>";
				$pf_name = $row['patient_first_name'];
				$pl_name = $row['patient_last_name'];
				$d_first = $row['doctor_first_name'];
				$d_last = $row['doctor_last_name'];
				echo "<td>" . $pf_name . " " . $pl_name . "</td>";
				echo "<td>" . $d_first . " " . $d_last . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>" . $row['time'] . "</td>";
				echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
				$approval_status = $row['approval_bool'];
				if ($approval_status == 1) {
					$approval_status = "Approved";
				} else {
					$approval_status = "Not Approved";
				}
				echo "<td>" . $approval_status . "</td>";
				echo "</tr>";
			}
		}
		?>
	</tbody>
</table>

</html>

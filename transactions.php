<?php 
ob_start();
session_start();

	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html>
<header>
		<h1><center>Discount Clinic Transactions</center></h1>
		<nav>
			<ul>
				<link rel="stylesheet" type="text/css" href="styles.css">
				<li class ="active"><a href="index.php">Home</a></li>
				<li><a href="patient_profile.php">Profile</a></li>
				<li><a href="patientappointments.php">Schedule Appointment</a></li>
		        <li><a href="transactions.php">Transactions</a></li>
				<!--<li><a href ="form.php">Patient Form</a></li>-->
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
<head>
	<title>Medical Clinic Transactions</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
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
	<h2> Make Payment </h2>
	<form method = "post" action = "" >
		<fieldset>
			<legend>Payment Information</legend>
			<label for="payment_method">Payment Method:</label>
			<select id="payment_method" name="payment_method" required>
				<option value="">Select Payment Method</option>
				<option value="cash">Cash</option>
				<option value="credit_card">Credit Card</option>
				<option value="debit_card">Debit Card</option>
				<option value="check">Check</option>
			</select><br>

			<label for="payment_amount">Payment Amount:</label>
			<input type="text" id="payment_amount" name="payment_amount" required><br>
		</fieldset>

		<input type="submit" value="Submit">
	</form>
	    <br>
	<h2>Total Amount Owe</h2>
	<table>	
	<?php 
		$username = $user_data['username'];

			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$moneyAmountInputted = $_POST['payment_amount'];
				
				$query_patient_id = "SELECT *
				FROM discount_clinic.patient, discount_clinic.user, discount_clinic.appointment
				WHERE patient.user_id = user.user_id AND appointment.patient_id = patient.patient_id AND user.username = '$username'";

				$patient_info = $conn->query($query_patient_id);
				$row = $patient_info->fetch_assoc();

				$patient_id = $row["patient_id"];
				$appointment_id = $row["appointment_id"];

				
				$insertQ = "INSERT INTO discount_clinic.transaction (patient_id, appointment_id, amount, pay) 
						VALUES ($patient_id, $appointment_id, $moneyAmountInputted, 1)";

				mysqli_query($conn, $insertQ);
			}


		$query = 
		"SELECT * 
		FROM discount_clinic.transaction, discount_clinic.appointment, discount_clinic.patient, discount_clinic.user
		WHERE transaction.appointment_id = appointment.appointment_id AND patient.patient_id = appointment.patient_id AND patient.user_id = user.user_id AND user.username = '$username'
		ORDER BY appointment.date ASC";

		$result = $conn->query($query);
		$row = $result->fetch_assoc();

		echo "<td>" . $row["total_owe"] . "</td>";
	 ?>
	</table>
    <h2> All Transactions </h2>
    <table>
		<thead>
			<tr>
				<th>Transaction Date</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// replace with your database credentials
			


			
			
			$query = "SELECT * 
			FROM discount_clinic.transaction, discount_clinic.appointment, discount_clinic.patient, discount_clinic.user
			WHERE transaction.appointment_id = appointment.appointment_id AND patient.patient_id = appointment.patient_id AND patient.user_id = user.user_id AND user.username = '$username'
			ORDER BY appointment.date ASC";

			$result = $conn->query($query);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $row["date"] . "</td>";
					if($row['pay'] == 0)
						echo "<td>" . "+" . $row["amount"] . "</td>";
					else
						echo "<td>" . "-" . $row["amount"] . "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='4'>No transactions found.</td></tr>";
			}
	
			$conn->close();
		
			?> 
		</tbody>
	</table>
</body>
</html>
<?php
?>

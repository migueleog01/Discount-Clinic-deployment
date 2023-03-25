<!DOCTYPE html>
<html>
<head>
	<title>Medical Clinic Transactions</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<h1>Medical Clinic Transactions</h1>
	<form>
		<fieldset>
			<legend>Patient Information</legend>
			<label for="patient_name">Name:</label>
			<input type="text" id="patient_name" name="patient_name" required><br>

			<label for="patient_email">Email:</label>
			<input type="email" id="patient_email" name="patient_email" required><br>

			<label for="patient_phone">Phone:</label>
			<input type="tel" id="patient_phone" name="patient_phone" required><br>
		</fieldset>

		<fieldset>
			<legend>Transaction Details</legend>
			<label for="transaction_date">Date:</label>
			<input type="date" id="transaction_date" name="transaction_date" required><br>

			<label for="transaction_type">Type:</label>
			<select id="transaction_type" name="transaction_type" required>
				<option value="">Select Transaction Type</option>
				<option value="consultation">Consultation</option>
				<option value="treatment">Treatment</option>
				<option value="test">Test</option>
			</select><br>

			<label for="transaction_amount">Amount:</label>
			<input type="number" id="transaction_amount" name="transaction_amount" required><br>
		</fieldset>

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
			<input type="number" id="payment_amount" name="payment_amount" required><br>
		</fieldset>

		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
	</form>
</body>
</html>

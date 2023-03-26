<!DOCTYPE html>
<html>
    <header>
        <div class="logo">
          <h1>Discount Clinic</h1>
        </div>
        <nav>
          <ul>
            <li><a href="patienthomepage.php">Home</a></li>
            <li><a href="appointments.html">Appointments</a></li>
            <li><a href="transactions.html">Transactions</a></li>
            <li><a href="profile.html">Profile</a></li>
          </ul>
        </nav>
      </header>
<head>
	<title>Appointment Making System</title>
	<link rel="stylesheet" href="patient_appointments_style.css">
</head>
<body>
	<div class="container">
		<h2>Appointment Form</h2>
		<form action="#" method="POST">
			

			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>

			<label for="phone">Phone:</label>
			<input type="text" id="phone" name="phone" required>

			<label for="date">Date:</label>
			<input type="date" id="date" name="date" required>

			<label for="time">Time:</label>
            <select id="time" name="time" required></select>

			

			<button type="submit" id="submitBtn">Submit</button>
		</form>
	</div>
    
	<script src="patient_appointments_script.js"></script>
</body>
</html>

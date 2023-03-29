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

			<label for="primary-physician">Primary Physician:</label>

			<label for="physician1"><input type="radio" id="physician1" name="primary-physician" value="302" required>Dr. Miguel</label>
			<!-- make an if statent, if doctor id is physician1, display adress 158 Easton Glen Ln and give it a value of 1011 -->
			


			<label for="physician2"><input type="radio" id="physician2" name="primary-physician" value="305" required>Dr. Doctor</label>

			<label for="physician3"><input type="radio" id="physician3" name="primary-physician" value="Dr. Bob Johnson" required>Dr. Bob Johnson</label>

			

			<button type="submit" value = "Submit" id="submitBtn">Submit</button>
		</form>
	</div>
    
	<script src="patient_appointments_script.js"></script>
</body>
</html>


<?php

	session_start();
	ob_start();

	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);

	$username = $user_data['username'];
	echo $username;

	$query = "SELECT user_id FROM user WHERE username = '$username'";
	$result = mysqli_query($conn, $query);

	if($result && mysqli_num_rows($result) > 0) {
		$user_data = mysqli_fetch_assoc($result);
		$user_id = $user_data['user_id'];
		//echo "User ID for $username: $user_id";
	} else {
		//echo "User not found";
	}
	//$user_id has the user id of the current user


	$query = "SELECT patient_id FROM patient WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $query);

	if($result && mysqli_num_rows($result) > 0) {
		$patient_data = mysqli_fetch_assoc($result);
		$patient_id = $patient_data['patient_id'];
		//echo  $patient_id;
	} else {
		//echo "Patient not found";
	}
	//patient_id has the patient id of the current user
   
	
	 //echo $_SESSION['user_id']; 
	

	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$date = $_POST['date'];
		$date = date('Y-m-d', strtotime($date));
		$time = $_POST['time'];
		$time = date('H:i', strtotime($time));
		$physician = $_POST['primary-physician'];
		//$email = $_POST['email'];
		//$phone = $_POST['phone'];\
		//echo $date;
		//echo $time;
		//echo $physician;
		//make an if statemtn if physician is 302 the adress id is 1010

		if($physician == 302){
			$address = 1010;
		}
		if($physician == 305){
			$address = 1011;
		}
		

		$servername = "discountclinic.mysql.database.azure.com";
        $username = "adminLogin";
        $password = "1234567c!";
        $dbname = "discount_clinic";
		
        // Create connection
        $conn = mysqli_init();
        mysqli_ssl_set($conn,NULL,NULL,"DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, MYSQLI_CLIENT_SSL);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
		//from our database if doctor specialty attrubute is is not primary, then set a variable 0 in php 
		
		$test = false;

		$sql_doctor = "SELECT * FROM doctor WHERE doctor_id = '$physician' AND specialty = 'primary'";
		//echo $sql_doctor;
		$result = mysqli_query($conn, $sql_doctor);
		if ($result && mysqli_num_rows($result) > 0) {
			// Specialty is primary for the given physician
			//$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id,deleted) VALUES (1 ,'$date', '$time', '$physician', '$address', '0')";
			echo "appointment deleted must be 0";
			$test = true;
			//echo "true";
		} else {
			//$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id) VALUES (1 ,'$date', '$time', '$physician', '$address')";
			// Specialty is not primary for the given physician
			echo "appointment deleted must be 1";
			$test = false;
		}
		//if true delete must be 0
		//if false delete must be 1
		//echo $_SESSION['username'];
		//echo $user_id;
		if($test === true ){
			echo "true";
			$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id,deleted) VALUES ('$patient_id','$date', '$time', '$physician', '$address', 0)";
			if (mysqli_query($conn, $sql)) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		else{
			//echo "YOU NEED APPROVAL FROM SPECIALIST";
			echo "<form action='approvalHasBeenSent.php' method='post'>";
    		echo "<input type='submit' value='Request Approval'>";
    		echo "</form>";
			
			//$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id,deleted) VALUES (1 ,'$date', '$time', '$physician', '$address',1)";
			
		}
		




		/*
		if( $sql_doctor != 0 )
		{
			$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id,deleted) VALUES (1 ,'$date', '$time', '$physician', '$address', '0')";
			if(mysqli_query($conn, $sql)){
				echo "Records added successfully.";
				exit(1);
			}
		}
		else{
			$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id) VALUES (1 ,'$date', '$time', '$physician', '$address')";

		}
		*/
		
		
		//echo $sql_doctor;


		
		

		// Close connection
		mysqli_close($conn);
		
		
		//$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id,deleted) VALUES (1 ,'$date', '$time', '$physician', '$address', '0')";
		
	
	
	
	}
		






	


?>

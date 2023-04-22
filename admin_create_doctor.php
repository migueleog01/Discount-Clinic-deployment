<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src = "script.js" defer></script>
	<title>Doctor Information Form</title>
    <header>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <h1><center>Create Doctor Form</center></h1>
        <nav>
            <ul>
                <li class ="active"><a href="adminhomepage.php">Home</a></li>
                <li><a href="admin_create_doctor.php">Create Doctor</a></li>
                <li><a href="admin_create_office.php">Create Office</a></li>
				<li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
	<style>
		label {
			display: block;
			margin-top: 10px;
		}
		input[type="text"], input[type="tel"], select {
			margin-top: 5px;
			padding: 5px;
			font-size: 16px;
			border-radius: 5px;
			border: none;
			border-bottom: 2px solid gray;
		}
		input[type="radio"] {
			margin-top: 5px;
			margin-right: 5px;
		}
		input[type="submit"] {
			margin-top: 20px;
			padding: 10px;
			font-size: 16px;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
	</style>
</head>
<body>

	<form method="post" action ="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required>

		<label for="firstname">First Name:</label>
		<input type="text" id="first-name" name="firstname" required>
		
		<label for="middle-initial">Middle Initial:</label>
		<input type="text" id="middle-initial" name="middle-initial">
		
		<label for="last_name">Last Name:</label>
		<input type="text" id="last-name" name="last_name" required>

        <label for="phone">Phone number:</label>
        <input type="text" id="phone_number" name="phone_number" placeholder="123-456-7890" pattern="\d{3}-\d{3}-\d{4}" required>
        <span id="phone-error"></span>
	
		<label for="gender">Gender:</label>
        <label for= "gender-male"><input type="radio" id="gender-male" name="gender" value="M" required >Male</label>
        <label for= "gender-female"><input type="radio" id="gender-female" name="gender" value="F" required >Female</label>
        <label for= "gender-other"><input type="radio" id="gender-other" name="gender" value="O" required >Other</label>
		
        <label for="date-input">Date of Birth:</label>
        <input type="text" id="date-input" name="date-input" placeholder="MM/DD/YYYY"  pattern="\d{2}/\d{2}/\d{4}" required>
        <p id="error-message"></p>
        
        <label for="address_id">Pick An Office For This Doctor:</label>
        <select id="address_id" name="address_id" required>
	    <option value=""></option>
	    	<?php 
                include("dbh-inc.php");
                include("functions.php");
            

	    		$office_address_query = "SELECT * 
				FROM discount_clinic.office, discount_clinic.address
				WHERE office.address_id = address.address_id";
				$office_address_result = mysqli_query($conn, $office_address_query);


				if(mysqli_num_rows($office_address_result) > 0) {
					while($row = mysqli_fetch_assoc($office_address_result)) {
						echo "<option value='" . $row["address_id"]."'>" . $row["street_address"] . " " . $row["city"]  . " " . $row["state"] . " " . $row["zip"];
					}
				}
	    	 ?>
	    </select>
        <label for="specialty">Specialty:</label>
        <input type ="text" id = "specialty" name="specialty" required>
        <button type="submit" value="Submit">Submit</button>
    <form>
<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $middleInitial = $_POST['middle-initial'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $gender = $_POST['gender'];
        $dob = $_POST['date-input'];
        $dob = date('Y-m-d', strtotime($dob));
        $address_id = $_POST['address_id'];
        $specialty = $_POST['specialty'];


        $checking_query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $result =  mysqli_query($conn, $checking_query);


        if($result && mysqli_num_rows($result) > 0){
           echo "Username already taken";
        }
        else{



        $sql_doctor_user = "INSERT INTO user (role, username, password) VALUES
        ('doctor','$username', '$password')";
        mysqli_query($conn, $sql_doctor_user);
        $new_user_id_sql = "SELECT user_ID FROM discount_clinic.user WHERE username = '$username'";
        $new_user_id_res = mysqli_query($conn, $new_user_id_sql);
        $new_user_id_row = mysqli_fetch_assoc($new_user_id_res);
        $new_user_id = $new_user_id_row['user_ID'];


        $sql_doctor = "INSERT INTO discount_clinic.doctor (user_id, first_name, middle_initial, last_name, phone_number, gender, DOB, specialty, deleted) VALUES 
        ($new_user_id, '$firstname', '$middleInitial', '$last_name',  '$phone_number', '$gender', '$dob', '$specialty', 0)";
        mysqli_query($conn, $sql_doctor);


        $new_doctor_id_sql = "SELECT doctor_id FROM discount_clinic.doctor, discount_clinic.user WHERE doctor.user_id = user.user_id AND username = '$username'";
        $new_doctor_id_res = mysqli_query($conn, $new_doctor_id_sql);
        $new_doctor_id_row = mysqli_fetch_assoc($new_doctor_id_res);
        $new_doctor_id = $new_doctor_id_row['doctor_id'];
        echo $new_doctor_id;
        
        
        $new_office_id_sql = "SELECT office_id FROM discount_clinic.office WHERE office.address_id = $address_id";
        $new_office_id_res = mysqli_query($conn, $new_office_id_sql);
        $new_office_id_row = mysqli_fetch_assoc($new_office_id_res);
        $new_office_id = $new_office_id_row['office_id'];
        echo $new_office_id;
        $sql_office = "INSERT INTO discount_clinic.doctor_office (DID, OID) VALUES
        ($new_doctor_id, $new_office_id)";
        mysqli_query($conn, $sql_office);


        }

        mysqli_close($conn);
    }
?>
</body>
</html>

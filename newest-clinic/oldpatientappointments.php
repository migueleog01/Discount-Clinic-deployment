
<?php
session_start();

include("dbh-inc.php");
include("functions.php");
/*
session_start();

include("dbh-inc.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $state = $_POST['state'];

  $sql = "SELECT office.office_id, address.street_address, address.city, address.zip FROM office, address WHERE office.address_id = address.address_id AND address.state = '$state'";
  $result = mysqli_query($conn, $sql);

  $offices = array();
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($offices, $row);
  }
  echo json_encode($offices);
}

mysqli_close($conn);
*/

/*
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$date = $_POST['date'];
		$date = date('Y-m-d', strtotime($date));
		$time = $_POST['time'];
		$time = date('H:i', strtotime($time));
		$state = $_POST['state'];

    $user_data = check_login($conn);

        	    $office_addresses = "SELECT address.street_address, address.city, address.state, address.zip FROM address,office WHERE office.address_id = address.address_id AND address.state = '$state'";
    						$r = mysqli_query($conn, $office_addresses);

						    if($r && mysqli_num_rows($r) > 0)
								{
									$address_data = mysqli_fetch_assoc($r);
									$street_address = $address_data['street_address'];
									$city = $address_data['city'];
									$st = $address_data['state'];
									$zip = $address_data['zip'];
									echo $street_address;
									echo ' ';
									echo $city;
									echo ' ';
									echo $st;
									echo ' ';
									echo $zip;
								}	
	}
	*/

		/*
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


		if($test === true ){
			echo "true";
			$sql = "INSERT INTO appointment (patient_id, date, time, doctor_id,office_id,deleted) VALUES (1 ,'$date', '$time', '$physician', '$address', 0)";
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
			
		}

		mysqli_close($conn);
		*/



?>




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

<script>
	function my_fun(str) {
		if(window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById('poll').innerHTML = this.responseText;
			}
		}
		xmlhttp.open("GET","helper.php?value="+str, true);
		xmlhttp.send();

	}
</script>

<body>

	<div class="container">
		<h2>Appointment Form</h2>
		<form action="#" method="POST">
			
			<!--
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>

			<label for="phone">Phone:</label>
			<input type="text" id="phone" name="phone" required> 
		-->


			<label for="date">Date:</label>
			<input type="date" id="date" name="date" required>

			<label for="time">Time:</label>
            <select id="time" name="time" required></select>
		


        <label for="state">Select a State:</label>
        <!--  <select id="state" name="state" required>  -->
				<select id="state" onchange="my_fun(this.value);">

            <option value=""></option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
        </select>
<!--
				<label for="office">Select an Office:</label>
				<select id="office" name="office" required>
				  <option value=""></option>
				</select>
-->
				<div id="poll">
				<!--	<label for="office">Select an Office:</label> -->
					<select>
						<option>Select location</option>
					</select>
				</div>


        <label for="zipcode">Zip Code:</label>
        <input type="text" id="zipcode" name="zipcode" placeholder="12345" pattern="[0-9]{5}" required>

			

			<button type="submit" value = "Submit" id="submitBtn">Submit</button>
		</form>
	</div>
    
	<script src="patient_appointments_script.js"></script>
</body>
</html>

<?php
	session_start();
	ob_start();
	include("dbh-inc.php");
	include("functions.php");

    $user_data = check_login($conn);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Change Primary Doctor</title>
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

<script src="patient_appointments_script.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
        document.getElementById('office').innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","helper.php?value="+str, true);
    xmlhttp.send();
  }


  
  function my_other_fun(str) {
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    }
    else{
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById('doctor').innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","2nd_helper.php?value="+str, true);
    xmlhttp.send();

  }
</script>

<body>
	<header>
		<h1>
			<center>Discount Clinic</center>
		</h1>
		<nav>
			<ul>
				<li class="active"><a href="#">Home</a></li>
				<li><a href="patient_profile.php">Profile</a></li>
				<li><a href="patientappointments.php">Schedule Appointment</a></li>
				<li><a href="transactions.php">Transactions</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
		
		<form action="#" method="POST">
     
        <label for="state">Select a State:</label>
				<select id="state" name="state" onchange="my_fun(this.value);">

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
        <br>
          <label for="office">Select an Office:</label>
					<select id="office" name="office" onchange="my_other_fun(this.value);">
						<option value="">Select location</option>
					</select>
          <br>
          <label for="doctor">Select a Doctor:</label>
          <select id="doctor" name="doctor" required>
            <option value="">Select doctor</option>
          </select>
          <div></div>
          <br>
			<button type="submit" value = "Submit" id="submitBtn">Submit</button>
		</form>

</body>
</html>

<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $office_id = $_POST['office'];
    $doctor_id = $_POST['doctor'];
    $username = $user_data['username'];

    $query = "SELECT user_id FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $user_id = $user_data['user_id'];
    } 

    $query = "SELECT patient_id FROM patient WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
    $patient_data = mysqli_fetch_assoc($result);
    $patient_id = $patient_data['patient_id'];

    $sql = "UPDATE discount_clinic.patient
    SET primary_doctor_id = $doctor_id
    WHERE patient.user_id = $user_id";
        if (mysqli_query($conn, $sql)) 
        {
            $appointment_status = "SELECT * FROM approval WHERE specialist_doctor_id = '$doctor_id' AND patient_id = '$patient_id' AND approval_bool=1";
            $result = mysqli_query($conn, $appointment_status);
            if ($result && mysqli_num_rows($result) > 0) 
            {
                echo "You have successfully changed your primary doctor!";
            } 
        }
    } 
} 
?>
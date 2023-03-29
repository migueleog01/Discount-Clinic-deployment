
<?php
session_start();

include("dbh-inc.php");
include("functions.php");
$user_data = check_login($conn);
//SELECT 
$sql = "SELECT * 
FROM discount_clinic.doctor_office, discount_clinic.office, discount_clinic.doctor, discount_clinic.address
WHERE office.office_id = doctor_office.OID AND doctor.doctor_id = doctor_office.DID AND address.address_id = office.address_id;";

$result = mysqli_query($conn, $sql);
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


<!-- <script>
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

</script> -->
<!-- $sql = "SELECT * 
FROM discount_clinic.doctor_office, discount_clinic.office, discount_clinic.doctor, discount_clinic.address
WHERE office.office_id = doctor_office.OID AND doctor.doctor_id = doctor_office.DID AND address.address_id = office.address_id;"; -->

<script src="patient_appointments_script.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  let rows = [];
  let row = [];
  <?php
    while ($row = mysqli_fetch_assoc($result)) {
      $address = $row["street_address"];
      $fname = $row["first_name"];
      $specialty = $row["specialty"];
  ?>
  row = ['<?php echo $address; ?>', '<?php echo $fname; ?>', '<?php echo $specialty; ?>'];
  rows.push(row);
  row = [];
  // rows.push(<?php echo $row;?>)
  <?php
    }
  ?>
  console.log(rows);
</script>


<body>

	<div class="container">
		<h2>Appointment Form</h2>
		<form action="#" method="POST">


			<label for="date">Date:</label>
			<input type="date" id="date" name="date" required>

			<label for="time">Time:</label>
            <select id="time" name="time" required>
            <option value=""></option>
		        </select>


        <label for="state">Select a State:</label>
        <!--  <select id="state" name="state" required>  -->

				<!-- <select id="state" name="state" onchange="my_fun(this.value);"> -->
        <!-- <select id="state" onchange="my_fun(this.value);"> -->

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
        <script>
          const stateSelect = document.getElementById('state');
          const stateValue = stateSelect.value;
        </script>
      -->
<!-- onchange="my_other_fun(this.value);" 

"SELECT * 
FROM discount_clinic.doctor_office, discount_clinic.office, discount_clinic.doctor, discount_clinic.address
WHERE office.office_id = doctor_office.OID AND doctor.doctor_id = doctor_office.DID AND address.address_id = office.address_id;""
-->

				<div id="poll">
          <select id="office"> 
				 <!-- 	<select id="office" onchange="my_other_fun(this.value);">  -->
          <!-- <select id="office" name="office" onchange="my_other_fun(this.value);"> -->
						<option value="">Select location</option>
					</select>
				</div>


        <div id="poll2">
          <select>
            <option value="">Select doctor</option>
          </select>
        </div>




        <label for="zipcode">Zip Code:</label>
        <input type="text" id="zipcode" name="zipcode" placeholder="12345" pattern="[0-9]{5}" required>

			

			<button type="submit" value = "Submit" id="submitBtn">Submit</button>
		</form>
	</div>
    
	<!--<script src="patient_appointments_script.js"></script>-->
</body>
</html>

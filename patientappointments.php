<?php
  ob_start();
  session_start();
?>
<!DOCTYPE html>
<html>
    <header>
		<h1>
		</h1>
		<nav>
			<ul>
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="patient_profile.php">Profile</a></li>
				<li><a href="patientappointments.php">Schedule Appointment</a></li>
				<li><a href="transactions.php">Transactions</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
<head>

  <title>Appointment Making System</title>
  <link rel="stylesheet" href="patient_appointments_style.css">
</head>

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
    //alert(str);
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
    //alert(str);
    xmlhttp.open("GET","other_helper.php?value="+str, true);
    xmlhttp.send();

  }

</script>

<body>




  <div class="container">
    <h2>Appointment Form</h2>
    <form action="" method="post" id="appointmentForm">


      <label for="date">Date:</label>
      <input type="date" id="date" name="date" required>

      <label for="time">Time:</label>
            <select id="time" name="time" required>
            <option value=""></option>
            </select>


        <label for="state">Select a State:</label>
        <select id="state" name="state" onchange="my_fun(this.value);">

            <option value=""></option>
            <option value="FL">Florida</option>
            <option value="CA">California</option>
            <option value="TX">Texas</option>
            <option value="NY">New York</option>
        </select>

          <label for="office">Select an Office:</label>
          <select id="office" name="office" onchange="my_other_fun(this.value);">
            <option value="">Select location</option>
          </select>

          <label for="doctor">Select a Doctor:</label>
          <select id="doctor" name="doctor" required>
            <option value="">Select doctor</option>
          </select>
  

      
      <button type="submit" value = "Submit" id="submitBtn">Submit</button>
      
    </form>
    <?php
  // ...
      ob_start();
      //session_start();

      include("dbh-inc.php");
      include("functions.php");

      $user_data = check_login($conn);
      
      $patient_query = "SELECT * 
      FROM discount_clinic.patient, discount_clinic.user
      WHERE patient.user_id = user.user_id AND patient.deleted = FALSE AND patient.user_id = '$user_data[user_ID]'";
      $patient_result = mysqli_query($conn, $patient_query);
      $patient_data = mysqli_fetch_assoc($patient_result);
      //echo $patient_data['primary_doctor_id'];
      //if this primary_doctor_id in doctor table has the boolean deleted marked as true then we need to print out must pick a new doctor

      $result = mysqli_query($conn, "SELECT * FROM doctor WHERE doctor_id = '$patient_data[primary_doctor_id]'");
      $doctor_data = mysqli_fetch_assoc($result);

  if ($doctor_data['deleted'] == 1) {
    echo "Must pick a new doctor, click on Profile in the navigation bar to do so.";
    echo "<script>
            var form = document.getElementById('appointmentForm');
            var inputs = form.getElementsByTagName('input');
            var selects = form.getElementsByTagName('select');
            var submitBtn = document.getElementById('submitBtn');
            
            for (var i = 0; i < inputs.length; i++) {
              inputs[i].setAttribute('disabled', 'disabled');
            }

            for (var i = 0; i < selects.length; i++) {
              selects[i].setAttribute('disabled', 'disabled');
            }

            submitBtn.setAttribute('disabled', 'disabled');
          </script>";
  } else {
    //echo "You are good to go";
  }
?>
  </div>
</body>
<?php
      ob_start();
      //session_start();

      //include("dbh-inc.php");
      //include("functions.php");

      //$user_data = check_login($conn);
      
      $patient_query = "SELECT * 
      FROM discount_clinic.patient, discount_clinic.user
      WHERE patient.user_id = user.user_id AND patient.deleted = FALSE AND patient.user_id = '$user_data[user_ID]'";
      $patient_result = mysqli_query($conn, $patient_query);
      $patient_data = mysqli_fetch_assoc($patient_result);
      //echo $patient_data['primary_doctor_id'];
      //if this primary_doctor_id in doctor table has the boolean deleted marked as true then we need to print out must pick a new doctor

      $result = mysqli_query($conn, "SELECT * FROM doctor WHERE doctor_id = '$patient_data[primary_doctor_id]'");
      $doctor_data = mysqli_fetch_assoc($result);
      //echo $doctor_data['deleted']; 
      /*
      if($doctor_data['deleted'] == 1){
        //echo "Must pick a new doctor";
      }
      else{
        echo "You are good to go";
      }
      */

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              //echo "hello";
              $date = $_POST['date'];
              $date = date('Y-m-d', strtotime($date));
              $time = $_POST['time'];
              $time = date('H:i', strtotime($time));
              $office_id = $_POST['office'];
              $doctor_id = $_POST['doctor'];

          $username = $user_data['username'];

        $query = "SELECT user_id FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if($result && mysqli_num_rows($result) > 0) {
          $user_data = mysqli_fetch_assoc($result);
          $user_id = $user_data['user_id'];
        } else {
        }

        $query = "SELECT patient_id FROM patient WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if($result && mysqli_num_rows($result) > 0) {
          $patient_data = mysqli_fetch_assoc($result);
          $patient_id = $patient_data['patient_id'];
          
          $sql = "INSERT INTO appointment (patient_id, doctor_id, office_id, time, date, deleted) VALUES ('$patient_id','$doctor_id','$office_id','$time','$date', 0)";
                  try
                  {
                    mysqli_query($conn, $sql);
                        $appointment_status = "SELECT * FROM approval WHERE specialist_doctor_id = '$doctor_id' AND patient_id = '$patient_id' AND approval_bool=1";
                        //echo $sql_doctor;
                        $result = mysqli_query($conn, $appointment_status);
                        if ($result && mysqli_num_rows($result) > 0) 
                        {
                          echo "Thank you for scheduling your appointment!";
                        } 
                        else 
                        {
                              $sql_specialist = "SELECT * FROM doctor WHERE doctor_id = '$doctor_id' AND specialty <> 'primary'";
                              $res = mysqli_query($conn, $sql_specialist);
                              if ($res && mysqli_num_rows($res) > 0) 
                              {
                                echo "You need approval from a GP.";
                              }
                              
                              else 
                              {
                                echo "Thank you for scheduling your appointment!";
                              }

                        }
                  }
                  catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                  }


        } 
        else {
          echo "Patient not found";
        }
      } 
      mysqli_close($conn);
      ob_end_flush();

      ?>
      
</html>

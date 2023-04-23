<?php
ob_start();
session_start();

include("dbh-inc.php");
include("functions.php");

$user_data = check_login($conn);
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
  <main>
    <h2>
    
      <center>Welcome <?php  echo "Patient" ?>, <?php echo $user_data['username']; ?></center>
    </h2>
    <h4>About Us</h4>
    <p>Our clinic provides high-quality medical services to patients of all ages at a minimal cost. We have a team of experienced doctors who are dedicated to your health and well-being. Book an appointment at your convenience at one of our various offices across the nation. </p>
    <div class="services">
      <h3>Our Services</h3>
      <p>General Medicine</p>
      <p>Pediatrics</p>
      <p>Cardiology</p>
      <p>Dermatology</p>
    </div>

</html>
<form method="POST" action="patienthomepage.php">
  <label for="start_date">Start Date:</label>
  <input type="date" name="start_date" required>
  <label for="end_date">End Date:</label>
  <input type="date" name="end_date" required>
  <button type="submit" name="submit_dates">Filter</button>
</form>



<h3> Upcoming Appointments</h3>
<table>
  <thead>
    <tr>
      <th>Appointment ID</th>
      <th>Doctor Name</th>
      <th>Date</th>
      <th>Time</th>
      <th> Office Location</th>
      <th>Status</th>
      <th> Cancel Appointment</th>
    </tr>
  </thead>
  <tbody>
  <?php

$TEST = $user_data['username'];
$query = "SELECT user_id FROM user WHERE username = '$TEST'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
  $user_data = mysqli_fetch_assoc($result);
  $user_id = $user_data['user_id'];
}

$query = "SELECT patient_id FROM patient WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $patient_data = mysqli_fetch_assoc($result);
  $patient_id = $patient_data['patient_id'];
}

$start_date = date("Y-m-d", strtotime("-1 month"));
$end_date = date("Y-m-d", strtotime("+1 month"));

if (isset($_POST['submit_dates'])) {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
}

// Modify SQL query to fetch appointments within the specified date range and include approval_bool
$sql = "SELECT appointment.*, office.*, address.*, doctor.*, approval.approval_bool AS approval_status
        FROM discount_clinic.appointment
        JOIN discount_clinic.office ON appointment.office_id = office.office_id
        JOIN discount_clinic.address ON office.address_id = address.address_id
        JOIN discount_clinic.doctor ON appointment.doctor_id = doctor.doctor_id
        LEFT JOIN discount_clinic.approval AS approval ON appointment.patient_id = approval.patient_id
        WHERE appointment.patient_id = '$patient_id' AND appointment.cancelled = FALSE
        AND date >= '$start_date' AND date <= '$end_date'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['appointment_id'] . "</td>";
    echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['time'] . "</td>";
    echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
    
    $approval_status = $row['approval_status'];
    if ($row['specialty'] <> 'primary') {
      if ($approval_status == 0) {
        echo '<td>' . "awaiting approval" . '</td>';
      } else {
        echo '<td>' . "approved" . '</td>';
      }
    } else {
      echo '<td>' . "approved" . '</td>';
    }

    echo "<td>";
    echo "<form method='POST' action='patienthomepage.php'>";
    echo "<input type='hidden' name='appointment_id' value='" . $row['appointment_id'] . "'>";
    if (isset($_POST['cancel']) && $_POST['appointment_id'] == $row['appointment_id']) {
      $appointment_id = $_POST['appointment_id'];
      $query = "UPDATE appointment SET cancelled = TRUE WHERE appointment_id = '$appointment_id'";
      mysqli_query($conn, $query);
      header("Refresh:0;");
    } else {
      echo "<button type='submit' name='cancel'>Cancel</button>";
    }
    echo "</form>";
    echo "</td>";

    echo "</tr>";
  }
} else {
      echo "<tr><td colspan='6'>No appointments found.</td></tr>";
    }

    $conn->close();
    ?>
  </tbody>
</table>
</body>
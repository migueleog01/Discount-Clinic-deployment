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
        <h1><center>Discount Clinic</center></h1>
        <nav>
            <ul>
                <li class ="active"><a href="adminhomepage.php">Home</a></li>
                <li><a href="admin_create_doctor.php">Create Doctor</a></li>
                <li><a href="admin_create_office.php">Create Office</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
</body>
<h2><center>Hello, <?php session_start();
    include("dbh-inc.php");
    include("functions.php");
    $user_data = check_login($conn); 
    echo $user_data['username']; ?> 
</center></h2>
<body>
    <form method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
        <h3>Pick an office to view the report</h3>
        <label for="address_id">Office:</label>
        <select id="address_id" name="address_id" required>
        <option value=""></option>
            <?php 
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
        <input type="submit" value="Submit">
    <form >
</body>
<h3>Appointments at this office</h3>
<body>
    <table>
        <thead>
            <tr>
              <th>Appointment ID</th>
              <th>Patient Name</th>
              <th>Date</th>
              <th>Time</th>
              <th>Appointment Location</th>
            </tr>
        </thead>
        <tbody> 
    <?php
    ob_start();

    if(isset($_POST['address_id'])){
    $address_id = $_POST['address_id'];


    $appointment_query = "SELECT *
    FROM discount_clinic.office, discount_clinic.address, discount_clinic.appointment, discount_clinic.patient
    WHERE office.address_id = address.address_id AND patient.patient_id = appointment.patient_id AND address.address_id = '$address_id'";
    $address_result =$conn->query($appointment_query);
    
    if ($address_result->num_rows > 0) {
            while ($row = $address_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['appointment_id'] . "</td>";
                echo "<td>" . $row['first_name'] . " " . $row['last_name'] ."</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No appointments found.</td></tr>";
        }
}

        
    ?>
        </tbody>
    </table>
    <h3>Patients at this office</h3>
    <table>
        <thead>
            <tr>
              <th>Patient ID</th>
              <th>Patient Name</th>
              <th>Birthday</th>
              <th>Gender</th>
              <th>Phone Number</th>
              <th>Emergency Contact Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $patient_query = "SELECT street_address, city, state, zip, patient.patient_id, first_name, middle_initial, last_name, gender, patient.phone_number AS patient_phone_number, DOB, emergency_contact.phone_number AS e_phone_number
                    FROM discount_clinic.office, discount_clinic.address, discount_clinic.patient, discount_clinic.emergency_contact
                    WHERE office.address_id = address.address_id AND emergency_contact.patient_id = patient.patient_id AND address.address_id = '$address_id'";
                $patient_result = $conn->query($patient_query);

                if ($patient_result->num_rows > 0) {
                        while ($row = $patient_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['patient_id'] . "</td>";
                            echo "<td>" . $row['first_name'] . " " . $row['middle_initial'] . " " . $row['last_name'] ."</td>";
                            echo "<td>" . $row['DOB'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['patient_phone_number'] . "</td>";
                            echo "<td>" . $row['e_phone_number'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No appointments found.</td></tr>";
                    }
                    
            ?>
        </tbody>
    </table>

    <h3>Doctors at this Office</h3>
    <table>
        <thead>
            <tr>
              <th>Doctor ID</th>
              <th>Doctor Name</th>
              <th>Specialty</th>
              <th>Birthday</th>
              <th>Gender</th>
              <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $doctor_query = "SELECT *
                FROM discount_clinic.office, discount_clinic.address, discount_clinic.doctor
                WHERE office.address_id = address.address_id AND address.address_id = '$address_id'";
                $doctor_result = $conn->query($doctor_query);

                if($doctor_result->num_rows > 0) {
                    while ($row = $doctor_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['doctor_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . " " . $row['middle_initial'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['specialty'] . "</td>";
                        echo "<td>" . $row['DOB'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['phone_number'] . "</td>";
                    }
                }
                $conn->close();
             ?>
        </tbody>
    </table>
</body>
</html>


<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $address_id = $_POST['address_id'];
        $address_query = "SELECT *
        FROM discount_clinic.office, discount_clinic.address
        WHERE office.address_id = address.address_id AND address.address_id = '$address_id'";
        $address_result =$conn->query($address_query);
    }
    
    echo $result->num_rows;
?>
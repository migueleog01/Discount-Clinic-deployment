<?php
ob_start();
session_start();
include("dbh-inc.php");
include("functions.php");
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
                <li class="active"><a href="adminhomepage.php">Home</a></li>
                <li><a href="admin_create_doctor.php">Create Doctor</a></li>
                <li><a href="admin_create_office.php">Create Office</a></li>
                <li><a href="admin_delete_patient.php">Delete Patient</a></li>
                <li><a href="admin_delete_doctor.php">Delete Doctor</a></li>
                <li><a href="admin_delete_office.php">Delete Office</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
</body>
<h2>
    <center>Hello, <?php
                    $user_data = check_login($conn);
                    echo $user_data['username']; ?>
    </center>
</h2>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h3>Pick an office to view the report</h3>
        <label for="address_id">Office:</label>
        <select id="address_id" name="office_id" required>
            <option value=""></option>
            <?php
            // ... (Your existing PHP code to fetch office addresses)
            $office_address_query = "SELECT * 
                FROM discount_clinic.office, discount_clinic.address
                WHERE office.address_id = address.address_id";
            $office_address_result = mysqli_query($conn, $office_address_query);


            if (mysqli_num_rows($office_address_result) > 0) {
                while ($row = mysqli_fetch_assoc($office_address_result)) {
                    echo "<option value='" . $row["office_id"] . "'>" . $row["street_address"] . " " . $row["city"]  . " " . $row["state"] . " " . $row["zip"];
                }
            }
            ?>
        </select>
        <label for="report_type">Report Type:</label>
        <select id="report_type" name="report_type" required>
            <option value=""></option>
            <option value="appointments">Appointments</option>
            <option value="patients">Patients</option>
            <option value="doctors">Doctors</option>
        </select>
        <div id="date-range" style="display: none;">
            <h4>Filter appointments by date range:</h4>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $current_date; ?>">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
        </div>

        <label for="gender" id="gender-label" style="display: none;">Gender:</label>
        <select id="gender" name="gender" style="display: none;" required>
            <option value="all">All</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
            <option value="O">Other</option>
        </select>


        <div id="age-range" style="display: none;">
            <h4>Filter patients by age range:</h4>
            <label for="min_age">Minimum Age:</label>
            <input type="number" id="min_age" name="min_age" min="0" max="150" step="1">
            <label for="max_age">Maximum Age:</label>
            <input type="number" id="max_age" name="max_age" min="0" max="150" step="1">
        </div>


        <label for="doctor_type" id="doctor-type-label" style="display: none;">Doctor Type:</label>
        <select id="doctor_type" name="doctor_type" style="display: none;" required>
            <option value="all">All</option>
            <option value="primary">Primary</option>
            <option value="specialist">Specialist</option>
        </select>

        <input type="submit" value="Submit">
    </form>
    <script>
        document.getElementById("report_type").addEventListener("change", function() {
            if (this.value === "appointments") {
                document.getElementById("date-range").style.display = "block";
                document.getElementById("gender-label").style.display = "none";
                document.getElementById("gender").style.display = "none";
                document.getElementById("doctor-type-label").style.display = "none";
                document.getElementById("doctor_type").style.display = "none";
                document.getElementById("age-range").style.display = "none"; // Add this line

            } else if (this.value === "patients") { // Change this line
                document.getElementById("date-range").style.display = "none";
                document.getElementById("gender-label").style.display = "inline";
                document.getElementById("gender").style.display = "inline";
                document.getElementById("doctor-type-label").style.display = "none";
                document.getElementById("doctor_type").style.display = "none";
                document.getElementById("age-range").style.display = "block"; // Add this line
            } else {
                document.getElementById("date-range").style.display = "none";
                document.getElementById("gender-label").style.display = "none";
                document.getElementById("gender").style.display = "none";
                document.getElementById("doctor-type-label").style.display = "inline";
                document.getElementById("doctor_type").style.display = "inline";
                document.getElementById("age-range").style.display = "none"; // Add this line
            }
        });
    </script>
</body>

</html>

<?php


if (isset($_POST['report_type'])) {
    $report_type = $_POST['report_type'];
    if ($report_type === 'appointments') {
        $office_id = $_POST['office_id'];

        if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
            $start_date = isset($_POST['start_date']) && !empty($_POST['start_date']) ? $_POST['start_date'] : '1900-01-01';
            $end_date = isset($_POST['end_date']) && !empty($_POST['end_date']) ? $_POST['end_date'] : '9999-12-31';
        } else {
            $start_date = $current_date;
            $end_date = $end_date;
        }

        $appointment_query = "SELECT DISTINCT appointment.*, patient.first_name AS patient_first_name, patient.last_name AS patient_last_name, doctor.first_name AS doctor_first_name, doctor.last_name AS doctor_last_name, address.*
                              FROM discount_clinic.office, discount_clinic.address, discount_clinic.appointment, discount_clinic.patient, discount_clinic.doctor
                              WHERE appointment.office_id = office.office_id
                              AND appointment.patient_id = patient.patient_id
                              AND appointment.doctor_id = doctor.doctor_id
                              AND office.office_id = '$office_id'
                              AND office.address_id = address.address_id
                              AND date >= '$start_date' AND date <= '$end_date'
                              ORDER BY date, time";
        $address_result = $conn->query($appointment_query);

        echo "<table>";
        echo '<thead>';
        echo "<tr>";
        echo "<th>Appointment ID</th>";
        echo "<th>Doctor Name</th>";
        echo "<th>Patient Name</th>"; // Added Doctor Name header
        echo "<th>Appointment Date</th>";
        echo "<th>Appointment Time</th>";
        echo "<th>Office Address</th>";
        echo "</tr>";
        echo '</thead>';
        echo '<tbody>';

        if ($address_result->num_rows > 0) {
            while ($row = $address_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['appointment_id'] . "</td>";
                echo "<td>" . $row['doctor_first_name'] . " " . $row['doctor_last_name'] . "</td>"; // Added Doctor Name to the table
                echo "<td>" . $row['patient_first_name'] . " " . $row['patient_last_name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No appointments found.</td></tr>"; // Updated colspan to 6
        }
    }

    //else {
    //echo "<tr><td colspan='5'>No appointments found.</td></tr>";
    //}

    // ... (Your existing PHP code to display the appointments table)
    else if ($report_type === 'patients') {
        $office_id = $_POST['office_id'];
        $gender = $_POST['gender'];
    
        $min_age = isset($_POST['min_age']) && !empty($_POST['min_age']) ? $_POST['min_age'] : null;
        $max_age = isset($_POST['max_age']) && !empty($_POST['max_age']) ? $_POST['max_age'] : null;
    
        $patient_query = "SELECT DISTINCT
                address.street_address,
                address.city,
                address.state,
                address.zip,
                patient.patient_id,
                patient.first_name,
                patient.middle_initial,
                patient.last_name,
                patient.gender,
                patient.phone_number AS patient_phone_number,
                patient.DOB,
                emergency_contact.e_first_name,  -- Include the e_first_name column here
                emergency_contact.phone_number AS e_phone_number
              FROM
                discount_clinic.patient
                INNER JOIN discount_clinic.address ON patient.address_id = address.address_id
                INNER JOIN discount_clinic.emergency_contact ON emergency_contact.patient_id = patient.patient_id
                INNER JOIN discount_clinic.appointment ON appointment.patient_id = patient.patient_id
              WHERE
                appointment.office_id = '$office_id'";


    
        if ($gender !== 'all') {
            $patient_query .= " AND patient.gender = '$gender'";
        }
    
        if ($min_age !== null) {
            $patient_query .= " AND TIMESTAMPDIFF(YEAR, patient.DOB, CURDATE()) >= $min_age";
        }
    
        if ($max_age !== null) {
            $patient_query .= " AND TIMESTAMPDIFF(YEAR, patient.DOB, CURDATE()) <= $max_age";
        }
    
        $patient_result = $conn->query($patient_query);
        
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Patient ID</th>';
        echo '<th>Name</th>';
        echo '<th>Address</th>';
        echo '<th>DOB</th>';
        echo '<th>Gender</th>';
        echo '<th>Phone</th>';
        echo '<th>Emergency First Name</th>';
        echo '<th>Emergency Phone</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        if ($patient_result->num_rows > 0) {
            while ($row = $patient_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['patient_id'] . "</td>";
                echo "<td>" . $row['first_name'] . " " . $row['middle_initial'] . " " . $row['last_name'] . "</td>";
                echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
                echo "<td>" . $row['DOB'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['patient_phone_number'] . "</td>";
                echo "<td>" . $row['e_first_name'] . "</td>";
                echo "<td>" . $row['e_phone_number'] . "</td>";
                echo "</tr>";
            }
        }


        echo '</tbody>';
        echo '</table>';
        // ... (Your existing PHP code to display the patients table)

    } else if ($report_type === 'doctors') {
        // ... (Your existing PHP code to display the doctors table)
        $office_id = $_POST['office_id'];
        $doctor_type = $_POST['doctor_type'];

        // Update the doctor query based on the selected doctor type
        $doctor_type_condition = "";
        if ($doctor_type === 'primary') {
            $doctor_type_condition = "AND doctor.specialty = 'Primary'";
        } elseif ($doctor_type === 'specialist') {
            $doctor_type_condition = "AND doctor.specialty != 'Primary'";
        }
        /*
        $doctor_query = "SELECT DISTINCT doctor_id, doctor.first_name AS first_name, doctor.middle_initial AS middle_initial, doctor.last_name AS last_name, specialty, doctor.DOB AS DOB, doctor.gender AS gender, doctor.phone_number AS phone_number
                        FROM discount_clinic.office, discount_clinic.address, discount_clinic.doctor, discount_clinic.doctor_office WHERE doctor.doctor_id=doctor_office.DID AND office.office_id=doctor_office.OID AND office.office_id = '$office_id' AND office.address_id = address.address_id $doctor_type_condition";
        */
        /*
        $doctor_query = "SELECT DISTINCT doctor.doctor_id, doctor.first_name AS first_name, doctor.middle_initial AS middle_initial, doctor.last_name AS last_name, specialty, doctor.DOB AS DOB, doctor.gender AS gender, doctor.phone_number AS phone_number, appointment_count.count AS appointment_count
        FROM discount_clinic.office, discount_clinic.address, discount_clinic.doctor, discount_clinic.doctor_office,
            (SELECT count(*) AS count, appointment.doctor_id
            FROM discount_clinic.doctor, discount_clinic.appointment
            WHERE doctor.doctor_id = appointment.doctor_id AND appointment.deleted = 0 AND appointment.cancelled = 0
            GROUP BY appointment.doctor_id) AS appointment_count
        WHERE doctor.doctor_id=doctor_office.DID AND office.office_id=doctor_office.OID AND office.office_id = '$office_id' AND office.address_id = address.address_id $doctor_type_condition AND doctor.doctor_id = appointment_count.doctor_id";
                $doctor_result = $conn->query($doctor_query);
        */        
        /*
        $doctor_query = "SELECT doctor.doctor_id, doctor.first_name AS first_name, doctor.middle_initial AS middle_initial, doctor.last_name AS last_name, doctor.specialty, doctor.DOB AS DOB, doctor.gender AS gender, doctor.phone_number AS phone_number, COUNT(appointment.appointment_id) AS appointment_count
                     FROM discount_clinic.doctor
                     LEFT JOIN discount_clinic.appointment ON doctor.doctor_id = appointment.doctor_id AND appointment.deleted = 0 AND appointment.cancelled = 0
                     JOIN discount_clinic.doctor_office ON doctor.doctor_id = doctor_office.DID
                     JOIN discount_clinic.office ON office.office_id = doctor_office.OID
                     WHERE office.office_id = '$office_id' $doctor_type_condition
                     GROUP BY doctor.doctor_id
                     ORDER BY doctor.last_name, doctor.first_name";
                     */
                    $doctor_query = "SELECT doctor.doctor_id, doctor.first_name AS first_name, doctor.middle_initial AS middle_initial, doctor.last_name AS last_name, doctor.specialty, doctor.DOB AS DOB, doctor.gender AS gender, doctor.phone_number AS phone_number, COUNT(appointment.appointment_id) AS appointment_count
                 FROM discount_clinic.doctor
                 LEFT JOIN discount_clinic.appointment ON doctor.doctor_id = appointment.doctor_id AND appointment.deleted = 0 AND appointment.cancelled = 0
                 JOIN discount_clinic.doctor_office ON doctor.doctor_id = doctor_office.DID
                 JOIN discount_clinic.office ON office.office_id = doctor_office.OID
                 WHERE office.office_id = '$office_id' $doctor_type_condition AND doctor.deleted = 0
                 GROUP BY doctor.doctor_id
                 ORDER BY doctor.last_name, doctor.first_name";

        $doctor_result = $conn->query($doctor_query);
        

        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Doctor ID</th>';
        echo '<th>Name</th>';
        echo '<th>Specialty</th>';
        echo '<th>DOB</th>';
        echo '<th>Gender</th>';
        echo '<th>Phone</th>';
        echo '<th>Office Address</th>';
        echo '<th>Appointments</th>'; // Added new column header for appointments

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        if ($doctor_result->num_rows > 0) {
            while ($row = $doctor_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['doctor_id'] . "</td>";
                echo "<td>" . $row['first_name'] . " " . $row['middle_initial'] . " " . $row['last_name'] . "</td>";
                echo "<td>" . $row['specialty'] . "</td>";
                echo "<td>" . $row['DOB'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                //display office address
                $office_query = "SELECT address.street_address, address.city, address.state, address.zip
                                FROM discount_clinic.office, discount_clinic.address
                                WHERE office.office_id = '$office_id' AND office.address_id = address.address_id";
                $office_result = $conn->query($office_query);
                if ($office_result->num_rows > 0) {
                    while ($row2 = $office_result->fetch_assoc()) {
                        echo "<td>" . $row2['street_address'] . " " . $row2['city'] . " " . $row2['state'] . " " . $row2['zip'] . "</td>";
                    }
                }

                echo "<td>" . $row['appointment_count'] . "</td>"; // Added new column value for appointment count


            }
        } else {
            echo "<tr><td colspan='6'>No doctors found.</td></tr>";
        }
    }
}










?>

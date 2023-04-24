<?php
    ob_start();
    session_start();
    include("dbh-inc.php");
	include("functions.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Delete Patient</title>
    <header>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <h1><center>Delete Patient</center></h1>
        <nav>
            <ul>
                <li class ="active"><a href="adminhomepage.php">Home</a></li>
                <li><a href="admin_create_doctor.php">Create Doctor</a></li>
                <li><a href="admin_create_office.php">Create Office</a></li>
                <li><a href="admin_delete_patient.php">Delete Patient</a></li>
                <li><a href="admin_delete_doctor.php">Delete Doctor</a></li>
                <li><a href="admin_delete_office.php">Delete Office</a></li>
				<li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
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
</head>

<body>
<html>
    <table>
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Date of Birth</th>
                <th>Total Owe</th>
                <th>Delete Patient</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $doctor_query = "SELECT * FROM discount_clinic.patient WHERE deleted = FALSE";
                $doctor_result = $conn->query($doctor_query);
                if($doctor_result->num_rows > 0) {
                    while($row = $doctor_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['patient_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['middle_initial'] . "</td>"; 
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['phone_number'] . "</td>";
                        echo "<td>" . $row['DOB'] . "</td>";
                        echo "<td>" . $row['total_owe'] . "</td>";
                        echo "<td>";

                        echo "<form method='POST' action= 'admin_delete_patient.php'>";
                        echo "<input type='hidden' name='patient_id' value='" . $row['patient_id'] . "'>";


                        if (isset($_POST['delete'])) {
                            
                            $patient_id = $_POST['patient_id'];
                            
                            // Retrieve user_id from patient id
                            $user_id_query = "SELECT user_id FROM discount_clinic.patient WHERE patient_id = $patient_id";
                            $user_id_result = mysqli_query($conn, $user_id_query);
                            $user_id_row = mysqli_fetch_assoc($user_id_result);
                            $user_id = $user_id_row['user_id'];


                            // Delete patient from patient table
                            $delete_patient = "UPDATE discount_clinic.patient SET deleted = TRUE WHERE patient_id = $patient_id";
                            mysqli_query($conn, $delete_patient);

                            // Delete appointments connected to the patient
                            $delete_appointment = "UPDATE discount_clinic.appointment SET deleted = TRUE WHERE patient_id = $patient_id";
                            mysqli_query($conn, $delete_appointment);

                            // Delete emergency contact connected to the patient
                            $delete_emergency_contact = "UPDATE discount_clinic.emergency_contact SET deleted = TRUE WHERE patient_id = $patient_id";
                            mysqli_query($conn, $delete_emergency_contact);

                            // Delete user connected to patient
                            $delete_user = "UPDATE discount_clinic.user SET deleted = TRUE WHERE user_id = $user_id";
                            mysqli_query($conn, $delete_user);
                            header("Refresh:0");

                            
                            header("admin_delete_patient.php");
                            echo "<button type='submit' name='delete'>Delete</button>";
                        } else {
                            echo "<button type='submit' name='delete'>Delete</button>";
                        }
                        echo "</form>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>
</html>

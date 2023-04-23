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
        <h1><center>Delete Doctor</center></h1>
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
                <th>Doctor ID</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Last Name</th>
                <th>Specialty</th>
                <th>Delete Doctor</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $doctor_query = "SELECT * FROM discount_clinic.doctor WHERE deleted = FALSE";
                $doctor_result = $conn->query($doctor_query);
                if($doctor_result->num_rows > 0) {
                    while($row = $doctor_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['doctor_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['middle_initial'] . "</td>"; 
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['specialty'] . "</td>";
                        echo "<td>";

                        echo "<form method='POST' action= 'admin_delete_doctor.php'>";
                        echo "<input type='hidden' name='doctor_id' value='" . $row['doctor_id'] . "'>";


                        if (isset($_POST['delete'])) {
                            // Delete doctor from doctor table
                            $doctor_id = $_POST['doctor_id'];
                            $delete_doctor = "UPDATE discount_clinic.doctor SET deleted = TRUE WHERE doctor_id = $doctor_id";
                            mysqli_query($conn, $delete_doctor);


                            // Delete doctor from user table
                            $result = "SELECT user_id FROM discount_clinic.doctor WHERE doctor_id = $doctor_id";
                            $doctor_user_id = mysqli_query($conn, $result);
                            $user_id = mysqli_fetch_assoc($doctor_user_id);
                            $doctor_user_id = $user_id['user_id'];
                            $delete_user = "UPDATE discount_clinic.user SET deleted = TRUE WHERE user_id = $doctor_user_id";
                            mysqli_query($conn, $delete_user);


                            // Delete all appointments with doctor
                            $delete_appointments = "UPDATE discount_clinic.appointment SET deleted = TRUE WHERE doctor_id = $doctor_id";
                            mysqli_query($conn, $delete_appointments);


                            header("admin_delete_doctor.php");
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
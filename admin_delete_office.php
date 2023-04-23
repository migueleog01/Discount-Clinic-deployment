<?php
    ob_start();
    session_start();
    include("dbh-inc.php");
	include("functions.php");
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Delete Office</title>
    <header>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <h1><center>Delete Office</center></h1>
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
                <th>Office ID</th>
                <th>Street Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Delete Office</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $office_query = "SELECT * FROM discount_clinic.office, discount_clinic.address WHERE office.address_id = address.address_id AND office.deleted = FALSE;";
                $office_result = $conn->query($office_query);

                if($office_result->num_rows > 0) {
                    while($row = $office_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['office_id'] . "</td>";
                        echo "<td>" . $row['street_address'] . "</td>";
                        echo "<td>" . $row['city'] . "</td>"; 
                        echo "<td>" . $row['state'] . "</td>";
                        echo "<td>" . $row['zip'] . "</td>";
                        echo "<td>";

                        echo "<form method='POST' action= 'admin_delete_office.php'>";
                        echo "<input type='hidden' name='office_id' value='" . $row['office_id'] . "'>";


                        if (isset($_POST['delete'])) {
                            $office_id = $_POST['office_id'];
                            $delete_office = "UPDATE discount_clinic.office SET deleted = TRUE WHERE office_id = $office_id";
                            mysqli_query($conn, $delete_office);


                            header("admin_delete_office.php");
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
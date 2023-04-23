<?php
    ob_start();
    session_start();
    include("dbh-inc.php");
    include("functions.php");
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Delete Account</title>
    <nav>
        <h1>
			<center>Delete Account</center>
		</h1>
        <ul>
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="patient_profile.php">Profile</a></li>
            <li><a href="patientappointments.php">Schedule Appointment</a></li>
            <li><a href="transactions.php">Transactions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
	</nav>
</head>
<body>
    <?php
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
	?>
   <h2>Are you sure you want to delete your account?</h2>
   <form method="post" action="" onsubmit="window.location.reload()">
   <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="submit" name="Yes" value="Yes">
    <input type="submit" name="No" value="No">
</body>

<?php 
    ob_start();
    include("dbh-inc.php");
    $user_data = check_login($conn);
    $user_id = $user_data['user_ID'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Yes'])) {

            //get patient id using user id
            $sql = "SELECT patient_id FROM patient WHERE user_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $patient_id = $row['patient_id'];


            // deleting appointments
            $sql = "UPDATE appointment SET deleted = 1  WHERE patient_id = '$patient_id'";
            mysqli_query($conn, $sql);

            // deleting address
            $sql = "SELECT address_id FROM patient WHERE patient_id = '$patient_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $address_id = $row['address_id'];
            $sql = "UPDATE address SET deleted = 1  WHERE address_id = '$address_id'";
            mysqli_query($conn, $sql);

            // deleting emergency contact
            $sql = "UPDATE emergency_contact SET deleted = 1  WHERE patient_id = '$patient_id'";
            mysqli_query($conn, $sql);

            // deleting patient
            $sql = "UPDATE patient SET deleted = 1  WHERE patient_id = '$patient_id'";
            mysqli_query($conn, $sql);

            // deleting user
            $sql = "UPDATE user SET deleted = 1  WHERE user_id = '$user_id'";
            mysqli_query($conn, $sql);


            header("Location: login.php");
        } else if (isset($_POST['No'])) {
            header("Location: patienthomepage.php");
        }
    }
?>
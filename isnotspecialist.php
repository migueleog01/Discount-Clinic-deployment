<?php 
ob_start();
session_start();

	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);

	$username = $user_data['username'];
	$query = "SELECT user_id FROM user WHERE username = '$username'";
	$result = mysqli_query($conn, $query);
	if($result && mysqli_num_rows($result) > 0) {
		$user_data = mysqli_fetch_assoc($result);
		$user_id = $user_data['user_id'];
	} 

	$query = "SELECT doctor_id FROM doctor WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $query);

	if($result && mysqli_num_rows($result) > 0) {
		$doctor_data = mysqli_fetch_assoc($result);
		$doctor_id = $doctor_data['doctor_id'];
	}

	$other_query = "SELECT specialty FROM doctor WHERE doctor_id = '$doctor_id'";
	$res = $conn->query($other_query);


	if($res && mysqli_num_rows($res) > 0) {
		$specialty_data = mysqli_fetch_assoc($res);
		$specialty = $specialty_data['specialty'];
			if($specialty==='primary'){	
				echo "<li><a href='approval.php'>Approvals</a></li>";
			}
	}
?>

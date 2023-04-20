<?php 
session_start();
ob_start();

	// include("connection.php");
	include("dbh-inc.php");
	include("functions.php");

	//user_data = check_login($con);
	$user_data = check_login($conn);

	// if the user is a patient (has role=patient) then this page should have a link to the registration form
	if($user_data['role']==='patient'){
		$TEST = $user_data['username'];
		$query = "SELECT user_ID FROM user WHERE username = '$TEST'";
		$result = mysqli_query($conn, $query);
		if($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			$user_id = $user_data['user_ID'];
		}
		$patient_exists = "SELECT patient.user_id FROM patient,user WHERE patient.user_id='$user_id'";
		$res = mysqli_query($conn, $patient_exists);
		if($res && mysqli_num_rows($res)>0){
			header("Location: patienthomepage.php");
		}
		else{
			header("Location: new_patient_form.php");
		}
	}
	elseif($user_data['role']==='doctor'){
		header("Location: doctorhomepage.php");
	}
	elseif($user_data['role']==='admin'){
		header("Location: adminhomepage.php");
		
	}
	
?>
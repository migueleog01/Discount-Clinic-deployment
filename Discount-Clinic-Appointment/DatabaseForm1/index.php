<?php 
session_start();
ob_start();

	// include("connection.php");
	include("dbh-inc.php");
	include("functions.php");

	//user_data = check_login($con);
	$user_data = check_login($conn);

	// if the user is a patient (has role=patient) then this page should have a link to the registration form
	if($user_data['role']='patient')
		header("Location: patienthomepage.php");
	elseif($user_data['role']='doctor')
		header("Location: doctorhomepage.php");
?>
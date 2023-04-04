<?php 
	session_start();
	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);
	$user_id = $user_data['user_ID'];

	if(isset($_POST['update-submit'])) {
		$field = $_POST['field'];
		$new_value = $_POST['new_value'];

		switch ($field) {
			case "first_name":
				$sql = "UPDATE discount_clinic.patient SET first_name = '$new_value' WHERE user_id = '$user_id'";
				break;
			case "middle_initial":
				$sql = "UPDATE discount_clinic.patient SET middle_initial = '$new_value' WHERE user_id = '$user_id'";
				break;
			case "last_name":
				$sql = "UPDATE discount_clinic.patient SET last_name = '$new_value' WHERE user_id = '$user_id'";
				break;
			case "gender":
				$sql = "UPDATE discount_clinic.patient SET gender = '$new_value' WHERE user_id = '$user_id'";
				break;
			case "phone_number":
				$sql = "UPDATE discount_clinic.patient SET phone_number = '$new_value' WHERE user_id = '$user_id'";
				break;
			case "DOB":
				$sql = "UPDATE discount_clinic.patient SET DOB = '$new_value' WHERE user_id = '$user_id'";
				break;
			case "street_address":
				$sql = "UPDATE discount_clinic.address SET street_address = '$new_value' WHERE address_id = (SELECT address_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "city":
				$sql = "UPDATE discount_clinic.address SET city = '$new_value' WHERE address_id = (SELECT address_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "state":
				$sql = "UPDATE discount_clinic.address SET state = '$new_value' WHERE address_id = (SELECT address_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "zip":
				$sql = "UPDATE discount_clinic.address SET zip = '$new_value' WHERE address_id = (SELECT address_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "e_first_name":
				$sql = "UPDATE discount_clinic.emergency_contact SET e_first_name = '$new_value' WHERE patient_id = (SELECT patient_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "e_middle_initial":
				$sql = "UPDATE discount_clinic.emergency_contact SET e_middle_initial = '$new_value' WHERE patient_id = (SELECT patient_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "e_last_name":
				$sql = "UPDATE discount_clinic.emergency_contact SET e_last_name = '$new_value' WHERE patient_id = (SELECT patient_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "ec_phone_number":
				$sql = "UPDATE discount_clinic.emergency_contact SET phone_number = '$new_value' WHERE patient_id = (SELECT patient_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			case "relationship":
				$sql = "UPDATE discount_clinic.emergency_contact SET relationship = '$new_value' WHERE patient_id = (SELECT patient_id FROM discount_clinic.patient WHERE user_id = '$user_id')";
				break;
			default:
				header("Location: patient_profile.php?error=invalidfield");
				exit();
		}
		if (mysqli_affected_rows($conn) == 0) {
			header("Location: patient_profile.php?error=updatefailed");
			exit();
		} else {
			header("Location: patient_profile.php?success=updatecompleted");
			exit();
		}
	}
	else {
		header("Location: patient_profile.php?error=invalidfield");
		exit();
	}




?>
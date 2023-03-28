<?php
	session_start();
	include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id_fk = $user_data['user_ID'];


    //queries patient first name
    $patient_name = "SELECT first_name FROM patient WHERE user_id = '$user_id_fk'";

    $first_name = mysqli_query($conn, $patient_name);

		if($first_name && mysqli_num_rows($first_name) > 0)
		{

			$name = mysqli_fetch_assoc($first_name);
			$output = $name['first_name'];
			echo $output;

		}
	
	//queries patient gender
	$patient_gender = "SELECT gender FROM patient WHERE user_id = '$user_id_fk'";

    	$gender = mysqli_query($conn, $patient_gender);

        if($gender && mysqli_num_rows($gender) > 0)
        {
            $pgender = mysqli_fetch_assoc($gender);
            $genderoutput = $pgender['gender'];
        }

	//queries patient DOB
	$patient_DOB = "SELECT DOB FROM patient WHERE user_id = '$user_id_fk'";

    	$DOB = mysqli_query($conn, $patient_DOB);

        if($DOB && mysqli_num_rows($DOB) > 0)
        {
            $pDOB = mysqli_fetch_assoc($DOB);
            $DOBoutput = $pDOB['DOB'];
        }

	//queries patient phone #
	$patient_phone_number = "SELECT phone_number FROM patient WHERE user_id = '$user_id_fk'";

	$phone_number = mysqli_query($conn, $patient_phone_number);
	
			if($phone_number && mysqli_num_rows($phone_number) > 0)
			{
				$pphonenumber = mysqli_fetch_assoc($phone_number);
				$phonenumberoutput = $pphonenumber['phone_number'];
			}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Patient Profile</title>
	<style>
		h1 {
			font-size: 40px;
			color: #333;
			margin-top: 30px;
			margin-bottom: 20px;
            background-color: #192841; 
		}
		p {
			font-size: 16px;
			color: #555;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<h1><center>Patient Profile</center></h1>
	<p><strong>Patient Name: </strong> <?php echo $output; ?></p>
    	<p><strong>Gender: </strong> <?php echo $genderoutput; ?></p>
	<p><strong>Date of Birth:</strong> <?php echo $DOBoutput; ?> </p>
	<p><strong>Address:</strong> 123 Main Street, Anytown, USA</p>
	<p><strong>Phone: </strong> <?php echo $phonenumberoutput;?></p>
	<p><strong>Email:</strong> john.doe@email.com</p>
	<p><strong>Current Primary Doctor:</strong> Dr. Patel</p>
    	<p><strong>Approval To See Specialist:</strong> No </p>
    	<p><strong>Medical Conditions:</strong> Diabetes, High Blood Pressure</p>
	<p><strong>Allergies:</strong> Peanuts, Shellfish</p>
</body>
</html>

<?php

//function check_login($conn)
function check_login($conn)
{
	if(isset($_SESSION['username']))
	{

		$id = $_SESSION['username'];
		$query = "SELECT * FROM user WHERE username = '$id' LIMIT 1" ;

		$result = mysqli_query($conn,$query);
		//$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;

		}
	}
	//redirect to login
	header("Location: login.php");
	die;

}
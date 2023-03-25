<?php
 session_start();
//ob_start();

	// include("connection.php");
	include("dbh-inc.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//somthing was posted
		$role = $_POST['role'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($role) && !empty($username) && !empty($password) && !is_numeric($username))
		{
			$checking_query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";

			$result = mysqli_query($conn, $checking_query);

			if($result && mysqli_num_rows($result) > 0){
				echo "Username already taken";
			}
			/*
			$checking_query = "SELECT COUNT(*) FROM user WHERE username = ('$username')";
			//mysqli_query($conn, $checking_query);
			if(($checking_query)>0)
			{
				echo "Username already taken";
			}
			*/
			else{
			$query = "INSERT INTO user (role,username,password) VALUES ('$role','$username','$password')";

			//mysqli_query($con, $query);
			mysqli_query($conn, $query);

			header("Location: login.php");
			die;
			}
		}
		else
		{
			echo "Missing or invalid fields";
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>

	<style type="text/css">

		#text{

			height: 25px;
			border-radius: 5px;
			padding: 4px;
			border: solid thin #aaa;
			width: 100%;
		}

		#button{

			border-radius: 5px;
			padding: 10px;
			width: 100px;
			color: white;
			background-color: lightblue;
			border:	none;
		}

		#box{

			border-radius: 25px;
			background-color: blueviolet;
			margin: auto;
			width: 300px;
			padding: 20px;
		}
		
	</style>

	<div id="box">

		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;text-align: center;">Register</div>

			<input id="text" type="text" name="role" placeholder="Role (doctor, patient)"><br><br>

			<input id="text" type="text" name="username" placeholder="Username"><br><br>
			<input id="text" type="password" name="password" placeholder="Password"><br><br>

			<input id="button" type="submit" value="Register"><br><br>

			<a href="login.php">Click to Login</a><br><br>
		</form>
	</div>

</body>
</html>

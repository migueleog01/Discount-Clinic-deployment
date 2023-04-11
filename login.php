<?php
ob_start();
session_start();


	// include("connection.php");
	include("dbh-inc.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$role = $_POST['role'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($role) && !empty($username) && !empty($password) && !is_numeric($username))
		{

			$query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";

			$result = mysqli_query($conn, $query);

			if($result){
				if($result && mysqli_num_rows($result) > 0)
				{
					$user_data = mysqli_fetch_assoc($result);
					if($user_data['password'] === $password && $user_data['role'] === $role)
					{
						$_SESSION['username'] = $user_data['username'];
						header("Location: index.php");
						die;
					}
				}
			}

			echo "Invalid credentials";

		}
		else
		{
			echo "Invalid credentials";
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
			background-color: #0069d9;
			border:	none;
		}

		#box-parent{
			background-color: #f5f5f5;
			width: 100%;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		#box{
			border: 1px solid #ccc;
			border-radius: 25px;
			background-color: white; 
			margin: auto;
			width: 300px;
			padding: 20px;
			box-shadow: 0px 0px 10px 0px #ccc;
			justify-content: center;
			align-items: stretch;
			display: flex;
			flex-direction: column;
		}

		form {
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		#input-div{
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
		}

		#button {
			width: 100%;
		}
		
	</style>

	<div id="box-parent">
	<div id="box">

		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: black;text-align: center;"><strong>Login</strong></div>
			<div id="input-div">
			<input id="text" type="text" name="role" placeholder="Role (admin, doctor, patient)"><br><br>

			<input id="text" type="text" name="username" placeholder="Username"><br><br>
			<input id="text" type="password" name="password" placeholder="Password"><br><br>
				<input id="button" type="submit" value="LOGIN"><br><br>
				<a href="signup.php">Click to Register</a><br><br>
			</div>
		</form>
	</div>
	</div>
</body>
</html>

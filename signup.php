<?php
 	session_start();
 	ob_start();
	include("functions.php");
	include("dbh-inc.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($username) && !empty($password) && !is_numeric($username))
		{
			$checking_query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
			$result =  mysqli_query($conn, $checking_query);


			if($result && mysqli_num_rows($result) > 0){
				echo "Username already taken";
			}
			else{
			$query = "INSERT INTO user (role,username,password) VALUES ('patient','$username','$password')";
			mysqli_query($conn, $query);
			$select_query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
			$result = mysqli_query($conn, $select_query);


			if($result){
				if($result && mysqli_num_rows($result) > 0)
				{
					$user_data = mysqli_fetch_assoc($result);
					if($user_data['password'] === $password)
					{
						$_SESSION['username'] = $user_data['username'];
						header("Location: new_patient_form.php");
						die;
					}
				}
			}
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
		form{
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		#input-div{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}

		#button{
			width: 100%
		}
		
	</style>
	<div id="box-parent">
	<div id = "box">
		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: black;text-align: center;"><strong>Register</strong></div>
			<div id = "input-div">
			<input id="text" type="text" name="username" placeholder="Username"><br><br>
			<input id="text" type="password" name="password" placeholder="Password"><br><br>
			<input id="button" type="submit" value="REGISTER"><br><br>
			<a href="login.php">Click to Login</a><br><br>
			</div>
		</form>
	</div>
	</div>
</body>
</html>
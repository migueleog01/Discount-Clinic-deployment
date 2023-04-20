<?php
    ob_start();
    session_start();
?>

<!DOCTYPE html>
<html lang = "en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src = "script.js" defer></script>
	<title>Office Form</title>
    <header>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <h1><center>Create Office Form</center></h1>
        <nav>
            <ul>
                <li class ="active"><a href="adminhomepage.php">Home</a></li>
                <li><a href="admin_create_doctor.php">Create Doctor</a></li>
                <li><a href="admin_create_office.php">Create Office</a></li>
                <li><a href="admin_delete_patient.php">Delete Patient</a></li>
                <li><a href="admin_delete_doctor.php">Delete Doctor</a></li>
                <li><a href="admin_delete_office.php">Delete Office</a></li>
				<li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
	<style>
		label {
			display: block;
			margin-top: 10px;
		}
		input[type="text"], input[type="tel"], select {
			margin-top: 5px;
			padding: 5px;
			font-size: 16px;
			border-radius: 5px;
			border: none;
			border-bottom: 2px solid gray;
		}
		input[type="radio"] {
			margin-top: 5px;
			margin-right: 5px;
		}
		input[type="submit"] {
			margin-top: 20px;
			padding: 10px;
			font-size: 16px;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
	</style>
</head>
<body>

	<form method="post" action ="">
        <label for="street_address">Street Address:</label>
        <input type="text" id="street_address" name="street_address" required>


        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>


        <label for="state">State:</label>
        <select id="state" name="state" required>
            <option value=""></option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
        </select>
		

		<label for="zip">Zip:</label>
		<input type="text" id="zip" name="zip">
        <button type="submit" value="Submit">Submit</button>
    <form>

<?php
    include("dbh-inc.php");
    include("functions.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $street_address = $_POST['street_address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $zip = $_POST['zip'];
    

        if(ctype_alnum(str_replace(' ', '', $street_address)) && ctype_alpha(str_replace(' ', '', $city)) && ctype_alpha($state) && ctype_digit($zip)) {
            $sql_office = "INSERT INTO discount_clinic.address (`street_address`,`city`,`state`,`zip`,`deleted`) VALUES
            ('$street_address','$city', '$state', '$zip', 0)";
            mysqli_query($conn, $sql_office);


            $new_address_id_sql = "SELECT address_id FROM discount_clinic.address WHERE address.street_address = '$street_address' AND address.city = '$city' AND address.state = '$state' AND address.zip = '$zip'";
            $new_address_id_res = mysqli_query($conn, $new_address_id_sql);
            $new_address_id_row = mysqli_fetch_assoc($new_address_id_res);
            $new_address_id = $new_address_id_row['address_id'];


            $new_office_sql = "INSERT INTO discount_clinic.office (address_id, deleted) VALUES 
            ($new_address_id, 0)";
            mysqli_query($conn, $new_office_sql);
            echo "Office added successfully";
        } else {
            echo "Invalid input";
        }
        mysqli_close($conn);
    }
?>
</body>
</html>

<?php
session_start();

include("dbh-inc.php");
include("functions.php");


$val = $_GET["value"];

$val_M = mysqli_real_escape_string($conn, $val);



$sql = "SELECT office_id, street_address, city, state, zip FROM address,office WHERE office.address_id = address.address_id AND state = '$val_M'";
$result = mysqli_query($conn, $sql);

if($result && mysqli_num_rows($result) > 0)
{
	echo "<select>";
	//echo "<select name='office'>";

		 //   $results = array();

	while ($rows = mysqli_fetch_assoc($result))
	{
	    $office_id = $rows["office_id"];

	 //   $results[] = $office_id;

	    $street = $rows["street_address"];
	    $city = $rows["city"];
	    $state = $rows["state"];
	    $zip = $rows["zip"];
	    //echo "<option>$office_id $street $city $state $zip</option>";
	    // echo "<option value="$office_id">$office_id $street $city $state $zip</option>";  // this works!
	    echo "<option>$office_id $street $city $state $zip</option>";  // this works!
	    //echo "<option value='$office_id'>$office_id</option>";      // this works, but only w/ one attribute
	}


	echo "</select>";

//additions for other_helper.php are below:
	// by the end of the while loop above, $office_id holds the value of the last possible row id in the query output, as seen when tested with the echo below:
		 echo $office_id;
	//$output = $results[$office_id];
	// echo $output;

}


// function get_office()

/*
function check_login($conn)
{
	if(isset($_SESSION['username']))
	{

		$id = $_SESSION['username'];
		$query = "SELECT * FROM user WHERE username = '$id' LIMIT 1" ;

		$result = mysqli_query($conn,$query);
	
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
*/

?>


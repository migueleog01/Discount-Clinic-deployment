
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

	while ($rows = mysqli_fetch_assoc($result))
	{
	    $office_id = $rows["office_id"];
	    $street = $rows["street_address"];
	    $city = $rows["city"];
	    $state = $rows["state"];
	    $zip = $rows["zip"];
	    echo "<option>$office_id $street $city $state $zip</option>";  // this works!
	    //echo "<option value='$office_id'>$office_id</option>";      // this works, but only w/ one attribute
	}


	echo "</select>";
}


?>
<?php
ob_start();
session_start();

include("dbh-inc.php");
include("functions.php");


$val = $_GET["value"];

$val_M = mysqli_real_escape_string($conn, $val);

mb_detect_encoding($val_M);

$sql = "SELECT doctor_id, first_name, middle_initial, last_name, phone_number, gender, specialty FROM doctor, doctor_office
WHERE doctor_id = DID AND doctor_office.OID = '$val_M' AND specialty='primary';";

$result = mysqli_query($conn, $sql);

if($result && mysqli_num_rows($result) > 0)
{
	echo "<select id='doctor' name='doctor' required>";

	while ($rows = mysqli_fetch_assoc($result))
	{
		$doctor_id = $rows["doctor_id"];
	    $fname = $rows["first_name"];
	    $minit = $rows["middle_initial"];
	    $lname = $rows["last_name"];
	    $phone = $rows["phone_number"];
	    $gender = $rows["gender"];
	    $specialty = $rows["specialty"];

	    echo "<option value='$doctor_id'>$fname, $minit, $lname, $phone, $gender, $specialty</option>";
	}

	echo "</select>";
}

?>
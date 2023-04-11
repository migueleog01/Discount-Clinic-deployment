<?php
session_start();
include("dbh-inc.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $approval_id = $_POST['approval_id'];
  $doctor_id = $_POST['doctor_id'];
  
  // Update the approval tuple in your database
  $query = "UPDATE approval SET approval_bool = 1, primary_doctor_id = '$doctor_id' WHERE approval_id = '$approval_id'";

  // execute the query and send a response back to the client
  if ($conn->query($query) === TRUE) {
    echo 'Approval updated successfully.';
  } else {
    echo 'Error updating approval: ' . $conn->error;
  }
}
?>

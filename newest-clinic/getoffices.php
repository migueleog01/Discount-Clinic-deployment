<?php
session_start();

include("dbh-inc.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['state'])) {
  $state = $_GET['state'];
  $office_addresses = "SELECT office.office_id, address.street_address, address.city, address.state, address.zip FROM address,office WHERE office.address_id = address.address_id AND address.state = '$state'";
  $result = mysqli_query($conn, $office_addresses);
  $offices = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $offices[] = array(
      'id' => $row['office_id'],
      'name' => $row['street_address'] . ', ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zip']
    );
  }
  echo json_encode($offices);
}
?>

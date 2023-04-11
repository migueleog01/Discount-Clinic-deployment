<?php
ob_start();
session_start();

    include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);

    if($user_data['role']==='patient')
        header("Location: patienthomepage.php");
    elseif($user_data['role']==='doctor')
        header("Location: doctorhomepage.php");
    elseif($user_data['role']==='admin')
        header("Location: adminhomepage.php");
?>
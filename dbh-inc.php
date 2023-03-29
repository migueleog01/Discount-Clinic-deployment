
<?php    
    $servername = "discountclinic.mysql.database.azure.com";
    $username = "adminLogin";
    $password = "1234567c!";
    $dbname = "discount_clinic";

    // Create connection
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,"./DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, MYSQLI_CLIENT_SSL);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
   

?>
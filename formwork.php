<!--Patient Information Form-->
<?php
    ob_start();
    session_start();
    
    


    include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id_fk = $user_data['user_ID'];

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get input values
        /*
        $firstname =  $_POST['firstname'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        //print first name
        echo $firstname;
        */

        $firstname = $_POST['firstname'];
        $middleInitial = $_POST['middle-initial'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['date-input'];
        $dob = date('Y-m-d', strtotime($dob));
        $phone = $_POST['phone'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        $zip = $_POST['zipcode'];
        $emergencyFirstName = $_POST['Emergencyfirst-name'];
        $emergencyLastName = $_POST['Emergencylast-name'];
        $relationship = $_POST['Relationship'];
        $emergencyPhone = $_POST['emergencyContactPhone'];

        $allergies = $_POST['allergies'];

        $emergencyMiddleInitial =  'D';



        $sql_address = "INSERT INTO address (street_address, city, state, zip, deleted) VALUES ('$street', '$city', '$state', '$zip', 0)";
        if (mysqli_query($conn, $sql_address)) {
            // Retrieve generated address_id value
            $address_id = mysqli_insert_id($conn);

            // Insert new patient record using the generated address_id value
            /*
            $sql_patient = "INSERT INTO patient (user_id, address_id, first_name, middle_initial, last_name, gender, phone_number, DOB, deleted) 
            VALUES (NULL, $address_id, '$firstname', '$middleInitial', '$last_name', '$gender', '$phone', '$dob', 0)";
            */
            $sql_patient = "INSERT INTO patient (user_id, address_id, first_name, middle_initial, last_name, gender, phone_number, DOB, total_owe, deleted) 
            VALUES ($user_id_fk, $address_id, '$firstname', '$middleInitial', '$last_name', '$gender', '$phone', '$dob', 0, 0)";

            if (mysqli_query($conn, $sql_patient)) {
                // Retrieve generated patient_id value
                $patient_id = mysqli_insert_id($conn);

                // Insert new emergency contact record using the generated patient_id value
                $sql_emergency = "INSERT INTO emergency_contact (patient_id, e_first_name, e_middle_initial, e_last_name, phone_number, relationship, deleted) 
                VALUES ($patient_id, '$emergencyFirstName', '$emergencyMiddleInitial', '$emergencyLastName', '$emergencyPhone', '$relationship', 0)";

                if (mysqli_query($conn, $sql_emergency)) {
                    //echo "Records inserted successfully.";
                    // Close the database connection
                    //mysqli_close($conn);
                    mysqli_close($conn);
                    header("Location: " . $_SERVER['PHP_SELF']);
                    header("Location: thankyouForm.php");
                } else {
                    echo "ERROR: Could not able to execute $sql_emergency. " . mysqli_error($conn);
                }
            } else {
                echo "ERROR: Could not able to execute $sql_patient. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not able to execute $sql_address. " . mysqli_error($conn);
        }

        /*
        if (mysqli_query($conn, $sql_address) && mysqli_query($conn, $sql_patient) && mysqli_query($conn, $sql_emergency)) {

            //echo "New record created successfully";

            // Close the database connection

            //make sur it executes



            mysqli_close($conn);
            header("Location: ".$_SERVER['PHP_SELF']);
            header("Location: thankyouForm.php");
        
            //exit();

            //header("Location: ./thankyouForm.php");
            exit();
            



        } else {
            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
        */

        mysqli_close($conn);
    }
    //ob_end_flush();
    ?>
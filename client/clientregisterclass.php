<?php session_start(); ?>
<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $email = $_SESSION['email'];

    // Get the classid from the database
    $sql = "SELECT class_id FROM coach_classes WHERE id = '$id'";
    $result = mysqli_query($linkDB, $sql);
    $row = mysqli_fetch_assoc($result);
    $classid = $row['class_id'];

    // Check if the class is already in the client_classes table
    $check_query = "SELECT * FROM client_classes WHERE class_id = '$classid' AND email = '$email' AND status = 1";
    $check_result = mysqli_query($linkDB, $check_query);

     if (mysqli_num_rows($check_result) > 0) {
         // If the class is already in the client_classes table, show an error message
         header('location: clientmyclasses.php?msg=notsuccess');
     } else {

            // Check if the number of registered students is less than the maximum allowed
            $max_query = "SELECT no_of_students FROM coach_classes WHERE class_id = '$classid'";
            $max_result = mysqli_query($linkDB, $max_query);
            $max_row = mysqli_fetch_assoc($max_result);
            $max_students = $max_row['no_of_students'];

            $count_query = "SELECT COUNT(*) AS num_students FROM client_classes WHERE class_id = '$classid' AND status = 1";
            $count_result = mysqli_query($linkDB, $count_query);
            $count_row = mysqli_fetch_assoc($count_result);
            $num_students = $count_row['num_students'];

            if ($num_students >= $max_students) {
                // If the maximum number of students has already registered for the class, show an error message
                header('location: clientmyclasses.php?msg=maxstudents');
            } else {
                // If the class is not in the client_classes table and there is space for another student, insert it
                $insert_query = "INSERT INTO client_classes (class_id, email) VALUES ('$classid', '$email')";
                $insert_result = mysqli_query($linkDB, $insert_query);
        
                if ($insert_result) {
                    header('location: clientmyclasses.php?msg=success');
                } else {
                    // If there was an error inserting the class, show an error message
                    header('location: clientmyclasses.php?msg=unsuccess');
                }
            }
        }
?>

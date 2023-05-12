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
         header('location: clientcoachbadminton.php?msg=notsuccess');
     } else {

         // If the class is not in the client_classes table, insert it
         $insert_query = "INSERT INTO client_classes (class_id, email) VALUES ('$classid', '$email')";
         $insert_result = mysqli_query($linkDB, $insert_query);
         
         if ($insert_result) {
            header('location: clientcoachbadminton.php?msg=success');
         } else {
             // If there was an error inserting the class, show an error message
             header('location: clientcoachbadminton.php?msg=unsuccess');
         }
     }
?>

?>
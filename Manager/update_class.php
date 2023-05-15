<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the class ID and updated class_id
    $class_id = $_POST['class_id'];
    $class_subject = $_POST['class_subject'];

    // Update the class in the database
    $sql = "UPDATE coach_classes SET class_id='$class_subject', status = 1 WHERE id='$class_id'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the clientclasss.php page with a success message
        header('location: managerclassverification.php?msg=success');
    } else {
        // Redirect to the clientclasss.php page with a success message
        header('location: managerclassverification.php?msg=notsuccess');
    }
}
?>
<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the complaint ID and updated details
    $complaint_id = $_POST['complaint_id'];
    $complaint_subject = $_POST['complaint_subject'];
    $complaint_details = $_POST['complaint_details'];

    // Update the complaint in the database
    $sql = "UPDATE complaints SET subject='$complaint_subject', details='$complaint_details' WHERE id='$complaint_id'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the clientcomplaints.php page with a success message
        header('location: clientcomplaints.php?msg=success');
    } else {
        // Redirect to the clientcomplaints.php page with a success message
        header('location: clientcomplaints.php?msg=notsuccess');
    }
}
?>
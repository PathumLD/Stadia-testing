<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the notification ID 
    $notification_id = $_POST['notification_id'];

    // Update the notification in the database
    $sql = "UPDATE notifications SET is_read = 1 WHERE id='$notification_id'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the clientnotifications.php page with a success message
        header('location: clientnotifications.php?msg=success');
    } else {
        // Redirect to the clientnotifications.php page with a success message
        header('location: clientnotifications.php?msg=notsuccess');
    }
}
?>
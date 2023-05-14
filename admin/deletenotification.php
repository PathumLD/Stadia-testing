<?php
session_start();
 include("../linkDB.php"); //database connection function 

// Check if the user is logged in
if (isset($_SESSION["email"])) {
    // Get the email of the logged in user
    $email = $_SESSION["email"];

    // Get the ID of the notification to be deleted
    $id = $_GET['id'];

    // Delete the notification from the database
    $query = "UPDATE notifications SET is_read = 1 WHERE id = '$id'";
    $result = mysqli_query($linkDB, $query);
    
    if($result){
        // Reload the current page
        echo "<script>window.location.href = 'adminnotifications.php';</script>";
   
    } else {
        // Return an error message
       echo "<script type='text/javascript'>alert('Failed to update notifications');</script>";
    }
}
    ?>
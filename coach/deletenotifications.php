<?php session_start(); ?>
<?php
    include("../linkDB.php");

        // Get the ID of the notification to be deleted
        $id = $_GET['id'];

        // Delete the notification from the database
        $query = "UPDATE notifications SET is_read = 1 WHERE id = $id";
        $result = mysqli_query($linkDB, $query);
    
        if ($res==TRUE)
        {
           // Redirect to the coachnotifications.php page with a success message
            header('location: coachnotifications.php?msg=success');
        } else {
            // Redirect to the coachnotifications.php page with a success message
            header('location: coachnotifications.php?msg=notsuccess');
        }
?>
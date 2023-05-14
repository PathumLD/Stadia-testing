<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["email"])) {
    // Get the email of the logged in user
    $email = $_SESSION["email"];

    // Get the ID of the notification to be deleted
    $id = $_POST['id'];

    // Delete the notification from the database
    $query = "UPDATE notifications SET is_read = 1 WHERE id = $id'";
    mysqli_query($linkDB, $query);

    // Return a success message
    echo "Notification updated successfully.";
} else {
    // Return an error message
    echo "You must be logged in to delete notifications.";
}
?>

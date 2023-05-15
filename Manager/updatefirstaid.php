<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the item ID and updated details
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];

    // Update the first aid records in the database
    $sql = "UPDATE first_aid SET item_name='$item_name', quantity='$quantity' WHERE item_id='$item_id'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the managerfirstaidrecords.php page with a success message
        header('location: managerfirstaidrecords.php?msg=success');
    } else {
        // Redirect to managerfirstaidrecords.php page with a success message
        header('location: managerfirstaidrecords.php?msg=notsuccess');
    }
}
?>
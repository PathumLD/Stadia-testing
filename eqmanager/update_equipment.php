<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the equipment ID and updated details
    $equipment_id = $_POST['equipment_id'];
    $equipment_quantity = $_POST['equipment_quantity'];
    $equipment_price = $_POST['equipment_price'];

    // Update the equipment in the database
    $sql = "UPDATE equipment SET quantity='$equipment_quantity', price='$equipment_price' WHERE id='$equipment_id'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the emrecords.php page with a success message
        header('location: emrecords.php?msg=success');
    } else {
        // Redirect to the emrecords.php page with a success message
        header('location: emrecords.php?msg=notsuccess');
    }
}
?>
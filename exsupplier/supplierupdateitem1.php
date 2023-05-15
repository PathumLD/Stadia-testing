<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the equipment ID and updated details
    $itemid = $_POST['itemid'];
    $itemname = $_POST['itemname'];
    $price = $_POST['price'];

    // Update the equipment in the database
    $sql = "UPDATE refreshments_drinks SET itemname='$itemname',price='$price' WHERE itemid='$itemid'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the emrecords.php page with a success message
        header('location: supplierdashboard.php?msg=success');
    } else {
        // Redirect to the emrecords.php page with a success message
        header('location: supplierdashboard.php?msg=notsuccess');
    }
}
?>
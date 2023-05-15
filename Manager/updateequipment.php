<?php

include("../linkDB.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the item ID and updated details
    $itemid = $_POST['itemid'];
    $itemname = $_POST['itemname'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Update the first aid records in the database
    $sql = "UPDATE equipment SET itemname='$itemname', quantity='$quantity', price='$price' WHERE itemid='$itemid'";
    $result = mysqli_query($linkDB, $sql);

    if($result) {
        // Redirect to the managerequipmentrecords.php page with a success message
        header('location: managerequipmentrecords.php?msg=success');
    } else {
        // Redirect to managerequipmentrecords.php page with a success message
        header('location: managerequipmentrecords.php?msg=notsuccess');
    }
}
?>
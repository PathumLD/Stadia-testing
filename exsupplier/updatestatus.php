<?php
session_start();
include("../linkDB.php"); //database connection function 
if (isset($_POST['product_ids']) && isset($_POST['s_r'])) {
    $productIds = $_POST['product_ids'];
    $s_r = $_POST['s_r'];

    foreach ($productIds as $productId) {
        $query = "UPDATE orders SET s_r = '$s_r' WHERE product_id = '$productId'";
        $result = mysqli_query($linkDB, $query);
    }

 

    // check if query was successful
    if ($result) {
        echo "<script>window.location.href='suppliersupplyorders.php';</script>";
    } else {
        echo "<script>alert('Error updating order');</script>";
    }
} else {
    echo "<script>alert('Product ID is not set');</script>";
}

?>
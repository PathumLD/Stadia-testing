<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "DELETE FROM equipment WHERE id=$id";

    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: managerequipmentrecords.php');
    }
    else
    {
        header('location: managerequipmentrecords.php');
    }
?>

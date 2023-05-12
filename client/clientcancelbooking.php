<?php session_start(); ?>
<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "UPDATE bookings SET status=0 WHERE id=$id";

    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: clientbookings.php');
    }
    else
    {
        header('location: clientbookings.php');
    }
?>
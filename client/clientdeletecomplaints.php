<?php session_start(); ?>
<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "UPDATE complaints SET status=0 WHERE id=$id";

    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: clientcomplaints.php');
    }
    else
    {
        header('location: clientcomplaints.php');
    }
?>
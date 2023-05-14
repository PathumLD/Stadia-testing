<?php session_start(); ?>
<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "UPDATE equipment SET status=0 WHERE id=$id";

    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: emrecords.php');
    }
    else
    {
        header('location: emrecords.php');
    }
?>
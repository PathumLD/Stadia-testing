<?php session_start(); ?>
<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "UPDATE client_classes SET status=0 WHERE id=$id";

    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: clientmyclasses.php');
    }
    else
    {
        header('location: clientmyclasses.php');
    }
?>
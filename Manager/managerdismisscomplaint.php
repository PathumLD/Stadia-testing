<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "DELETE FROM complaints WHERE complaintID=$id";

    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: managercomplaints.php');
    }
    else
    {
        header('location: managercomplaints.php');
    }
?>

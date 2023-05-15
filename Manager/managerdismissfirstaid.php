<?php session_start(); ?>
<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "UPDATE first_aid SET status=0 WHERE item_id=$id AND status = 1";


    $res = mysqli_query($linkDB, $sql);

    if ($res==TRUE)
    {
        header('location: managerfirstaidrecords.php');
    }
    else
    {
        header('location: managerfirstaidrecords.php');
    }
?>

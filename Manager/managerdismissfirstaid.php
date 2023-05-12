<?php
    include("../linkDB.php");

    $id = $_GET['id'];
    $sql = "DELETE FROM first_aid WHERE item_id=$id";

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

<?php session_start(); ?>
<?php
    include("../linkDB.php");

    if(isset($_POST['delete'])) { 
        $itemid = $_POST['itemid']; 
            
    $sql = "UPDATE refreshments_drinks SET status= 0 WHERE itemid='$itemid'";
// Execute SQL query
if (mysqli_query($linkDB, $sql)) {
       
    // Redirect to the emrecords.php page with a success message
    header('location: supplierdashboard.php?msg=success');
} else {
    // Redirect to the emrecords.php page with a success message
    header('location: supplierdashboard.php?msg=notsuccess');
}

    mysqli_close($linkDB); // Close database connection
}

?>

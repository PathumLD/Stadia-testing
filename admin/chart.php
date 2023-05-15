<?php
// Include the linkDB file to establish a database connection
 include("../linkDB.php"); 
 

// Retrieve the selected month from the form
$month = $_POST['month'];

// Retrieve the data for the selected month
$sql = "SELECT itemname, COUNT(*) AS rental_count FROM equipment_rental WHERE MONTH(date) = '$month' GROUP BY itemname";
$result = mysqli_query($linkDB, $sql);

$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[$row['itemname']] = $row['rental'];
    echo $row['itemname'] . ': ' . $row['rental'] . '<br>';
}

// Output the data as a JSON object
echo json_encode($data);

// Close the database connection
mysqli_close($linkDB);
?>

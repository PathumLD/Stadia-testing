<?php
// Establish a database connection
$linkDB = mysqli_connect("localhost", "username", "password", "database_name");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// Check if the item_id and quantity have been passed
if(isset($_POST['item_id']) && isset($_POST['quantity'])) {
    // Sanitize the inputs to prevent SQL injection
    $itemId = mysqli_real_escape_string($linkDB, $_POST['item_id']);
    $quantity = mysqli_real_escape_string($linkDB, $_POST['quantity']);

    // Insert the data into the cart_test table
    $query = "INSERT INTO cart_test (item_id, quantity) VALUES ('$itemId', '$quantity')";
    if(mysqli_query($linkDB, $query)) {
        echo "Data added to the cart_test table";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($linkDB);
    }
}

// Close the database connection
mysqli_close($linkDB);
?>

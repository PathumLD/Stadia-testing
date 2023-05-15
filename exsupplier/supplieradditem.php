<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?>


<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Stadia </title>

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/supplier.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../include/javascript.php'); ?>
    <?php include('../include/styles.php'); ?>

</head>

<body onload="initClock()">

    <div class="sidebar">

        <?php include('../include/suppliersidebar.php'); ?>

    </div>

    <section class="home-section">

        <nav>

            <?php include('../include/suppliernavbar.php'); ?>

        </nav>

        <div class="home-content">


            <div class="main-content">
                <div class="form">

                    <h1>Add Refreshments </h1>
                    <!-- form start -->
                    <form method="POST" action="" enctype="multipart/form-data">
                        <select name="Item-type" class="search" id="disable">
                            <option value="" disabled selected>Item Type</option>
                            <option value="drinks">Drinks</option>
                            <option value="snacks">Snacks</option>
                        </select>
                        <br><br>
                        <p class="add">Item Id</p><input type="text" name="itemid" required>
                        <p class="add">Item Name</p><input type="text" name="itemname" required>
                        <p class="add">Price</p><input type="text" name="price" required> <br>
                        <input type="file" name="image" accept="image/*" placeholder="Choose an image"
                            style="height: 45px;">
                        <input type="submit" name="submit" value="Confirm Add" class="btn">
                    </form>

                </div>
            </div>
        </div>
        </div>
        <footer>
            <div class="foot">
                <span>Created By <a href="#">Stadia.</a> | &#169; 2023 All Rights Reserved</span>
            </div>
        </footer>

    </section>

</body>

</html>

<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
<?php
include("../linkDB.php");

if (isset($_POST['submit'])) {
    $itemtype = $_POST["Item-type"];
    $itemid = $_POST["itemid"];
    $itemname = $_POST["itemname"];
    $price = $_POST["price"];
    $image = "";

    // Check if an image was uploaded
    if (isset($_FILES["image"])) {
        $image_name = $_FILES["image"]["name"];
        $image_size = $_FILES["image"]["size"];
        $image_tmp = $_FILES["image"]["tmp_name"];
        $image_type = $_FILES["image"]["type"];

        // Move the uploaded file to a permanent location
        move_uploaded_file($image_tmp, "../products/$image_name");

        $image = $image_name;
    }

    // Insert data into the correct table based on item type
    if ($itemtype == "drinks") {
        $sql = "INSERT INTO refreshments_drinks (itemid, itemname, price, image) VALUES ('$itemid', '$itemname', '$price', '$image')";
    } else {
        $sql = "INSERT INTO refreshments_snacks (itemid, itemname, price, image) VALUES ('$itemid', '$itemname', '$price', '$image')";
    }

    if (mysqli_query($linkDB, $sql)) {
        // Data inserted successfully, redirect to supplierdashboard.php
        echo "<script>window.location.href='supplierdashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($linkDB);
    }
}
?>
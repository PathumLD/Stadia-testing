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
                    <?php
                    if ($row && isset($row['itemid'])) {
                        $itemid = $row['itemid'];
                    $itemid = $_GET['itemid'];

                    if (isset($_POST['submit'])) {
                        $itemtype = $_POST["Item-type"];
                        $price = $_POST["price"];

                        //Insert data into the correct table based on item type
                        if ($itemtype == "drinks") {
                            $sql = "UPDATE refreshments_drinks SET price = '$price' WHERE itemid = '$itemid'";
                        } else {
                            $sql = "UPDATE refreshments_snacks SET price = '$price' WHERE itemid = '$itemid'";
                        }

                        if (mysqli_query($linkDB, $sql)) {
                            // Data inserted successfully, redirect to supplierdashboard.php
                            echo "<script>window.location.href='supplierdashboard.php';</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($linkDB);
                        }
                    }

                    // Retrieve item data based on the ID
                    $query = "SELECT itemid, itemname, price, image FROM refreshments_drinks WHERE itemid = '$itemid' 
                    UNION SELECT itemid, itemname, price, image FROM refreshments_snacks WHERE itemid = '$itemid'";
                    $result = mysqli_query($linkDB, $query);
                    $row = mysqli_fetch_assoc($result);
                }
                    ?>
                    <h1> Update Refreshments </h1>
                    <!-- form start -->
                    <form method="POST">
                        <select name="Item-type" class="search" id="disable">
                            <option value="" disabled selected>Item Type</option>
                            <option value="drinks">Drinks</option>
                            <option value="snacks">Snacks</option>
                        </select>
                        <br><br>
                        <p class="add">Item ID</p><input type="text" id="itemid" name="itemid" value="<?php echo $row['itemid']; ?>" readonly><br>

                        <p class="add">Price</p><input type="text" id="price" name="price" value="<?php echo $row['price']; ?>"><br>

                        <input type="submit" name="submit" value="Confirm Update" class="btn">
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
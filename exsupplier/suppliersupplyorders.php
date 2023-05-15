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
                <div class="class">
                    <h1>Supply Orders</h1>
                    <table class="table" id="supplyorders">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Supplied</th> <!-- Add new column for checkbox -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // execute the MySQL query to fetch the data
                            $query = "SELECT product_id,type, quantity, date 
                            FROM orders 
                            WHERE (type = 'drink' OR type = 'snack') AND status = 1 AND s_r = 0";

                            $result = mysqli_query($linkDB, $query);

                            // loop through your orders and display them in the table
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['product_id'] . '</td>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . $row['type'] . '</td>';
                                echo '<td>' . $row['quantity'] . '</td>';
                                echo '<td>';
                                echo '<form method="post" action="">'; // Use POST method to submit the form
                                echo '<input type="checkbox" name="orders[]" value="' . $row['product_id'] . ',' . $row['date'] . ',' . $row['quantity'] . '" style="transform: scale(1.5);">';
                                echo '</td>';
                                echo '</tr>';
                            }

                            // Handle the form submission
                            if (isset($_POST['update_status'])) {
                                if (!empty($_POST['orders'])) {
                                    foreach ($_POST['orders'] as $order) {
                                        $order_data = explode(',', $order);
                                        $product_id = $order_data[0];
                                        $date = $order_data[1];
                                        $quantity = $order_data[2];
                                        $sql = "UPDATE orders SET s_r = 2 WHERE product_id = '$product_id' AND date = '$date' AND quantity = '$quantity'";
                                        mysqli_query($linkDB, $sql);
                                    }
                                    header("Location: suppliermyorders.php"); // Redirect back to the orders page
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                    <button class="btn-new" type="submit" name="update_status"
                        style=" margin-left: 923px;margin-top: 2px">Update Supplied Orders</button>

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
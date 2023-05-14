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
                <table class="table" id="products-refreshments">
                    <tr>
                        <?php
                        

                        // Retrieve drinks data
                        $drinks_query = "SELECT itemname, price, image FROM refreshments_drinks";
                        $drinks_result = mysqli_query($linkDB, $drinks_query);

                        // Display drinks data in table
                        while ($row = mysqli_fetch_assoc($drinks_result)) {
                            echo "<td><img src='../products/" . $row['image'] . "'><br>" . $row['itemname'] . "<br>" . $row['price'] . "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        // Retrieve snacks data
                        $snacks_query = "SELECT itemname, price, image FROM refreshments_snacks";
                        $snacks_result = mysqli_query($linkDB, $snacks_query);

                        // Display snacks data in table
                        while ($row = mysqli_fetch_assoc($snacks_result)) {
                            echo "<td><img src='../products/" . $row['image'] . "'><br>" . $row['itemname'] . "<br>" . $row['price'] . "</td>";
                        }
                        ?>
                    </tr>
                </table>
            </div>



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
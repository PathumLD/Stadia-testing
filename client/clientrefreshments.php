<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/client/clientrefreshments.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/clientsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/navbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

            <?php $var = $_SESSION['email']; ?>

            <h1>Order Refreshments</h1>

            <div class="content">

                <h3><b>Try our snacks and drinks!</b><br>
                        We sell the best snacks and drinks in town. Try them out to quench your thirst and hunger.</h3>

            <div class="left">

                <h3>Drinks</h3>

                    <form method="post" action="clientcart.php">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price (Rs.)</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php

                                $query_drinks = "SELECT * FROM refreshments_drinks WHERE status = 1";
                                $result_drinks = mysqli_query($linkDB, $query_drinks);
                                while ($row_drinks = mysqli_fetch_assoc($result_drinks)) {
                                    $productId = $row_drinks['itemid'];
                            ?>
                                <div>
                                    <input type="hidden" name="product_id_<?= $productId ?>" value="<?= $row_drinks['itemid'] ?>">
                                    <input type="hidden" name="product_name_<?= $productId ?>" value="<?= $row_drinks['itemname'] ?>">
                                    <input type="hidden" name="product_price_<?= $productId ?>" value="<?= $row_drinks['price'] ?>">
                                    <input type="hidden" name="product_type_<?= $productId ?>" value="drink">
                                    <tr>
                                        <td><label><?= $row_drinks['itemname'] ?></label></td>
                                        <td><label><?= $row_drinks['price'] ?></label></td>
                                        <td><input type="date" name="date_<?= $productId ?>" min="<?= date('Y-m-d', strtotime('now')) ?>" max="<?= date('Y-m-d', strtotime('+3 months')) ?>"></td>
                                        <td><input type="time" name="time_<?= $productId ?>" value="12:00" step="900" min="07:00" max="22:00"></td>                                        
                                        <td><input type="number" name="quantity_<?= $productId ?>" value="1" min="1"></td>
                                        <td><button type="submit" name="add_to_cart_<?= $productId ?>"><i class='fa fa-cart-plus'></i></button></td>
                                    </tr>
                                </div>
                                <?php
                                    }
                                ?>
                        </table> 

            </div>

            <div class="right">

                <h3>Snacks</h3>

                <table>
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price (Rs.)</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php

                                    $query_snacks = "SELECT * FROM refreshments_snacks WHERE status = 1";
                                    $result_snacks = mysqli_query($linkDB, $query_snacks);
                                    while ($row_snacks = mysqli_fetch_assoc($result_snacks)) {
                                        $productId = $row_snacks['itemid'];
                            ?>
                                    <div>
                                        <input type="hidden" name="product_id_<?= $productId ?>" value="<?= $row_snacks['itemid'] ?>">
                                        <input type="hidden" name="product_name_<?= $productId ?>" value="<?= $row_snacks['itemname'] ?>">
                                        <input type="hidden" name="product_price_<?= $productId ?>" value="<?= $row_snacks['price'] ?>">
                                        <input type="hidden" name="product_type_<?= $productId ?>" value="snack">
                                        <tr>
                                            <td><label><?= $row_snacks['itemname'] ?></label></td>
                                            <td><label><?= $row_snacks['price'] ?></label></td>
                                            <td><input type="date" name="date_<?= $productId ?>" min="<?= date('Y-m-d', strtotime('now')) ?>" max="<?= date('Y-m-d', strtotime('+3 months')) ?>"></td>
                                            <td><input type="time" name="time_<?= $productId ?>" value="12:00" step="900" min="07:00" max="22:00"></td>
                                            <td><input type="number" name="quantity_<?= $productId ?>" value="1" min="1"></td>
                                            <td><button type="submit" name="add_to_cart_<?= $productId ?>"><i class='fa fa-cart-plus'></i></button></td>
                                        </tr>
                                    </div>
                                <?php
                                    }
                                ?>
                        </table>
                    </form>

            </div>

          </div>

        </div>

    </div>

    <footer>
        <div class="foot">
          <?php include("../include/footer.php"); ?>
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
          dropdown[i].addEventListener("click", function() {
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

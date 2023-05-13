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
    <link rel="stylesheet" href="../css/client/clientequipment.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

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

            <h1>Order Equipment</h1>

            <div class="content">

                <h3><b>Haven't got your own equipment?</b><br>
                    Don't worry we have got you covered! <br>
                    Rent any equipment you need for the cheapest price.</h3>

                    <table id="searchtable">
                        <tr>
                            <td>
                                <form method="post">
                                    <input type="text" name="search" placeholder="Item Name..." class="search">
                                    <input type="submit" name="go" value="Search" id="searchbtn">
                                    <a href="clientbookings.php"><input type="submit" value="reset" id="resetbtn"></a>
                                </form>
                            </td>
                        </tr>
                    </table>


                    <form method="post">
                        <input type="date" name="date" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+3 months')) ?>"
                            <?php if (isset($date)) { echo "value=\"$date\""; } else { echo "placeholder=\"Select a date\""; } ?>>
                        <button type="submit" name="submit_date">Submit Date</button>
                    </form>

                    <?php
                    if (isset($_POST['submit_date'])) {
                        // Retrieve selected date from form submission
                        $date = $_POST['date'];
                        echo "<script>document.getElementsByName('date')[0].value='$date'</script>";
                        $date = date('Y-m-d', strtotime($date));
                
                        // Retrieve orders from database for selected date
                        $query_orders = "SELECT * FROM orders WHERE date = '$date'";
                        $result_orders = mysqli_query($linkDB, $query_orders);
                
                        // Retrieve equipment from database
                        $query_equipment = "SELECT * FROM equipment";
                        $result_equipment = mysqli_query($linkDB, $query_equipment);
                
                        // Loop through equipment and calculate available quantity for each item
                        while ($row_equipment = mysqli_fetch_assoc($result_equipment)) {
                            $available_quantity = $row_equipment['quantity'];
                            $productId = $row_equipment['itemid'];
                
                            // Loop through orders and subtract quantities from available quantity for matching itemids
                            while ($row_orders = mysqli_fetch_assoc($result_orders)) {
                                if ($row_orders['product_id'] == $productId) {
                                    $available_quantity -= $row_orders['quantity'];
                                }
                            }
                
                            // Reset order result pointer
                            mysqli_data_seek($result_orders, 0);
                
                            // Set available quantity for item
                            $equipment[$productId] = $available_quantity;
                        }
                    }
                    ?>

                    <form method="post" action="clientcart.php">
                        <input type="hidden" name="date" value="<?= $date ?>">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price (Rs.)</th>
                                    <th>Time</th>
                                    <th>Quantity</th>
                                    <th>Available Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php
                            $query_equipment = "SELECT * FROM equipment WHERE status = 1";
                            $result_equipment = mysqli_query($linkDB, $query_equipment);
                            while ($row_equipment = mysqli_fetch_assoc($result_equipment)) {
                                $productId = $row_equipment['itemid'];
                                $available_quantity = isset($equipment[$productId]) ? $equipment[$productId] : $row_equipment['quantity'];
                                ?>
                                <tr>
                                    <input type="hidden" name="product_id_<?= $productId ?>" value="<?= $row_equipment['itemid'] ?>">
                                    <input type="hidden" name="product_name_<?= $productId ?>" value="<?= $row_equipment['itemname'] ?>">
                                    <input type="hidden" name="product_price_<?= $productId ?>" value="<?= $row_equipment['price'] ?>">
                                    <input type="hidden" name="date_<?= $productId ?>" value="<?= $date ?>">
                                    <input type="hidden" name="product_type_<?= $productId ?>" value="equipment">
                                    <td><label><?= $row_equipment['itemname'] ?></label></td>
                                    <td><label><?= $row_equipment['price'] ?></label></td>
                                    <td><input type="time" name="time_<?= $productId ?>" value="12:00" step="900" min="07:00" max="22:00"></td>
                                    <td><input type="number" name="quantity_<?= $productId ?>" value="1" min="1" max="<?= $available_quantity ?>"></td>
                                    <td><label><?= $available_quantity ?></label></td>
                                    <td><button type="submit" name="add_to_cart_<?= $productId ?>"><i class='fa fa-cart-plus'></i></button></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </form>

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


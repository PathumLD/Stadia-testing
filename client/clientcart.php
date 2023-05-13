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
    <link rel="stylesheet" href="../css/client/clientcart.css">
 
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

            <h1>My Cart</h1>

            <div class="content">

            <?php
              // Check if the add to cart button was clicked for any product
              foreach ($_POST as $key => $value) {
                if (strpos($key, 'add_to_cart_') !== false) {
                  $productId = str_replace('add_to_cart_', '', $key);
                  $product_id = $_POST['product_id_'.$productId];
                  $product_name = $_POST['product_name_'.$productId];
                  $product_price = $_POST['product_price_'.$productId];
                  $date = $_POST['date_'.$productId];
                  $time = $_POST['time_'.$productId];
                  $quantity = $_POST['quantity_'.$productId];
                  $type = $_POST['product_type_'.$productId];

                  // Combine date and time into a datetime format
                  $datetime = $date . ' ' . $time;

                  // Validate datetime input
                  $now = new DateTime();
                  $three_months = new DateInterval('P3M');
                  $max_date = $now->add($three_months)->format('Y-m-d H:i');

                  if ($datetime < date('Y-m-d H:i') || $datetime > $max_date) {
                    echo "Invalid date/time. Please enter a date/time within the next 3 months from the current date.";
                    break;
                  }

                  // Add product to cart
                  $cart_item = array(
                    'id' => $product_id,
                    'name' => $product_name,
                    'price' => $product_price,
                    'date' => $date,
                    'time' => $time,
                    'quantity' => $quantity,
                    'type' => $type
                  );

                  if(!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                  }

                  $_SESSION['cart'][$product_id] = $cart_item;
                  $email = $_SESSION['email'];

                }
              }
            ?>

            <div class="left">

              <!-- HTML code for displaying the cart -->
              <table>
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price (Rs.)</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Quantity</th>
                    <th>Total (Rs.)</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $total = 0;
                    if(isset($_SESSION['cart'])) {
                      foreach($_SESSION['cart'] as $key => $cart_item) {
                        $product_name = $cart_item['name'];
                        $product_price = $cart_item['price'];
                        $date = $cart_item['date'];
                        $time = $cart_item['time'];
                        $quantity = $cart_item['quantity'];
                        $type = $cart_item['type'];
                        $product_total = $product_price * $quantity;
                        $total += $product_total;
                  ?>
                    <tr>
                      <td><?php echo $product_name ?></td>
                      <td><?php echo $product_price ?></td>
                      <td><?php echo $date ?></td>
                      <td><?php echo $time ?></td>
                      <td><?php echo $quantity ?></td>
                      <td><?php echo $product_total ?></td>
                      <td>
                        <form method="post" action="" class="deletecart">
                          <input type="hidden" name="product_id" value="<?php echo $key ?>">
                          <button type="submit" name="delete_item"><i class="fa fa-minus-circle"></i></button>
                        </form>
                      </td>
                    </tr>
                  <?php
                      }
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr id="total">
                    <td colspan="5"><b>Total</b></td>
                    <td><b><?php echo $total ?></b></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>

              <?php
              
                // Check if the update quantity button was clicked
                if(isset($_POST['update_quantity'])) {
                  $product_id = $_POST['product_id'];
                  $new_quantity = $_POST['quantity'];
                  $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
                }

                // Check if the delete item button was clicked
                if(isset($_POST['delete_item'])) {
                  $product_id = $_POST['product_id'];
                  unset($_SESSION['cart'][$product_id]);
                }
              
              ?>

            </div>

            <div class="right">

              <div class="top">

                <a href="clientrefreshments.php"><button class="enroll">Order More Refreshments!</button></a>
                <a href="clientequipment.php"><button class="enroll">Order More Equipment!</button></a>

              </div>

              <div class="bottom">

              <?php
                // Check if the checkout button was clicked
                if (isset($_POST['checkout'])) {
                  // Insert products to the database
                  if (isset($_SESSION['cart'])) {
                    foreach($_SESSION['cart'] as $cart_item) {
                      $email = $_SESSION['email'];
                      $product_id = $cart_item['id'];
                      $quantity = $cart_item['quantity'];
                      $date = $cart_item['date'];
                      $time = $cart_item['time'];
                      $type = $cart_item['type'];

                      $query = "INSERT INTO orders (email, product_id, quantity, date, time, type) VALUES ('$email', '$product_id', '$quantity', '$date', '$time', '$type')";
                      $result = mysqli_query($linkDB, $query);
                      if(!$result) {
                        echo "Error inserting product to database: " . mysqli_error($linkDB);
                      }
                    }
                  }

                  // Clear the cart
                  unset($_SESSION['cart']);

                  // Redirect to the thank you page
                  echo "<script>window.location.href='clientcheckout.php'; </script>";
                }
              ?>

              <!-- HTML code for the checkout button -->
              <!-- <a href="checkout.php"> -->
                <form method="POST">
                  <button type="submit" name="checkout" class="enroll">Checkout</button>
                </form>
              <!-- </a> -->

              
              </div>

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
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
    <link rel="stylesheet" href="../css/client/clientmyfacilities.css">
 
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

            <h1>My Facilities</h1>

            <div class="content">

            <h3> NOTE: To cancel refreshments ordered you have to cancel it atleast 3 days prior to the order date. </h3>

            <table id="searchtable">
              <tr>
                <td>
                    <form method="post">
                        <input type="text" name="search" class="search" onfocus="(this.type = 'date')" placeholder="Search by Date">
                        <input type="submit" name="go" value="Search" id="searchbtn">
                        <a href="clientmyfacilities.php"><input type="submit" value="reset" id = "resetbtn"></a>
                    </form>
                </td>
              </tr>
            </table>

            <div class="left">

              <h3>Ordered Refreshments</h3>  

              <table class="table">

                  <tr>

                      <th>Date</th>
                      <th>Time</th>
                      <th>Item Name</th>
                      <th>Ordered Quantity</th>
                      <th>Action</th>

                  </tr>
                  
                  <?php
                    if(isset($_POST['go'])) {
                        $search = $_POST['search'];

                    //get the first non-null value (either from the drinks or snacks table) as the itemname.
                    $query = "SELECT o.id, o.date, o.time, COALESCE(d.itemname, s.itemname) AS itemname, o.quantity 
                              FROM orders o
                              LEFT JOIN refreshments_drinks d ON o.product_id = d.itemid AND o.type = 'drink'
                              LEFT JOIN refreshments_snacks s ON o.product_id = s.itemid AND o.type = 'snack'
                              WHERE o.date LIKE '%$search%' AND o.email = '$var' AND (o.type = 'drink' OR o.type = 'snack') AND o.status = 1
                              ORDER BY o.date ASC";

                    } else {
                      $query = "SELECT o.id, o.date, o.time, COALESCE(d.itemname, s.itemname) AS itemname, o.quantity
                                FROM orders o
                                LEFT JOIN refreshments_drinks d ON o.product_id = d.itemid AND o.type = 'drink'
                                LEFT JOIN refreshments_snacks s ON o.product_id = s.itemid AND o.type = 'snack'
                                WHERE o.date >= CURDATE() AND o.email = '$var' AND (o.type = 'drink' OR o.type = 'snack') AND o.status = 1
                                ORDER BY o.date ASC";
                    }

                    $res = mysqli_query($linkDB, $query); 

                      if($res == TRUE) {
                          $count = mysqli_num_rows($res); //calculate number of rows
                          if($count > 0) {
                              while($rows = mysqli_fetch_assoc($res)) {
                                  $id = $rows['id'];
                                  
                                  //calculate the difference between the order date and the current date
                                  $orderDate = strtotime($rows["date"]);
                                  $currentTime = time();
                                  $diff = $orderDate - $currentTime;
                                  $daysDiff = round($diff / (60 * 60 * 24));

                                  //disable the submit button if the order date is less than 3 days from the current date
                                  $disabled = ($daysDiff >= 3) ? '' : 'disabled';
                                  
                                  echo "<tr id='row_$id'>
                                          <td>" . $rows["date"]. "</td>
                                          <td>" . date('H:i', strtotime($rows["time"])). "</td>
                                          <td>" . $rows["itemname"].  "</td>
                                          <td>" . $rows["quantity"]."</td>
                                          <td> <button class='submit-button' onclick='confirmRowData($id)' $disabled><i class='fa fa-trash'></i></button> </td>
                                       </tr>";
                              }
                          } else {
                              echo "0 results";
                          }
                      }
                  ?>

                  
              </table>

              <a href="clientrefreshments.php"><button class="enroll">Order Refreshments</button></a>

            </div>

            <div class="right">

              <h3>Ordered Equipment</h3>                    

              <table class="table">   

                  <tr>

                      <th>Date</th>
                      <th>Time</th>
                      <th>Item Name</th>
                      <th>Ordered Quantity</th>
                      <th>Action</th>
                      
                  </tr>

                  <?php
                        if(isset($_POST['go'])) {
                        $search = $_POST['search'];

                      $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity 
                                FROM orders o
                                LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                WHERE o.date LIKE '%$search%' AND o.email = '$var' AND o.type = 'equipment' AND o.status = 1
                                ORDER BY o.date ASC";
                        
                        } else {
                            $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity 
                                      FROM orders o
                                      LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                      WHERE o.date >= CURDATE() AND o.email = '$var' AND o.type = 'equipment' AND o.status = 1
                                      ORDER BY o.date ASC";
                        }
                          $res = mysqli_query($linkDB, $query); 
                              if($res == TRUE) 
                              {
                                  $count = mysqli_num_rows($res); //calculate number of rows
                                  if($count>0)
                                  {
                                      while($rows=mysqli_fetch_assoc($res))
                                      {
                                          $id=$rows['id'];

                                          //get the current date
                                          $currentDate = date("Y-m-d");

                                          //calculate the difference between the order date and the current date
                                          $orderDate = strtotime($rows["date"]);
                                          $currentDateTime = strtotime($currentDate);
                                          $diff = $orderDate - $currentDateTime;
                                          $daysDiff = round($diff / (60 * 60 * 24));

                                          //disable the row if the order date is less than or equal to the current date
                                          $disabled = ($daysDiff <= 0) ? 'disabled' : '';

                                          echo "<tr id='row__$id'>
                                                  <td>" . $rows["date"]. "</td>
                                                  <td>" . date('H:i', strtotime($rows["time"])). "</td>
                                                  <td>" . $rows["itemname"]. "</td>
                                                  <td>" . $rows["quantity"]. "</td>
                                                  <td><button class='submit-button' onclick='confirmRowData2($id)' $disabled><i class='fa fa-trash'></i></button></td>
                                              </tr>";
                                      }
                                  } else {
                                      echo "0 results";
                                  }
                              }    
                      ?>

              </table>

              <a href="clientequipment.php"><button class="enroll">Order Equipment</button></a>

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

<script>
function confirmRowData(id) {
  // Get the row with the booking data
  var row = document.getElementById('row_' + id);

  // Get the booking data from the row
  var date = row.cells[0].innerHTML;
  var time = row.cells[1].innerHTML;
  var item_name = row.cells[2].innerHTML;
  var ordered_quantity = row.cells[3].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2><p>Order Details:</p><ul><li>Date: ' + date + '</li><li>Time: ' + time + '</li><li>Item: ' + item_name + '</li><li>Ordered Quantity: ' + ordered_quantity + '</li></ul><h4><p>NOTE: We will be only refunding 75% of your payment per each cancellation</p></h4><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the clientcancelfacility.php page
    window.location.href = 'clientcancelfacility.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>

<script>
function confirmRowData2(id) {
  // Get the row with the booking data
  var row = document.getElementById('row__' + id);

  // Get the booking data from the row
  var date = row.cells[0].innerHTML;
  var item_name = row.cells[1].innerHTML;
  var ordered_quantity = row.cells[2].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2><p>Order Details:</p><ul><li>Date: ' + date + '</li><li>Item: ' + item_name + '</li><li>Ordered Quantity: ' + ordered_quantity + '</li></ul><h4><p>NOTE: We will be only refunding 75% of your payment per each cancellation</p></h4><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the clientcancelfacility.php page
    window.location.href = 'clientcancelfacility.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>
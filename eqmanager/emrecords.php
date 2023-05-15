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
    <link rel="stylesheet" href="../css/eqmanager/emrecords.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/emsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/emnavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

            <h1>Records</h1>

            <div class="content">

                <?php
                // Check if a success message is present in the URL
                if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
                    echo "<div id='success-message' class='success-message'>Equipment updated successfully.</div>";
                }
                if(isset($_GET['msg']) && $_GET['msg'] == 'notsuccess') {
                    echo "<div id='notsuccess-message' class='notsuccess-message'>Could not update equipment - Please try again.</div>";
                }
                ?>

                <?php
                // Check if a success message is present in the URL
                if(isset($_GET['mesg']) && $_GET['mesg'] == 'success') {
                    echo "<div id='success-mesg' class='success-message'>Equipment Added Successfully.</div>";
                }
                if(isset($_GET['mesg']) && $_GET['mesg'] == 'notsuccess') {
                    echo "<div id='notsuccess-mesg' class='notsuccess-message'>Could not add equipment - Please try again.</div>";
                }
                if(isset($_GET['mesg']) && $_GET['mesg'] == 'unsuccess') {
                    echo "<div id='unsuccess-mesg' class='notsuccess-message'>Your Item has already been recorded!</div>";
                }
                ?>

                <table id="searchtable">
                        <tr>
                                <form method="POST">
                                    <td>
                                        <input type="text" placeholder="Item Name.." name="search" class="search">
                                    </td>
                                    <td>
                                        <input type="submit" name="go" value="Search" class="searchbtn" id="searchbtn">
                                    </td>
                                    <td>
                                        <a href="emrecords.php"><input type="submit" value="reset" id = "resetbtn"></a>
                                    </td>    
                                </form>
                        </tr>
                    </table>

            <div class="left">

                <table class="table">

                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price (Rs)</th>
                        <th>Action</th>
                    </tr>

                    <?php

                        if(isset($_POST['go'])){

                            $search = $_POST['search'];
                            $query = "SELECT * FROM equipment WHERE status = 1 AND itemname LIKE '%$search%' ";

                        } else{
                            $query = "SELECT * FROM equipment WHERE status = 1";
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
                                            echo "<tr id='row_$id'>
                                                    <td>" . $rows["itemid"]. "</td>
                                                    <td>" . $rows["itemname"]. "</td>
                                                    <td>" . $rows["quantity"]. "</td>
                                                    <td>" . $rows["price"]. "</td>
                                                    <td> <button class='submit-button' onclick='confirmRowData($id)'><i class='fa fa-trash'></i></button> 
                                                        <button class='update-button' onclick=\"openPopup($id, '" . $rows["itemname"] . "', '" . $rows["quantity"] . "', '" . $rows["price"] . "')\"><i class='fa fa-pencil-square-o'></i></button>
                                                </tr>";

                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                }
                        ?>

                </table>

            </div>

            <div class="right">

                <div class="top">

                    <h3>Add Equipment</h3>

                        <form method="POST" >

                        <?php

                                if (isset($_POST['addequipment'])) {
                                    //Taking HTML Form Data from User
                                    $item_id = mysqli_real_escape_string($linkDB, $_POST['item_id']);
                                    $item_name = mysqli_real_escape_string($linkDB, $_POST['item_name']);
                                    $quantity = mysqli_real_escape_string($linkDB, $_POST['quantity']);
                                    $price = mysqli_real_escape_string($linkDB, $_POST['price']);  

                                    $error_msg = "";

                                    // Validate input
                                    if (empty($item_id) || empty($item_name) || empty($quantity) || empty($price)) {
                                        $error_msg .= "<p>Please fill all fields.</p>";
                                    }

                                    if (!is_numeric($quantity) || !is_numeric($price)) {
                                        $error_msg .= "<p>Quantity and price must be numeric values.</p>";
                                    }

                                    // Validate item_id format
                                    if (!preg_match("/^(Ebdm|Ebsk|Evlb|Etns|Eswm)\d{3}$/", $item_id)) {
                                        $error_msg .= "<p>Invalid item ID format. It should start with Ebdm, Ebsk, Evlb, Etns or Eswm followed by three digits.</p>";
                                    }

                                    if (empty($error_msg)) {

                                        //Check if Item is already exist in the Database

                                        $query = "SELECT * FROM equipment WHERE itemid = '$item_id'";
                                        $result = mysqli_query($linkDB, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            echo "<script>window.location.href='emrecords.php?mesg=unsuccess'; </script>";
                                        } else {
                                            $sql = "INSERT INTO equipment (itemid, itemname, quantity, price) VALUES ('$item_id', '$item_name', '$quantity', '$price')";
                                            $rs = mysqli_query($linkDB, $sql);

                                            if ($rs) {
                                                echo "<script>window.location.href='emrecords.php?mesg=success'; </script>";
                                            } else {
                                                echo "<script>window.location.href='emrecords.php?mesg=notsuccess'; </script>";
                                            }
                                        }
                                    }
                            }
                            ?>

                            <?php
                            
                                if (!empty($error_msg)) {
                                    echo '<div class="error">' . $error_msg . '</div>';
                                }
                            ?>
                    
                            <input type="text" name="item_id" placeholder="Item Id" required> 
                            <input type="text" name="item_name" placeholder="Item Name" required> <br>
                            <input type="number" name="quantity" placeholder="Quantity" required> 
                            <input type="number" name="price" placeholder="Price" required > <br>
                            <input type="submit" name="addequipment" value="Add" class="btn" >
                        
                        </form>

                </div>

                <div class="bottom">

                    <h3>Check Availability</h3>

                    <table >
                        <tr>
                            <form method="post">
                                <td>
                                    <input type="date" name="date" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+3 months')) ?>"
                                        <?php if (isset($date)) { echo "value=\"$date\""; } else { echo "placeholder=\"Select a date\""; } ?>>
                                </td>
                                <td>
                                    <button type="submit" name="submit_date" id="searchbutton" >Submit Date</button>
                                </td>
                                <td>
                                    <a href="emrecords.php"><input type="submit" value="reset" id = "resetbtn"></a>
                                </td>
                            </form>
                        </tr>
                    </table>

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

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price (Rs.)</th>
                                    <th>Available Quantity</th>
                                </tr>
                            </thead>
                            <?php
                                if(isset($_POST['go'])){

                                    $search = $_POST['search'];
                                    $query_equipment = "SELECT * FROM equipment WHERE status = 1 AND itemname LIKE '%$search%' ";
        
                                } else{
                                    $query_equipment = "SELECT * FROM equipment WHERE status = 1";
                                }
                                
                                $result_equipment = mysqli_query($linkDB, $query_equipment);
                                while ($row_equipment = mysqli_fetch_assoc($result_equipment)) {
                                    $productId = $row_equipment['itemid'];
                                    $available_quantity = isset($equipment[$productId]) ? $equipment[$productId] : $row_equipment['quantity'];
                                    ?>
                                    <tr>
                                        <td><?php echo $row_equipment['itemname'] ?></td>
                                        <td><?php echo $row_equipment['price'] ?></td>
                                        <td><?php echo $available_quantity?></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </table>

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


<!--  confirm row data for deletion -->

<script>
function confirmRowData(id) {
  // Get the row with the equipment
  var row = document.getElementById('row_' + id);

  // Get the equipment from the row
  var itemid = row.cells[0].innerHTML;
  var itemname = row.cells[1].innerHTML;
  var quantity = row.cells[2].innerHTML;
  var price = row.cells[3].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Deletion?</h2><p>Equipment Details:</p><ul><li>Item id: ' + itemid + '</li><li>Item Name: ' + itemname + '</li><li>Quantity: ' + quantity + '</li><li>Price: ' + price + '</li></ul><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the emdeleteequipment.php page
    window.location.href = 'emdeleteequipment.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>


<!-- add equipment -->



<script>
// Remove the success message after 3 seconds
setTimeout(function() {
    var successMessage = document.getElementById('success-mesg');
    var notsuccessMessage = document.getElementById('notsuccess-mesg');
    var unsuccessMessage = document.getElementById('unsuccess-mesg');
    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
    if (unsuccessMessage) {
        unsuccessMessage.style.display = 'none';
    }
}, 5000);
</script>


<!-- Popup to update equipment -->
<div id="equipment-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Update Equipment</h2>
        <form action="update_equipment.php" method="post">
            <input type="hidden" id="equipment-id" name="equipment_id">
            <label for="equipment-quantity">Quantity:</label>
            <input type="number" id="equipment-quantity" name="equipment_quantity">
            <label for="equipment-price">Price:</label>
            <input type="number" id="equipment-price" name="equipment_price">
            <input type="submit" value="Update Equipment" class="btn">
        </form>
    </div>
</div>

<script>
    function openPopup(id, itemname, quantity, price) {
        // Set the equipment ID in the hidden input field
        document.getElementById('equipment-id').value = id;

         // Set the existing quantity and price in the input fields
        document.getElementById('equipment-quantity').value = quantity;
        document.getElementById('equipment-price').value = price;

        // Show the popup
        document.getElementById('equipment-popup').style.display = 'block';
    }

    function closePopup() {
        // Hide the popup
        document.getElementById('equipment-popup').style.display = 'none';
    }
</script>

<script>
// Remove the success message after 3 seconds
setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    var notsuccessMessage = document.getElementById('notsuccess-message');
    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
}, 3000);
</script>
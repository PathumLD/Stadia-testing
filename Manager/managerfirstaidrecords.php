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
    <link rel="stylesheet" href="../css/manager.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/managersidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/managernavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

          <div class="content">


            <h1>First-Aid Records</h1>
            <div class="first-aid-search">
              <div class="add-first-aid">
                <div><a href="manageraddfirstaid.php"><i class="fa fa-plus-circle" id="plus" style="font-size:36px;"></i></a></div>
              </div>
              <div>
                <input type="text" name="search" class ="search" placeholder="Item name...">
              </div>
              <div>
                <input type="submit" name="go" value="search" id = "searchbtn">
              </div>
              <div>
                <input type="submit" name="reset" value="reset" id = "resetbtn">
              </div>
            </div>
            
               <!-- <table class="ps">
               <tr>
               <form method="post">
                    <td class="first-aid-search"><a href="manageraddfirstaid.php"><i class="fa fa-plus-circle" id="plus" style="font-size:36px;"></i></a></td>
                    <td ><input type="text" name="search" class ="search" placeholder="Item name..."></td>
                    <td><input type="submit" name="go" value="search" id = "searchbtn"></td>
                    <td><input type="submit" name="reset" value="reset" id = "resetbtn"></td>
                </form>
                </tr>
            </table> -->
            



            <div class = "scroll">

            <table class="table">

                <tr>

                <th>First Aid Item Id</th>
                <th>First Aid Item Name</th>
                <th>Quantity</th>
                <th>Action</th>

                </tr>
 <?php

if (!$linkDB) {
  die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['go'])) {
  $search = $_POST['search'];
} else {
  $search = null;
}

if ($search) {
  $query = "SELECT * FROM first_aid WHERE item_name LIKE '%$search%'";
} elseif ($search) {
  $query = "SELECT * FROM first_aid WHERE item_id LIKE '%$search%'";
} else {
  $query = "SELECT * FROM first_aid";
}

    $query = "SELECT * FROM first_aid WHERE status = 1 ";
    $res = mysqli_query($linkDB, $query); 
    if($res == TRUE) 
             {
                $count = mysqli_num_rows($res); //calculate number of rows
                if($count>0)
                {
                    while($rows=mysqli_fetch_assoc($res))
                    {
                        $id=$rows['item_id'];
                    
                    echo "<tr id = 'row_$id'>
                                <td>" . $rows["item_id"]. "</td>
                                <td>" . $rows["item_name"]. "</td>
                                <td>" . $rows["quantity"]. "</td>
                                <td> <button class='submit-button' onclick='confirmRowData($id)'><i class='fa fa-trash'></i></button> 
                                <button class='update-button' onclick=\"openPopup('" . $rows["item_id"] . "', '" . $rows["item_name"] . "', '" . $rows["quantity"] . "')\">
                                <i class='fa fa-pencil-square-o'></i></button> 
                                
                                
                                
                    </tr>";

                                
                            
                            
                    }
                }else{
                  echo "0 results";
                }    

            }  
?>
                
                

            </table>

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
  var item_id = row.cells[0].innerHTML;
  var item_name = row.cells[1].innerHTML;
  var quantity = row.cells[2].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Deletion of the First Aid Item?</h2><p>Order Details:</p><ul><li>Item ID: ' + item_id + '</li><li>Item Name: ' + item_name + '</li><li>Quantity: ' + quantity + '</li></ul><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the clientcancelequipment.php page
    window.location.href = 'managerdismissfirstaid.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>

<!-- Popup to update first aid records -->
<div id="firstaid-popup" class="popup_u">
    <div class="popup_u-content">
        <span class="close_u" onclick="closePopup()">&times;</span>
        <h2>Update First-Aid Records</h2>
        <form action="updatefirstaid.php" method="post">
               
               <input type="hidden" id="item_id" name="item_id">
               <label for="item_name">Item Name:</label>
               <input type="text" id="item_name" name="item_name" class="input-field">
               <label for="quantity">Quantity:</label>
               <input type="text" id="quantity" name="quantity" class="input-field">
               <input type="submit" value="Update First-Aid Records" class="btn">
        </form>

    </div>
</div>

<script>
    function openPopup(item_id, item_name, quantity) {
        // Set the complaint ID in the hidden input field
        document.getElementById('item_id').value = item_id;

         // Set the existing subject and details in the input fields
         document.getElementById('item_id').value = item_id;
        document.getElementById('item_name').value = item_name;
        document.getElementById('quantity').value = quantity;

        // Show the popup
        document.getElementById('firstaid-popup').style.display = 'block';
    }

    function closePopup() {
        // Hide the popup
        document.getElementById('firstaid-popup').style.display = 'none';
    }
</script>
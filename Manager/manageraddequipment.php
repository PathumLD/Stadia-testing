<?php session_start(); ?>
<!-- <?php include("../linkDB.php"); //database connection function ?> -->


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


            <h1>Add Equipment</h1>

            <div class="form">

                <form method="POST" action="">
            
                    <input type="id" name="item_id" placeholder="Item Id" > <br><br>
                    <input type="name" name="item_name" placeholder="Item Name" > <br><br>
                    <input type="quant" name="quantity" placeholder="Quantity" > <br><br>
                    <input type="pri" name="price" placeholder="Price" > <br><br>
                    <input type="submit" name="submit" value="Add" class="addbtn" >
                
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

<?php
// $error = "";
if (isset($_POST['submit'])) {

  // Database Link
  include('linkDB.php');

  //Taking HTML Form Data from User
  $item_id = $_POST['item_id'];
  $item_name = $_POST['item_name'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];  

  $sql = "INSERT INTO equipment (itemid,itemname,quantity,price) VALUES ('$item_id', '$item_name', '$quantity', '$price')";
  $rs = mysqli_query($linkDB, $sql);

  //if ($rs) {
  //header("location : viewequipment.php");

  if ($rs) {
    
    //header("location : viewequipment.php");
    echo "<script>window.location.href='http://localhost/Stadia-reawakening-main/Manager/managerequipmentrecords.php'; </script>";

  }
}
      
   //Check if Item is already exist in the Database

    // $query = "SELECT ItemId FROM addequipment WHERE ItemId = '$ItemId'";
    // $result = mysqli_query($linkDB, $sql);
    // if (mysqli_num_rows($result) > 0) {
    //     $error .="<p>Your Item has been recorded already!</p>";
    // } else {
    //     $sql = "INSERT INTO addequipment (ItemId, Itemname, Quantity) VALUES ('$ItemId','$Itemname','$Quantity')";

    //     //header("Location: addequipment.php");  
    // }
 
?>











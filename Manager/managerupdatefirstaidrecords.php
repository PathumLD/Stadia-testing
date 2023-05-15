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


            <h1>Update First-Aid</h1>

            <div class="form">

                <form method="POST" action="">
            
                    <input type="id" name="item_id" placeholder="Item Id" > <br><br>
                    <input type="name" name="item_name" placeholder="Item Name" > <br><br>
                    <input type="quant" name="quantity" placeholder="Quantity" > <br><br>
                    <input type="submit" name="Save" value="Save" class="btn">
                
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
    include("../linkDB.php");

    if (isset($_POST['update'])) {
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $quantity = $_POST['quantity'];

        $sql = "UPDATE first_aid SET item_name='$item_name', quantity='$quantity' WHERE item_id=$id";

        $res = mysqli_query($linkDB, $sql);

        if ($res == TRUE) {
            header('location: managerfirstaidrecords.php');
        } else {
            echo "Error updating data: " . mysqli_error($linkDB);
        }
    }
?>



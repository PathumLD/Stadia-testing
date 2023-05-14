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

                <table id="searchtable">
                        <tr>
                            <td>

                                <form method="POST">
                                
                                    <input type="text" placeholder="Item Name.." name="search" class="search">
                                    <input type="submit" name="go" value="go" class="searchbtn" id="searchbtn">
                                    <a href="emrecords.php"><input type="submit" value="reset" id = "resetbtn"></a>
                                    
                                </form>

                            </td>
                        </tr>
                    </table>

            <div class="left">

                <table class="table">

                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>

                    <?php

                        if(isset($_POST['go'])){

                            $search = $_POST['search'];

                            $query = "SELECT * FROM equipment WHERE itemname LIKE '%$search%' ";
                            $res = mysqli_query($linkDB, $query); 
                                if($res == TRUE) 
                                {
                                    $count = mysqli_num_rows($res); //calculate number of rows
                                    if($count>0)
                                    {
                                        while($rows=mysqli_fetch_assoc($res))
                                        {
                                            echo "<tr>
                                                    <td>" . $rows["itemid"]. "</td>
                                                    <td>" . $rows["itemname"]. "</td>
                                                    <td>" . $rows["quantity"]. "</td>
                                                    <td>" . $rows["price"]. "</td>
                                                    <td> </td>
                                                </tr>";

                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                }
                        }
                        else{
                        $query = "SELECT * FROM equipment ";
                        $res = mysqli_query($linkDB, $query); 
                                if($res == TRUE) 
                                {
                                    $count = mysqli_num_rows($res); //calculate number of rows
                                    if($count>0)
                                    {
                                        while($rows=mysqli_fetch_assoc($res))
                                        {
                                            echo "<tr>
                                                    <td>" . $rows["itemid"]. "</td>
                                                    <td>" . $rows["itemname"]. "</td>
                                                    <td>" . $rows["quantity"]. "</td>
                                                    <td>" . $rows["price"]. "</td>
                                                    <td> </td> 
                                                </tr>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                }    
                            }      
                        ?>

                </table>

            </div>

            <div class="right">

                <div class="top">

                    <h3>Add Equipment</h3>

                        <form method="POST" >
                    
                            <input type="text" name="item_id" placeholder="Item Id" > 
                            <input type="text" name="item_name" placeholder="Item Name" > <br>
                            <input type="number" name="quantity" placeholder="Quantity" > 
                            <input type="number" name="price" placeholder="Price" > <br>
                            <input type="submit" name="addequipment" value="Add" class="addbtn" >
                        
                        </form>

                </div>

                <div class="bottom">

                    <h3>Check Availability</h3>

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

<?php
if (isset($_POST['addequipment'])) {

  //Taking HTML Form Data from User
  $item_id = $_POST['item_id'];
  $item_name = $_POST['item_name'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];  

    //Check if Item is already exist in the Database
    $query = "SELECT * FROM equipment WHERE itemid = '$item_id'";
    $result = mysqli_query($linkDB, $sql);
    if (mysqli_num_rows($result) > 0) {
       echo "<p>Your Item has been recorded already!</p>";
    } else {
        $sql = "INSERT INTO equipment (itemid,itemname,quantity,price) VALUES ('$item_id', '$item_name', '$quantity', '$price')";
        $rs = mysqli_query($linkDB, $sql);

        if ($rs) {
            echo "<script>window.location.href='emprecords.php'; </script>";
        }
            }
}
?>
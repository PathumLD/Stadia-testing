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

            

            <h1>View Orders - Refreshments</h1>

            <table class="ps">
                <tr><td>    </td></tr>
               <tr><td> <form method="post">
                    <input type="text" name="search" class ="search" placeholder="Client Name...">
                    <input type="submit" name="go" value="search" id = "searchbtn">
                    <input type="submit" name="reset" value="reset" id = "resetbtn">
                </form></td></tr>
            </table>

            <table class="table">

                <tr>


                <th>Date</th>
                <th>Product</th>
                <th>Name</th>
                <th>Email</th>
                <th>Show Details</th>


                </tr>

                <?php
    $query = "SELECT o.product_id, o.id, o.date, CONCAT(u.fname, ' ', u.lname) AS name, u.email
    FROM orders o
    INNER JOIN users u ON o.email = u.email
    WHERE (o.type = 'snacks' OR o.type = 'drinks') AND o.status = 1;";
    $res = mysqli_query($linkDB, $query); 
    if($res == TRUE) 
    {
        $count = mysqli_num_rows($res); //calculate number of rows
        if($count > 0)
        {
            while($rows = mysqli_fetch_assoc($res))
            {
                $date = $rows['date'];
                $product_id = $rows['product_id'];
                $name = $rows['name'];
                $email = $rows['email'];
                $id = $rows['id'];
                                          
                echo "<tr>
                          <td>$date</td>
                          <td>$product_id</td>
                          <td>$name</td>
                          <td>$email</td>
                          <td><a href='managervieworderdetailsrefreshments.php?id=$id'>View</a></td>
                          
                      </tr>";
            }
        }    
    }  
?> 


            </table>

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
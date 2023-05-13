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
    <link rel="stylesheet" href="../css/eqmanager.css">
 
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

            <h1>Available Equipment</h1>

            <div class="content">

            <form method="POST">
            
                    <input type="date" name="dt" >
                    <input type="submit" name="go" value="go" class="searchbtn">
                
                </form>

            <table class="table">

                <tr>
                    <th>Date</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Available</th>
                </tr>

                <?php

                    if(isset($_POST['go'])){

                        $search = $_POST['search'];

                        $query = "SELECT * FROM equipment_orders WHERE itemname LIKE '%$search%' ";
                        $res = mysqli_query($linkDB, $query); 
                            if($res == TRUE) 
                            {
                                $count = mysqli_num_rows($res); //calculate number of rows
                                if($count>0)
                                {
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        echo "<td><td>" . $rows["date"]. "</td><td>" . $rows["ccid"]. "</td><td>" . $rows["itemid"]. "</td><td>"  . $rows["itemname"].  "</td></td>"   . $rows["quantity"].  "</td></tr>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            }
                    }
                    else{
                    $query = "SELECT * FROM equipment_orders ";
                    $res = mysqli_query($linkDB, $query); 
                            if($res == TRUE) 
                            {
                                $count = mysqli_num_rows($res); //calculate number of rows
                                if($count>0)
                                {
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        echo "<td><td>" . $rows["date"]. "</td><td>" . $rows["ccid"]. "</td><td>" . $rows["itemid"]. "</td><td>"  . $rows["itemname"].  "</td></td>"   . $rows["quantity"]. "</td><td>"  . $rows["available"].  "</td></tr>";
                                    }
                                } else {
                                    echo "0 results";
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
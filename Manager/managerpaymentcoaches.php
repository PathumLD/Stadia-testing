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


            <h1>Payments - Coaches</h1>

            <table class="table">

                <tr>

                <th>Class Id</th>
                <th>Month</th>
                <th>Total Students</th>
                <th>Payments done by</th>
                <th>Amount Due</th>
                <th>Pay now</th> 

                </tr>

                <?php
                    $query = "SELECT * FROM manager_payments_coaches ";
                    $res = mysqli_query($linkDB, $query); 
                    if($res == TRUE) 
                            {
                                $count = mysqli_num_rows($res); //calculate number of rows
                                if($count>0)
                                {
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        $class_id=$rows['class_id'];
                                        $month=$rows['month'];
                                        $total_students=$rows['total_students'];
                                        $payments_done_by=$rows['payments_done_by'];
                                        $amount_due=$rows['amount_due'];
                                    ?>
                                    <tr>
                                    <td><?php echo $class_id; ?> </td>
                                    <td><?php echo $month; ?></td>
                                    <td><?php echo $total_students; ?></td>
                                    <td><?php echo $payments_done_by; ?></td>
                                    <td><?php echo $amount_due; ?></td>
                                    <td><a href="paynow.php">Pay Now</td>
                                            </tr>
                                            <?php
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
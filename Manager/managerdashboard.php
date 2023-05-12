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


            <h1>Dashboard</h1>

            <a href="managerchangepassword.php" >Change Password</a>

            <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Booked Slots</div>
            <div class="number">40</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from this week</span>
            </div>
          </div>
          <i class='bx bx-cart-alt cart'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Remaining Slots</div>
            <div class="number">20</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from this week</span>
            </div>
          </div>
          <i class='bx bxs-cart-add cart two'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Verified Slots</div>
            <div class="number">25</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from this week</span>
            </div>
          </div>
          <i class='bx bx-cart cart three'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Cancel Slots</div>
            <div class="number">15</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from this week</span>
            </div>
          </div>
          <i class='bx bx-cart cart three'></i>
        </div>
      </div>
    </div>



    </div>

    <div class="box">
      <div class="right-side">
        <h1>Users of the System</h1>


        <?php
        // Query to retrieve the logged in users and their types
        $sql = "SELECT emname, type FROM users  ORDER BY type";

        // Execute the query
        $result = mysqli_query($linkDB, $sql);

        // Check if there are any results
        if (mysqli_num_rows($result) > 0) {
          // Start the table
          echo "<table>";
          echo "<tr><th>#</th><th>Name</th><th>Type</th></tr>";

          // Initialize the counter variable
          $i = 1;

          // Loop through the results and display them in the table
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $row['emname'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "</tr>";
            $i++;
          }

          // End the table
          echo "</table>";
        } else {
          // Display a message if there are no results
          echo "No users currently logged in.";
        }

        // Close the database connection
        mysqli_close($linkDB);

        ?>
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
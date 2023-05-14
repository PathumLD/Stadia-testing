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
    <link rel="stylesheet" href="../css/coach/coachnotifications.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.js"></script>
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/coachsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/coachnavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

          <div class="content">

            <?php $var = $_SESSION['email']; ?>

            <h1>Notification</h1>

            <form method="post">
                <div class="container">
                    <?php if (!empty($error2))
                        echo "<div class='error'>$error2</div>"; ?>
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION["email"])) {
                        // Get the email of the logged in user
                        $email = $_SESSION["email"];

                        // Query the notifications table for the specified email address
                        $query = "SELECT * FROM notifications WHERE email = '$email' AND is_read = 0";
                        $result = mysqli_query($linkDB, $query);

                        // Check if there are any notifications for the current user
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table'>";
                            echo "<thead>
                                    <tr>
                                      <th>Message</th>
                                      <th>Date</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>";
                            echo "<tbody>";
                            // Loop through the query result and display the notifications in a table
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                echo "<tr id='row_$id'>";
                                echo "<td>" . $row["message"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "<td><a href='deletenotifications.php?id=$id;'><i class='fa fa-trash'></i></a>";
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            $error2 = "No notifications found.";
                        }
                    } else {
                        $error2 = "Please log in to view your notifications.";
                    }
                    ?>

            </form>
            
</body>
</html>

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
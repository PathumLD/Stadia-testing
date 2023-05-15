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
    <link rel="stylesheet" href="../css/client/notifications.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/clientsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/navbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

                <?php $var = $_SESSION['email']; ?>

                <h1>My Notifications</h1>

                <div class="content">

                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>     

                        <?php 
                            // Get the email of the logged in user
                            $email = $_SESSION["email"];

                            // Query the notifications table for the specified email address
                            $query = "SELECT * FROM notifications WHERE email = '$email' AND is_read = 0";
                            $result = mysqli_query($linkDB, $query);

                            // Check if there are any notifications for the current user
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through the query result and display the notifications in a table
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    echo "<tr id='row_$id'>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["message"] . "</td>";
                                    echo "<td>" . $row["created_at"] . "</td>";
                                    echo "<td><button class='update-button' onclick=\"openPopup($id)\"><i class='fa fa-trash'></i></button></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<i class='fa fa-bell-slash'></i>";
                            }
                        
                        ?>

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

<!-- Popup to delete notification -->
<div id="notification-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Confirm Deletion</h2>
        <form action="deletenotifications.php" method="post">
            <input type="hidden" id="notification-id" name="notification_id">

            <input type="submit" value="Delete notification" class="btn">
        </form>
    </div>
</div>

<script>
    function openPopup(id) {
        // Set the notification ID in the hidden input field
        document.getElementById('notification-id').value = id;

        // Show the popup
        document.getElementById('notification-popup').style.display = 'block';
    }

    function closePopup() {
        // Hide the popup
        document.getElementById('notification-popup').style.display = 'none';
    }
</script>
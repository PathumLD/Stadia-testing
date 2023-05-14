<div class="sidebar-button">

        <i class="fa fa-bars sidebarBtn" ></i>
        <span class="hello">
            

            <?php echo "Hello Admin"; ?>

        </span>
    </div>

    <div class="date-time">

          <div class="date">

              <span id="daynum">00</span> -
              <span id="dayname">Day</span> 
              <span id="month">Month</span>
              <span id="year">Year</span>

          </div>

          <div class="time">

              <span id="hour">00</span>:
              <span id="minutes">00</span>:
              <span id="seconds">00</span>
              <span id="period">AM</span>

          </div>
    </div>
        
    <div class="profile-details">

       

            <i style='color:white;' class='fa fa-bell'><a href='adminnotifications.php'><?php
            // Check if the user is logged in
            if (isset($_SESSION["email"])) {
                // Get the email of the logged in user
                $email = $_SESSION["email"];

                // Query the notifications table for the specified email address
                $query = "SELECT COUNT(*) as count FROM notifications WHERE email = '$email' AND is_read = 0 ";
                $result = mysqli_query($linkDB, $query);

                // Get the notification count
                $row = mysqli_fetch_assoc($result);
                $notification_count = $row["count"];

                // Display the notification count alongside the notification icon
                echo "<div class='notification-icon' style=\"margin-top: -39px; margin-bottom: -5px; font-weight: bold;\">";

                if ($notification_count > 0) {
                    echo  "<span class='notification-count' style='color:red;'>$notification_count</span>";
                }
                echo "</div>";
            }
            ?> </i>
        </a>
        <img src="../images/profile.jpg" alt="">
        
        </div>

    
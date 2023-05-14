<div class="sidebar-button">

<i class="fa fa-bars sidebarBtn" ></i>
        <span class="hello">
<?php

    $var = $_SESSION['email'];

    // Execute the query to retrieve the first name of the user with the specified email address
    
    $sql = "SELECT username FROM adminuser WHERE email = '".$var."'";
    $result = mysqli_query($linkDB, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the results and store the first name in a variable
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $username = $row["username"];
            }
        }
    } else {
        // Display an error message if the query failed
        echo "Error: " . mysqli_error($linkDB);
    }

?>

            <?php echo "Hello $username "; ?>

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

        <a href='suppliernotifications.php'><i style='color:white;' class='fa fa-bell'></i></a>
        <img src="../images/profile.jpg" alt="">
        
      </div>
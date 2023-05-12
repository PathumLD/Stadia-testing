<div class="sidebar-button">

        <i class="fa fa-bars sidebarBtn" ></i>
        <span class="hello">
            <?php 

                // session_start();

                $var = $_SESSION['email'];

                $sql = "SELECT fname FROM users WHERE email = '".$var."'";
                $result = $linkDB->query($sql);

                            if ($result-> num_rows>0){
                                while($row = $result->fetch_assoc()){
                                $name=$row["fname"];
                                }
                            }
            ?>

            <?php echo "Hello $name "; ?>

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

        <a href='clientcart.php'><i style='color:white;' class='fa fa-shopping-cart' ></i></a>
        <a href='clientnotifications.php'><i style='color:white;' class='fa fa-bell'></i></a>
        
        <?php 
    
    // Retrieve the image from the database
    $folder = "../img/";
    $result = mysqli_query($linkDB, "SELECT * FROM users WHERE email = '".$var."'");
    $row = mysqli_fetch_array($result);
    $filename = $row['dp'];

    if($filename != null) {
      // Display the image on the web page
      echo '<img src="' . $folder . $filename . '" alt ="dp">';
      } else {
      echo '<img src="../images/profile.jpg"> ' ;
      }
    
    ?>
        
      </div>
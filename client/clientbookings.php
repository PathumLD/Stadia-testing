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
    <link rel="stylesheet" href="../css/client/clientbookings.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     
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

            <h1>My Bookings</h1>

            <div class="content">

                <table id="searchtable">
                <tr>
                    <td>
                        <form method="post">
                            <input type="text" name="search" class="search" onfocus="(this.type = 'date')" placeholder="Search by Date">
                            <input type="submit" name="go" value="Search" id="searchbtn">
                        </form>
                    </td>
                    <td>
                        <form method="post">
                                <select name="court_search" class="search" id="disable">
                                    <option value="" disabled selected>Search by Court</option>
                                    <option value="Badminton 1">Badminton 1</option>
                                    <option value="Badminton 2">Badminton 2</option>
                                    <option value="Basketball">Basketball</option>
                                    <option value="Volleyball">Volleyball</option>
                                    <option value="Tennis">Tennis</option>
                                    <option value="Swimming">Swimming</option>
                                </select>
                            <input type="submit" name="go2" value="Search" id="searchbtn">
                            <a href="clientbookings.php"><input type="submit" value="reset" id = "resetbtn"></a>
                        </form>
                    </td>
                </tr>
                </table>

                <div class="left">

                    <table class="table">

                        <tr>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Court</th>   
                        </tr>

                        <?php
                            if(isset($_POST['go']) || isset($_POST['go2'])){
                                $date = isset($_POST['search']) ? $_POST['search'] : '';
                                $court = isset($_POST['court_search']) ? $_POST['court_search'] : '';

                                $whereClause = "WHERE `start_event` >= CURRENT_DATE AND `email` = '".$var."' ";

                                if (!empty($date)) {
                                    $whereClause .= "AND DATE(`start_event`) = '".$date."' ";
                                }

                                if (!empty($court)) {
                                    $whereClause .= "AND `sport` = '".$court."' ";
                                }

                                $query = "SELECT start_event, end_event, sport FROM (
                                            SELECT slots_badminton1.*, 'Badminton 1' as sport FROM slots_badminton1
                                            UNION SELECT slots_badminton2.*, 'Badminton 2' as sport FROM slots_badminton2
                                            UNION SELECT slots_basketball.*, 'Basketball' as sport FROM slots_basketball
                                            UNION SELECT slots_volleyball.*, 'Volleyball' as sport FROM slots_volleyball
                                            UNION SELECT slots_tennis.*, 'Tennis' as sport FROM slots_tennis
                                            UNION SELECT slots_swimming.*, 'Swimming' as sport FROM slots_swimming
                                        ) as events ".$whereClause."ORDER BY start_event ASC";

                                $result = mysqli_query($linkDB, $query);

                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $start_time = date('h:i A', strtotime($row["start_event"]));
                                        $end_time = date('h:i A', strtotime($row["end_event"]));
                                        $date = date('Y-m-d', strtotime($row["start_event"]));
                                        echo "<tr>
                                                <td>" . $date . "</td>
                                                <td>" . $start_time . "</td>
                                                <td>" . $end_time . "</td>
                                                <td>" . $row["sport"] . "</td>
                                            </tr>";
                                    }
                                }
                            }
                            else {
                                // No search buttons were clicked, so retrieve all data
                                $query = "SELECT start_event, end_event, sport FROM (
                                            SELECT slots_badminton1.*, 'Badminton 1' as sport FROM slots_badminton1
                                            UNION SELECT slots_badminton2.*, 'Badminton 2' as sport FROM slots_badminton2
                                            UNION SELECT slots_basketball.*, 'Basketball' as sport FROM slots_basketball
                                            UNION SELECT slots_volleyball.*, 'Volleyball' as sport FROM slots_volleyball
                                            UNION SELECT slots_tennis.*, 'Tennis' as sport FROM slots_tennis
                                            UNION SELECT slots_swimming.*, 'Swimming' as sport FROM slots_swimming
                                        ) as events WHERE `start_event` >= CURRENT_DATE AND `email` = '".$var."' ORDER BY start_event ASC";

                                $result = mysqli_query($linkDB, $query);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $start_time = date('h:i A', strtotime($row["start_event"]));
                                        $end_time = date('h:i A', strtotime($row["end_event"]));
                                        $date = date('Y-m-d', strtotime($row["start_event"]));
                                        echo "<tr>
                                        <td>" . $date . "</td>
                                        <td>" . $start_time . "</td>
                                        <td>" . $end_time . "</td>
                                        <td>" . $row["sport"] . "</td>
                                        </tr>";
                                    }
                                }
                            }
                            
                            ?>

                    </table>

                </div>

                <div class="right">

                    <div class="top">

                        <h3>Book Slots</h3>

                        <h4><b>Book a slot now!</b><br><br>
                            Our facility offers a wide range of activities to keep you moving, from badminton, basketball and volleyball to tennis and swimming. Book a slot at our stadium today and take your fitness to the next level!</h4>
                        <a href="clientslotsbadminton1.php"><button class="enroll">Badminton</button></a>
                        <a href="clientslotsbasketball.php"><button class="enroll">Basketball</button></a><br>
                        <a href="clientslotsvolleyball.php"><button class="enroll">Volleyball</button></a>
                        <a href="clientslotstennis.php"><button class="enroll">Tennis</button></a><br>
                        <a href="clientslotsswimming.php"><button class="enroll sw">Swimming</button></a>

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

<script>
function confirmRowData(id) {
  // Get the row with the booking data
  var row = document.getElementById('row_' + id);

  // Get the booking data from the row
  var date = row.cells[0].innerHTML;
  var time = row.cells[1].innerHTML;
  var court = row.cells[2].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2><p>Booking Details:</p><ul><li>Date: ' + date + '</li><li>Time: ' + time + '</li><li>Court: ' + court + '</li></ul><h4><p>NOTE: We will be only refunding 75% of your payment per each cancellation</p></h4><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the clientcancelclass.php page
    window.location.href = 'clientcancelbooking.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>
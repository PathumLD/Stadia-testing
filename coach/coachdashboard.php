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
    <link rel="stylesheet" href="../css/coach/coachdashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
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

            <h1>Dashboard</h1>

            <div class = "dash1">

                <h2 class="head"> Today's Schedule </h2>

                <table class="table1">

                  <tr>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Sport</th>   
                  </tr>

                  <?php
if (isset($_POST['go']) || isset($_POST['go2'])) {
  $date = isset($_POST['search']) ? $_POST['search'] : '';
  $court = isset($_POST['court_search']) ? $_POST['court_search'] : '';
  $whereClause = "WHERE `email` = '".$var."' AND status IN (1, 2)";
  
  if (!empty($date)) {
    $whereClause .= " AND DATE(`start_event`) = '".$date."'";
  }

  if (!empty($court)) {
    $whereClause .= " AND `sport` = '".$court."'";
  }

  $query = "SELECT MIN(`start_event`) AS min_start, MAX(`end_event`) AS max_end, `sport` FROM (
              SELECT `start_event`, `end_event`, 'Badminton 1' AS `sport` FROM `slots_badminton1`
              UNION SELECT `start_event`, `end_event`, 'Badminton 2' AS `sport` FROM `slots_badminton2`
              UNION SELECT `start_event`, `end_event`, 'Basketball' AS `sport` FROM `slots_basketball`
              UNION SELECT `start_event`, `end_event`, 'Volleyball' AS `sport` FROM `slots_volleyball`
              UNION SELECT `start_event`, `end_event`, 'Tennis' AS `sport` FROM `slots_tennis`
              UNION SELECT `start_event`, `end_event`, 'Swimming' AS `sport` FROM `slots_swimming`
            ) AS `events` ".$whereClause." GROUP BY `sport` ORDER BY `min_start` ASC";

  $result = mysqli_query($linkDB, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $start_time = date('h:i A', strtotime($row["min_start"]));
      $end_time = date('h:i A', strtotime($row["max_end"]));
      echo "<tr> <td>" . $start_time . " - " . $end_time . "</td> <td>" . $row["sport"] . "</td> </tr>";
    }
  }
} else {
  // No search buttons were clicked, so retrieve all data
  $query = "SELECT MIN(`start_event`) AS min_start, MAX(`end_event`) AS max_end, `sport` FROM (
              SELECT `start_event`, `end_event`, 'Badminton 1' AS `sport` FROM `slots_badminton1`
              UNION SELECT `start_event`, `end_event`, 'Badminton 2' AS `sport` FROM `slots_badminton2`
              UNION SELECT `start_event`, `end_event`, 'Basketball' AS `sport` FROM `slots_basketball`
              UNION SELECT `start_event`, `end_event`, 'Volleyball' AS `sport` FROM `slots_volleyball`
              UNION SELECT `start_event`, `end_event`, 'Tennis' AS `sport` FROM `slots_tennis`
              UNION SELECT `start_event`, `end_event`, 'Swimming' AS `sport` FROM `slots_swimming`
            ) AS `events` WHERE `start_event` >= CURRENT_DATE AND `email` = '".$var."' AND status IN (1, 2) GROUP BY `sport` ORDER BY `min_start` ASC";

  $result = mysqli_query($linkDB, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $start_time = date('h:i A', strtotime($row["min_start"]));
      $end_time = date('h:i A', strtotime($row["max_end"]));
      echo "<tr> <td>" . $start_time . " - " . $end_time . "</td> <td>" . $row["sport"] . "</td> </tr>";
    }
  }
}
?>

                </table>

            </div>

                  <div class = "dash2">
                      
                    <h2 class="head"> Time Table </h2>
                    
                    <table id="table2">

                    <?php
                        $mon = "SELECT * from coach_classes WHERE day = 'Monday' AND email = '".$var."' AND (status = 1 OR status = 2)";
                        $tue = "SELECT * from coach_classes WHERE day = 'Tuesday' AND email = '".$var."' AND (status = 1 OR status = 2)";
                        $wed = "SELECT * from coach_classes WHERE day = 'Wednesday' AND email = '".$var."' AND (status = 1 OR status = 2)";
                        $thu = "SELECT * from coach_classes WHERE day = 'Thursday' AND email = '".$var."' AND (status = 1 OR status = 2)";
                        $fri = "SELECT * from coach_classes WHERE day = 'Friday' AND email = '".$var."' AND (status = 1 OR status = 2)";
                        $sat = "SELECT * from coach_classes WHERE day = 'Saturday' AND email = '".$var."' AND (status = 1 OR status = 2)";
                        $sun = "SELECT * from coach_classes WHERE day = 'Sunday' AND email = '".$var."' AND (status = 1 OR status = 2)";

                        echo "<tr>
                                <th> Monday</th></tr>"; 
                                $result = mysqli_query($linkDB, $mon);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                              <td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }

                          echo "<tr>
                                <th> Tuesday</th></tr>"; 
                                $result = mysqli_query($linkDB, $tue);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                              <td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }

                    echo "<tr>
                                <th> Wednesday</th></tr>"; 
                                $result = mysqli_query($linkDB, $wed);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }

                        echo "<tr>
                                <th> Thursday</th></tr>"; 
                                $result = mysqli_query($linkDB, $thu);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }

                        echo "<tr>
                                <th> Friday</th></tr>"; 
                                $result = mysqli_query($linkDB, $fri);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }

                        echo "<tr>
                                <th> Saturday</th></tr>"; 
                                $result = mysqli_query($linkDB, $sat);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }

                        echo "<tr>
                                <th> Sunday</th></tr>"; 
                                $result = mysqli_query($linkDB, $sun);
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["sport"]. "</td>
                                              <td>" .$row["time"]. "</td>
                                              <td>" .$row["age_group"]. "</td>
                                              <td>" .$row["level"]. "</td>
                                </tr>";
                                }
                          }   
                    ?>

                </table>

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
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

            <div class="slot1">

                  <h3> Slot 01 </h3>

            </div>

            <div class="slot2">

                  <h3> Slot 02 </h3>

            </div>

            <div class="slot3">

                  <h3> Slot 03 </h3>

            </div>

            <div class = "dash1">

                <h2 class="head"> Today's Bookings </h2>

                <table class ="table1">
    <tr>
        <th> Start Time </th>
        <th> End Time </th>
        <th> Sport </th>
    </tr>
    <?php
      $date = date('Y-m-d');
      $whereClause = "WHERE `start_event` >= CURRENT_DATE AND events.email = ? AND DATE(`start_event`) = ?";
      $query = "SELECT MIN(events.start_event) AS start_event, MAX(events.end_event) AS end_event, events.sport, events.email FROM (
                  SELECT slots_badminton1.start_event, slots_badminton1.end_event, 'Badminton 1' as sport, slots_badminton1.email FROM slots_badminton1
                  UNION SELECT slots_badminton2.start_event, slots_badminton2.end_event, 'Badminton 2' as sport, slots_badminton2.email FROM slots_badminton2
                  UNION SELECT slots_basketball.start_event, slots_basketball.end_event, 'Basketball' as sport, slots_basketball.email FROM slots_basketball
                  UNION SELECT slots_volleyball.start_event, slots_volleyball.end_event, 'Volleyball' as sport, slots_volleyball.email FROM slots_volleyball
                  UNION SELECT slots_tennis.start_event, slots_tennis.end_event, 'Tennis' as sport, slots_tennis.email FROM slots_tennis
                  UNION SELECT slots_swimming.start_event, slots_swimming.end_event, 'Swimming' as sport, slots_swimming.email FROM slots_swimming
              ) as events ".$whereClause." GROUP BY events.sport ORDER BY events.start_event ASC";
      $stmt = mysqli_prepare($linkDB, $query);
      mysqli_stmt_bind_param($stmt, "ss", $var, $date);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              $start_time = date('h:i A', strtotime($row["start_event"]));
              $end_time = date('h:i A', strtotime($row["end_event"]));
              echo "<tr>
                  <td>" . $start_time . "</td>
                  <td>" . $end_time . "</td>
                  <td>" . $row["sport"] . "</td>
              </tr>";
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
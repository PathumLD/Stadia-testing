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

        $whereClause = "WHERE `start_event` >= CURRENT_DATE AND `start_event` < CURRENT_DATE`email` = '".$var."' ";

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
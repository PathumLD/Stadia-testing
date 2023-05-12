<?php
// Include the database connection file
include("../linkDB.php"); //database connection function 
?>



<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Stadia </title>

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link rel="stylesheet" href="../css/admin.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../include/javascript.php'); ?>
    <?php include('../include/styles.php'); ?>
    <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      text-align: left;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>

</head>

<body onload="initClock()">

    <div class="sidebar">

        <?php include('../include/adminsidebar.php'); ?>

    </div>

    <section class="home-section">

        <nav>

            <?php include('../include/adminnavbar.php'); ?>

        </nav>

        <div class="home-content">
            <div class="main-content" id="report-content">

                
<table>
<thead>
  <tr>
    <th>Sport</th>
    <th>Coaches</th>
  </tr>
</thead>
<tbody>
  <?php
    $query = "SELECT sport, GROUP_CONCAT(coach) as coaches FROM coach_classes GROUP BY sport";

    $result = $linkDB->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["sport"] . "</td>";
        echo "<td>" . $row["coaches"] . "</td>";
        echo "</tr>";
      }
    } else {
      echo "No results found.";
    }

  ?>
</tbody>
</table>
</div>
</div>

<footer>
            <div class="foot">
                <span>Created By <a href="#">Stadia.</a> | &#169; 2023 All Rights Reserved</span>
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
        dropdown[i].addEventListener("click", function () {
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
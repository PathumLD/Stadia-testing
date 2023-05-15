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
    <link rel="stylesheet" href="../css/manager.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/managersidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/managernavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

          <div class="content">


            <h1>Dashboard</h1>


            <div class = "d-d">
<h4>Complaints to be handled</h4>
<?php
$query = "SELECT COUNT(*) AS row_count FROM complaints WHERE status = '0'";
$query_run = mysqli_query($linkDB, $query);

    // 3. Check for errors
    if (!$query_run) {
        die('Query Error: ' . mysqli_error($linkDB));
    }

    // 4. Retrieve the result
    $result = mysqli_fetch_assoc($query_run);
    $row_count = $result['row_count'];

    // 5. Display the result

    echo '<h1>' . $row_count . '</h1>';
?>

<div class = "d-e">
<h4>Order Requests</h4>
<?php
$query = "SELECT COUNT(*) AS row_count FROM orders WHERE status = '0'";
$query_run = mysqli_query($linkDB, $query);

    // 3. Check for errors
    if (!$query_run) {
        die('Query Error: ' . mysqli_error($linkDB));
    }

    // 4. Retrieve the result
    $result = mysqli_fetch_assoc($query_run);
    $row_count = $result['row_count'];

    // 5. Display the result

    echo '<h1>' . $row_count . '</h1>';
?>


</div>

<div class = "d-h">
<h4>Verification needed - New Class</h4>
<?php
$query = "SELECT COUNT(*) AS row_count FROM coach_classes WHERE status = '0'";
$query_run = mysqli_query($linkDB, $query);

    // 3. Check for errors
    if (!$query_run) {
        die('Query Error: ' . mysqli_error($linkDB));
    }

    // 4. Retrieve the result
    $result = mysqli_fetch_assoc($query_run);
    $row_count = $result['row_count'];

    // 5. Display the result

    echo '<h1>' . $row_count . '</h1>';
?>


</div>

<div class = "d-i">
<h4>Verification needed - Delete Class</h4>
<?php
$query = "SELECT COUNT(*) AS row_count FROM coach_classes WHERE status = '2'";
$query_run = mysqli_query($linkDB, $query);

    // 3. Check for errors
    if (!$query_run) {
        die('Query Error: ' . mysqli_error($linkDB));
    }

    // 4. Retrieve the result
    $result = mysqli_fetch_assoc($query_run);
    $row_count = $result['row_count'];

    // 5. Display the result

    echo '<h1>' . $row_count . '</h1>';
?>
</div>

<div class = "d-j">
<h4>Verification needed - Cancel Class</h4>
<?php
$query = "SELECT COUNT(*) AS row_count FROM request WHERE status = '0'";
$query_run = mysqli_query($linkDB, $query);

    // 3. Check for errors
    if (!$query_run) {
        die('Query Error: ' . mysqli_error($linkDB));
    }

    // 4. Retrieve the result
    $result = mysqli_fetch_assoc($query_run);
    $row_count = $result['row_count'];

    // 5. Display the result

    echo '<h1>' . $row_count . '</h1>';
?>

  </div>

  <div class = "d-b">

<ul>
<h4>Codes: Equipment</h4>
<li><strong>Badminton:</strong> bdm</li>
<li><strong>Basketball:</strong> bsk</li>
<li><strong>Swimming:</strong> swm</li>
<li><strong>Tennis:</strong> tns</li>
<li><strong>Volleyball:</strong> vlb</li>
</ul>

</div>

<div class = "d-c">
<ul>
<h4>Codes: Class Id</h4>
<li><strong>Badminton:</strong> cbdm</li>
<li><strong>Basketball:</strong> cbsk</li>
<li><strong>Swimming:</strong> cswm</li>
<li><strong>Tennis:</strong> ctns</li>
<li><strong>Volleyball:</strong> cvlb</li>
</ul>

</div>

<div class = "d-a">
            <ul>
            <h4> Codes:First-Aid </h4>
            <li>fa</li>
            </ul>

</div>





            <div class = "d-table">

            <table class = "d-table1">


</table>
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
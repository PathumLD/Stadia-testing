<?php session_start(); ?>
<!-- <?php include("../linkDB.php"); //database connection function ?> -->


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


            <h1>Verify New Classes</h1>

            <!-- <form method="post">
    <input type="text" name="search" class ="search" placeholder="Coach Name...">
    <input type="submit" name="go" value="search" id = "searchbtn">
    <a href="managercoaches.php"><input type="submit" name="reset" value="reset" id = "resetbtn"></a>
</form> -->


            <table class="table">

                <tr>

                <th>Id</th>
                <th>Level</th>
                <th>Coach</th>
                <th>Sport</th>
                <th>Time</th>
                <th>Age group</th>
                <th>No of students</th>
                <th>Verify</th>

                </tr>

                <?php


                        // Fetch classes with status=0
                        $sql = "SELECT * FROM coach_classes WHERE status = 0";
                        $result = $linkDB->query($sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["class_id"] . "</td>";
                                echo "<td>" . $row["level"] . "</td>";
                                echo "<td>" . $row["coach"] . "</td>";
                                echo "<td>" . $row["sport"] . "</td>";
                                echo "<td>" . $row["time"] . "</td>";
                                echo "<td>" . $row["age_group"] . "</td>";
                                echo "<td>" . $row["no_of_students"] . "</td>";
                                echo "<td><form method='post'><input type='hidden' name='class_id' value='" . $row["class_id"] . "'><button class='btn-new' type='submit' name='verify'>Verify</button>
                            </form></td>";
                                echo "</tr>";
                            }
                        
                            echo "</table>";
                        } else {
                            echo "No classes to be verified.";
                        }

                        // Verify button logic
                        if (isset($_POST['verify'])) {
                            $class_id = $_POST['class_id'];
                            $sql = "UPDATE coach_classes SET status = 1 WHERE class_id = '$class_id'";
                            mysqli_query($linkDB, $sql);
                        
                        
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
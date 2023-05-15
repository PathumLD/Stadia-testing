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
    <link rel="stylesheet" href="../css/manager/v.css">
 
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

          

                <h1>Class Verification</h1>

            <div class="content">

                
                <div class="activeclasses">
                    
                    <h4> Verify New Classes </h4>

                    <div class = "datatable">

                        <table class="table-v">

                            <tr>

                            
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
                                    $id = $row['id'];
                                    echo "<tr id='row_$id'>
                                            <td>" . $row["level"]. "</td>
                                            <td>" . $row["coach"]. "</td>
                                            <td>" . $row["sport"]. "</td>
                                            <td>" . $row["time"]. "</td>
                                            <td>" . $row["age_group"]. "</td>
                                            <td>" . $row["no_of_students"]. "</td>
                                            <td><button class='update-button' onclick=\"openPopup($id)\"><i class='fa fa-pencil-square-o'></i></button></td>
                                    </tr>";
                                }
                            } else {
                            echo "No classes to be verified";
                        }
                    ?>

</table>

<!-- Popup to insert classid -->
<div id="class-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Verify class</h2>
        <form action="update_class.php" method="post">
            <input type="hidden" id="class-id" name="class_id">
            <label for="class-subject">Class ID</label>
            <input type="text" id="class-subject" name="class_subject">
            <input type="submit" value="Verify class" class="btn">
        </form>
    </div>
</div>

<!-- JavaScript to handle modal popup and form submission -->
<script>
    function openPopup(id) {
        // Set the class ID in the hidden input field
        document.getElementById('class-id').value = id;

        // Show the popup
        document.getElementById('class-popup').style.display = 'block';
    }

    function closePopup() {
        // Hide the popup
        document.getElementById('class-popup').style.display = 'none';
    }
</script>                       
                    
                    </div>

                </div>

                <div class="acceptanceclasses">

                    <h4> Verify Delete Classes </h4>

                    <div class = "frame2">

                        <table class="table2-v">
                            <tr>
                            <th>Class Id</th>
                            <th>Coach</th>
                            <th>Sport</th>
                            <th>Verify</th>
                            </tr>

                            <?php


// Fetch classes with status=0
$sql = "SELECT * FROM coach_classes WHERE status = 2";
$result = $linkDB->query($sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["class_id"] . "</td>";
        echo "<td>" . $row["coach"] . "</td>";
        echo "<td>" . $row["sport"] . "</td>";
        echo "<td><form method='post'><input type='hidden' name='class_id' value='" . $row["class_id"] . "'><button class='btn-new' type='submit' name='verify-d'><i class='fa fa-check' aria-hidden='true'></i></button>
        </form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No classes to be verified.";
}

// Verify button logic
if (isset($_POST['verify-d'])) {
    $class_id = $_POST['class_id'];
    $sql = "UPDATE coach_classes SET status = 3 WHERE class_id = '$class_id'";
    mysqli_query($linkDB, $sql);


}
?>
                        </table>

                    </div>

                </div>
                    
                <div class="cancellationclasses">

                    <h4> Verify Cancel Class request </h4>

                    <div class = "frame2">

                        <table class="table3-v">
                            <tr>
                            <th>Class Id</th>
                            <th>Date</th>
                            <th>Verify</th>
                            </tr>

                            <?php


                            // Fetch classes with status=0
                            $sql = "SELECT * FROM request WHERE status = 0";
                            $result = $linkDB->query($sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["classid"] . "</td>";
                                    echo "<td>" . $row["date"] . "</td>";
                                    echo "<td><form method='post'><input type='hidden' name='classid' value='" . $row["classid"] . "'><button class='btn-new' type='submit' name='verify-c'><i class='fa fa-check' aria-hidden='true'></i></button>
                                    </form></td>";
                                    
                                    echo "</tr>";
                                }

                                echo "</table>";
                            } else {
                                echo "No classes to be verified.";
                            }

                            // Verify button logic
                            if (isset($_POST['verify-c'])) {
                                $classid = $_POST['classid'];
                                $sql = "UPDATE request SET status = 1 WHERE classid = '$classid'";
                                mysqli_query($linkDB, $sql);


                            }
                            ?>

                        </table>

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
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
    <link rel="stylesheet" href="../css/coach/coachclasses.css">
 
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

          <?php $var = $_SESSION['email']; ?>

                <h1>My Classes</h1>

            <div class="content">

                <table class = "searchtable">
                    <tr><td><a href="coachaddnewclass.php" class = "text"><i class="fa fa-plus-circle" id="plus" style="font-size:36px;"></i>        Add Class</a></td>

                        <td>
                            <form method="POST">
                    
                                <select class="search"name="search">
                                <option value="all">All</option>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                                </select>
                                <input type="submit" name="go" value="Search" id="searchbtn">
                                <a href="coachclasses.php"><input type="submit" name="reset" value="reset" id = "resetbtn"></a>
                        
                            </form>
                        </td>
                    </tr>
                </table>
            
                <div class="activeclasses">
                    
                    <h3> Active Classes </h3>

                    <div class = "datatable">

                        <table class="table">

                            <tr>

                                <th> Day </th>
                                <th> Sport </th>
                                <th> Time</th>
                                <th> Age Group </th>
                                <th> Level </th>
                                <th> No. of Students </th>
                                <th> Months </th>
                                <th> Student Details </th>
                                <th> Action </th>

                            </tr>

                            <?php

                                if(isset($_POST['go'])) {
                                    $search = $_POST['search'];
                                } else {
                                    $search = null;
                                }

                                // Check if the user is logged in
                                if(isset($_SESSION['email'])) {
                                    // Retrieve the logged-in email address
                                    $email = $_SESSION['email'];
                                    
                                    if($search == 'all') {
                                        $query = "SELECT * FROM coach_classes WHERE email='$email'";
                                    } else {
                                        $query = "SELECT * FROM coach_classes WHERE day LIKE '%$search%' AND email='$email' AND status = '1' OR status = '2'";
                                    }

                                    $res = mysqli_query($linkDB, $query);

                                    if($res == TRUE) {
                                        $count = mysqli_num_rows($res);

                                        if($count > 0) {
                                            while($rows = mysqli_fetch_assoc($res)) {
                                                $id = $rows['id'];

                                                echo "<tr id='row_$id'>  
                                                    <td>" . $rows["day"]. "</td>
                                                    <td>" . $rows["sport"]. "</td>
                                                    <td>" . $rows["time"]. "</td>
                                                    <td>" . $rows["age_group"]. "</td>
                                                    <td>" . $rows["level"]. "</td>
                                                    <td>" . $rows["no_of_students"]. "</td>
                                                    <td>" . $rows["months"]. "</td>
                                                    <td><a href='coachstudentdetails.php?id=$id;'>View</a> </td>
                                                    <td><a href='coachupdateclass.php?id=$id;'><i class='fa fa-edit' id='edit' style='font-size:24px'></i></a>
                                                    
                                                </tr>";
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                    }



                            ?>


                        </table>
                    
                    </div>

                </div>

                <div class="acceptanceclasses">

                    <h3> Pending Acceptances Classes </h3>

                    <div class = "frame2">

                        <table class="table2">
                            <tr>
                                <th> Day </th>
                                <th> Sport </th>
                                <th> Time</th>
                                <th> Age Group </th>
                                <th> Months </th>
                                <th> Status </th>
                            </tr>

                            <?php

                                // Retrieve the logged-in email address
                                $email = $_SESSION['email'];

                                // Build the query to retrieve data from the database
                                $query = "SELECT * FROM coach_classes WHERE email='$email' AND status=0";

                                // Execute the query
                                $res = mysqli_query($linkDB, $query);

                                // Check if any results were returned
                                if($res == TRUE) {
                                    $count = mysqli_num_rows($res);

                                    if($count > 0) {
                                        // Loop through the results and display each row in the table
                                        while($rows = mysqli_fetch_assoc($res)) {
                                            $id = $rows['id'];

                                            if ($rows["status"] == 0) {
                                                echo "<tr id='row_$id'>  
                                                    <td>" . $rows["day"]. "</td>
                                                    <td>" . $rows["sport"]. "</td>
                                                    <td>" . $rows["time"]. "</td>
                                                    <td>" . $rows["age_group"]. "</td>
                                                    <td>" . $rows["months"]. "</td>
                                                    <td> Pending </td>
                                                </tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>0 results</td></tr>";
                                    }
                                }

                            ?>
                        </table>

                    </div>

                </div>
                    
                <div class="cancellationclasses">

                    <h3> Pending Cancellation Classes </h3>

                    <div class = "frame2">

                        <table class="table2">
                            <tr>
                                <th> Day </th>
                                <th> Sport </th>
                                <th> Time</th>
                                <th> Age Group </th>
                                <th> Status </th>
                            </tr>

                            <?php

                                // Retrieve the logged-in email address
                                $email = $_SESSION['email'];

                                // Build the query to retrieve data from the database
                                $query = "SELECT * FROM coach_classes WHERE email='$email' AND status = '2'";

                                // Execute the query
                                $res = mysqli_query($linkDB, $query);

                                // Check if any results were returned
                                if($res == TRUE) {
                                    $count = mysqli_num_rows($res);

                                    if($count > 0) {
                                        // Loop through the results and display each row in the table
                                        while($rows = mysqli_fetch_assoc($res)) {
                                            $id = $rows['id'];

                                            if ($rows["status"] == 2) {
                                                echo "<tr id='row_$id'>  
                                                    <td>" . $rows["day"]. "</td>
                                                    <td>" . $rows["sport"]. "</td>
                                                    <td>" . $rows["time"]. "</td>
                                                    <td>" . $rows["age_group"]. "</td>
                                                    <td> Pending </td>
                                                </tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>0 results</td></tr>";
                                    }
                                }

                                // Close the database connection
                                mysqli_close($linkDB);
                            } else {
                                // Redirect the user to the login page if they're not logged in
                                header("Location: login.php");
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
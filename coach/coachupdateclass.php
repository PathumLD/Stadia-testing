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
    <link rel="stylesheet" href="../css/coach/coachupdateclass.css">
 
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

            <h1> Actions </h1>


            <?php $id = $_GET['id']; ?>

              <?php
              
                  $sql = "SELECT * FROM coach_classes WHERE id = '".$id."'";

                  $result = mysqli_query($linkDB, $sql);
  
                  if($result == TRUE){
                    $count = mysqli_num_rows($result);
                    if($count > 0){
                      while($row = mysqli_fetch_assoc($result)){
                        echo "
                        <table class= 'table'>
                          <th  colspan='6' > Current Status </th>
                            <tr>
                              <td>" . $row["day"]. "</td>
                              <td>" . $row["sport"]. "</td>
                              <td>" . $row["time"]. "</td>
                              <td>" . $row["age_group"]. "</td>
                              <td>" . $row["level"]. "</td>
                              <td>" . $row["no_of_students"]. "</td>
                            </tr> </table>";

                      }
                    }
                  } 

              ?>

                

            </div>

                <div class="update">

                  <h3> Update </h3>

                  <form method="post">
                    <div><br><br>
                      <select name="day" class="drop" required>
                        <option value="" disabled selected>Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                      </select> <br><br>

                      <select name="time" class="drop" required>
                        <option value="" disabled selected>Time Slot</option>
                        <option value="6.00 - 7.00">6.00 - 7.00</option>
                        <option value="7.00 - 8.00">7.00 - 8.00</option>
                        <option value="8.00 - 9.00">8.00 - 9.00</option>
                        <option value="9.00 - 10.00">9.00 - 10.00</option>
                        <option value="10.00 - 11.00">10.00 - 11.00</option>
                        <option value="11.00 - 12.00">11.00 - 12.00</option>
                        <option value="12.00 - 13.00">12.00 - 13.00</option>
                        <option value="13.00 - 14.00">13.00 - 14.00</option>
                        <option value="14.00 - 15.00">14.00 - 15.00</option>
                        <option value="15.00 - 16.00">15.00 - 16.00</option>
                        <option value="16.00 - 17.00">16.00 - 17.00</option>
                        <option value="17.00 - 18.00">17.00 - 18.00</option>
                        <option value="18.00 - 19.00">18.00 - 19.00</option>
                        <option value="19.00 - 20.00">19.00 - 20.00</option>
                        <option value="20.00 - 21.00">20.00 - 21.00</option>
                        <option value="21.00 - 22.00">21.00 - 22.00</option>
                      </select> <br><br>

                      <input type="text" class = "input" name="no_of_students" placeholder="No of Students" required> <br><br>


                      <input type="submit" name="submit" value="Update" class="btn">
                    </div>
                  </form>
                  </div>


                  <?php
                      // Check if form is submitted
                      if(isset($_POST['submit'])){

                          // Get form data
                          $day = $_POST['day'];
                          $time = $_POST['time'];
                          $no_of_students = $_POST['no_of_students'];

                          // Prepare SQL statement to update the table
                          $sql = "UPDATE coach_classes SET day = '$day', time = '$time', no_of_students = '$no_of_students' WHERE id = '$id'";

                          // Execute SQL statement
                          if (mysqli_query($linkDB, $sql)) {
                              echo "Record updated successfully";
                          } else {
                              echo "Error updating record: " . mysqli_error($linkDB);
                          }
                      }
                  ?>


                </div>

                <div class="request">

                  <h3> Leave Request </h3>

                  <p>Enter the date that you are going to take leave</p>

                      <br><br>
                      <form method="post">
                        <?php
                          // Get the classid from the database
                          $sql = "SELECT class_id FROM coach_classes WHERE id = '$id'";
                          $result = mysqli_query($linkDB, $sql);
                          $row = mysqli_fetch_assoc($result);
                          $classid = $row['class_id'];

                          // Show the classid as a label in the form
                          // echo "<label for='classid'>Class ID: </label><input type='text' name='classid' id='classid' value='$classid' readonly>";
                        ?>
                        <br>
                        <!-- <label for="date">Date:</label> -->
                        <input type="date" name="date" id="date" class="input2"> <br><br>
                        <input type="submit" name="submit2" value="Send" class="btn1">
                      </form>

                      <?php
                        if(isset($_POST['submit2'])){  
                          // $id = $_POST["id"]; // Assuming the row id is passed through the form
                          $date = $_POST['date'];

                          // Retrieve the classid from the coach_classes table based on the row id
                          $query = "SELECT class_id FROM coach_classes WHERE id = '$id'";
                          $result = mysqli_query($linkDB, $query);
                          $row = mysqli_fetch_assoc($result);
                          $classid = $row['class_id'];

                          // Insert the data into the request table
                          $sql = "INSERT INTO request (classid, date) VALUES ('$classid', '$date')";
                          $rs= mysqli_query($linkDB,$sql);

                        }
                      ?>

                </div>


                <div class="delete">

                  <h3> Delete </h3>

                  <p>
                    The request will be accepted only at the 
                    <span id="warn">END OF THE MONTH</span></p>
                  </p>

                  <br>
                      <form method="post">
                        <?php
                          // Get the classid from the database
                          $sql = "SELECT class_id FROM coach_classes WHERE id = '$id'";
                          $result = mysqli_query($linkDB, $sql);
                          $row = mysqli_fetch_assoc($result);
                          $classid = $row['class_id'];

                        ?>

                          <!-- Show t"he classid as a label in the form -->
                          <span id ="classid"><?php echo " Class ID : $classid";?></span> <br>

                        <br>
                        <input type="submit" name="submit3" value="Send" class="btn1">
                      </form>

                      <?php
                      if(isset($_POST['submit3'])){  
                        // $id = $_POST["id"]; // Assuming the row id is passed through the form
                        // $date = $_POST['date'];
                      
                        // Retrieve the classid from the coach_classes table based on the row id
                        $query = "SELECT class_id FROM coach_classes WHERE id = '$id'";
                        $result = mysqli_query($linkDB, $query);
                        $row = mysqli_fetch_assoc($result);
                        $classid = $row['class_id'];
                      
                        // Update the status value from 1 to 2 for the relevant class_id in the request table
                        $sql = "UPDATE coach_classes SET status = '2' WHERE class_id = '$classid' AND status = '1'";
                        $rs = mysqli_query($linkDB, $sql);
                    }
                    
                      ?>

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






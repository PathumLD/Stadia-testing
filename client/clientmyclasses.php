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
    <link rel="stylesheet" href="../css/client/clientclasses.css">
 
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

            <h1>My Classes</h1>

            <div class="content">

              <?php
                // Check if a success message is present in the URL
                if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
                    echo "<div id='success-message' class='success-message'>Class registration successfull.</div>";
                }
                if(isset($_GET['msg']) && $_GET['msg'] == 'unsuccess') {
                  echo "<div id='unsuccess-message' class='notsuccess-message'>Couldn't register for the class - Try again </div>";
                }
                if(isset($_GET['msg']) && $_GET['msg'] == 'notsuccess') {
                    echo "<div id='notsuccess-message' class='notsuccess-message'>You are already registered for this class.</div>";
                }
                if(isset($_GET['msg']) && $_GET['msg'] == 'maxstudents') {
                  echo "<div id='notsuccess-message' class='notsuccess-message'>The class is already full.</div>";
              }
              ?>

              <table id="searchtable">
                <tr>
                  <td>
                    <form method="post">
                      <select name="search" class="search" id="disable">
                        <option value="" disabled selected>Search by Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                      </select>                  
                      <input type="submit" name="go" value="Search" id="searchbtn">
                    </form>
                  </td>
                  <td>
                    <form method="post">
                      <select name="sport_search" class="search" id="disable">
                        <option value="" disabled selected>Search by Sport</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Tennis">Tennis</option>
                        <option value="Swimming">Swimming</option>
                      </select>                  
                      <input type="submit" name="go2" value="Search" id="searchbtn">
                      <a href="clientmyclasses.php"><input type="submit" value="reset" id = "resetbtn"></a>
                    </form>
                  </td>
                </tr>
              </table>

              <div class="left">
                <table class="table">

                    <tr>
                      <th>Sport</th>
                      <th>Coach</th>
                      <th>Day</th>
                      <th>Time</th>
                      <th>Age Group</th>
                      <th>Level</th>
                      <th>Fee</th>
                      <th>Action</th>
                    </tr>

                    <?php

                        if(isset($_POST['go'])){
                                            
                            $search = $_POST['search'];

                            $query = "SELECT client_classes.id, client_classes.class_id, coach_classes.sport, coach_classes.coach, coach_classes.day, coach_classes.time, coach_classes.age_group, coach_classes.level, coach_classes.fee
                                      FROM coach_classes INNER JOIN client_classes ON coach_classes.class_id = client_classes.class_id 
                                      WHERE day LIKE '%$search%' AND client_classes.status=1 AND (coach_classes.status=1 OR coach_classes.status=2) AND client_classes.email = '".$var."'";
                        
                        } else if(isset($_POST['go2'])){

                            $sport_search = $_POST['sport_search'];

                            $query = "SELECT client_classes.id, client_classes.class_id, coach_classes.sport, coach_classes.coach, coach_classes.day, coach_classes.time, coach_classes.age_group, coach_classes.level, coach_classes.fee
                            FROM coach_classes INNER JOIN client_classes ON coach_classes.class_id = client_classes.class_id 
                            WHERE sport LIKE '%$sport_search%' AND client_classes.status=1 AND (coach_classes.status=1 OR coach_classes.status=2) AND client_classes.email = '".$var."'";

                        } else {
                          
                            $query = "SELECT client_classes.id, client_classes.class_id, coach_classes.sport, coach_classes.coach, coach_classes.day, coach_classes.time, coach_classes.age_group, coach_classes.level, coach_classes.fee
                                      FROM coach_classes INNER JOIN client_classes ON coach_classes.class_id = client_classes.class_id 
                                      WHERE client_classes.status=1 AND (coach_classes.status=1 OR coach_classes.status=2) AND client_classes.email = '".$var."'";
                        }

                            $res = mysqli_query($linkDB, $query); 
                            if($res == TRUE) 
                            {
                                $count = mysqli_num_rows($res); //calculate number of rows
                                if($count>0)
                                {
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        $id=$rows['id'];
                                        echo "<tr id='row_$id'>
                                                <td>" . $rows["sport"]. "</td>
                                                <td>" . $rows["coach"]. "</td>
                                                <td>" . $rows["day"]. "</td>
                                                <td>" . $rows["time"]. "</td> 
                                                <td>" . $rows["age_group"]. "</td>
                                                <td>" . $rows["level"]. "</td>
                                                <td>" . $rows["fee"]. "</td>
                                                <td><button class='submit-button' onclick='confirmRowData($id)'><i class='fa fa-trash'></i></button></td>
                                              </tr>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            }
                        
                    ?>

              </table>

            </div>

            <div class="right">

              <div class="bottom">

                <h3>Enroll for classes</h3>

                <h4><b>Enroll with the classes we provide!</b><br>
                Whether you're looking to learn a new skill, develop a new hobby, or advance your career, taking classes can help you achieve your goals.</h4>

                <a href="clientcoachbadminton.php"><button class="enroll">Badminton</button></a>
                <a href="clientcoachbasketball.php"><button class="enroll">Basketball</button></a><br>
                <a href="clientcoachvolleyball.php"><button class="enroll">Volleyball</button></a>
                <a href="clientcoachtennis.php"><button class="enroll">Tennis</button></a><br>
                <a href="clientcoachswimming.php"><button class="enroll sw">Swimming</button></a>     

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
  var sport = row.cells[0].innerHTML;
  var coach = row.cells[1].innerHTML;
  var day = row.cells[2].innerHTML;
  var time = row.cells[3].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2></i><p>Class Details:</p><ul><li>Sport: ' + sport + '</li><li>Coach: ' + coach + '</li><li>Day: ' + day + '</li><li>Time: ' + time + '</li></ul><h4><p>NOTE: Class cancellation will be only possible if you have completed the payments.</p></h4><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the clientcancelclass.php page
    window.location.href = 'clientcancelclass.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>

<script>
// Remove the success message after 3 seconds
setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    var notsuccessMessage = document.getElementById('notsuccess-message');
    var unsuccessMessage = document.getElementById('unsuccess-message');
    var nosuccessMessage = document.getElementById('maxstudents');

    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
    if (unsuccessMessage) {
        unsuccessMessage.style.display = 'none';
    }
    if (nosuccessMessage) {
        nosuccessMessage.style.display = 'none';
    }
}, 3000);
</script>
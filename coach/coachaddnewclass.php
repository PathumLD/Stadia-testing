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
    <link rel="stylesheet" href="../css/coach/coachaddnewclass.css">
 
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

                  <h1>Add New Class</h1>

                </div>

              <div class="form" id="addnewclass">

                  <form method="POST" action="">

                      <select name="level" class="drop" required>
                          <option value="" disabled selected>Level</option>
                          <option value="beginner">Beginner</option>
                          <option value="intermediate">Intermediate</option>
                          <option value="pro">Pro</option>
                      </select> <br><br>

                      <select name="sport" class="drop" required>
                          <option value="" disabled selected>Sport</option>
                          <option value="badminton">Badminton</option>
                          <option value="basketball">Basketball</option>
                          <option value="volleyball">Volleyball</option>
                          <option value="tennis">Tennis</option>
                          <option value="swimming">Swimming</option>
                      </select> <br><br>

                      <select name="day" class="drop" required>
                          <option value="" disabled selected>Day</option>
                          <option value="monday">Monday</option>
                          <option value="tuesday">Tuesday</option>
                          <option value="wednesday">Wednesday</option>
                          <option value="thursday">Thursday</option>
                          <option value="friday">Friday</option>
                          <option value="saturday">Saturday</option>
                          <option value="sunday">Sunday</option>
                      </select> <br><br>

                      <select name="stime" class="drop" required>
                          <option value="" disabled selected>Start Time</option>
                          <option value="7.00">7.00</option>
                          <option value="8.00">8.00</option>
                          <option value="9.00">9.00</option>
                          <option value="10.00">10.00</option>
                          <option value="11.00">11.00</option>
                          <option value="12.00">12.00</option>
                          <option value="13.00">13.00</option>
                          <option value="14.00">14.00</option>
                          <option value="15.00">15.00</option>
                          <option value="16.00">16.00</option>
                          <option value="17.00">17.00</option>
                          <option value="18.00">18.00</option>
                          <option value="19.00">19.00</option>
                          <option value="20.00">20.00</option>
                          <option value="21.00">21.00</option>
                      </select> <br><br>

                      <select name="etime" class="drop" required>
                          <option value="" disabled selected>End Time</option>
                          
                          <option value="8.00">8.00</option>
                          <option value="9.00">9.00</option>
                          <option value="10.00">10.00</option>
                          <option value="11.00">11.00</option>
                          <option value="12.00">12.00</option>
                          <option value="13.00">13.00</option>
                          <option value="14.00">14.00</option>
                          <option value="15.00">15.00</option>
                          <option value="16.00">16.00</option>
                          <option value="17.00">17.00</option>
                          <option value="18.00">18.00</option>
                          <option value="19.00">19.00</option>
                          <option value="20.00">20.00</option>
                          <option value="21.00">21.00</option>
                          <option value="22.00">22.00</option>
                      </select> <br><br>

                      <select name="age_group" class="drop" required>
                          <option value="" disabled selected>Age Group</option>
                          <option value="Below 12 Years">Below 12 Years</option>
                          <option value="13 - 20 Years">13 - 20 Years</option>
                          <option value="Above 21">Above 21</option>
                      </select> <br><br>

                      <input type="number" name="months" placeholder="Months" required min="1" max="3"> <br><br>


                      <input type="text" name="no_of_students" placeholder="No of Students" required> <br><br>
                      <input type="submit" name= "submit" value="Save" class="btn">

                  </form>
                
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

<?php 

    if(isset($_POST['submit'])){

        $level = $_POST['level'];
        $sport = $_POST['sport'];
        $day = $_POST['day'];
        $stime = $_POST['stime'];
        $etime = $_POST['etime'];
        $age_group = $_POST['age_group'];
        $months = $_POST['months'];
        $no_of_students = $_POST['no_of_students'];
        $email = $_SESSION['email'];


        $query = "SELECT CONCAT(fname, ' ', lname) AS coach_name FROM users WHERE email = '$email'";
        $result = mysqli_query($linkDB, $query);
        $row = mysqli_fetch_assoc($result);
        $coach = $row['coach_name'];

        $time = $stime . ' - ' . $etime;


        // Validate the input for months
        if($months >= 1 && $months <= 3) {
            $sql = "INSERT INTO coach_classes (level, sport, day, time, age_group, months, no_of_students, email, coach) VALUES ('$level', '$sport', '$day', '$time', '$age_group', '$months', '$no_of_students', '$email', '$coach')";
            if(mysqli_query($linkDB, $sql)){
                echo "<script>window.location.href='coachclasses.php'; </script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($linkDB);
            }
        } else {
            echo "Months count should be between 1 and 3";
        }
    }

?>

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
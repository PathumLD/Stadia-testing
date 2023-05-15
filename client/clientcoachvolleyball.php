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
    <link rel="stylesheet" href="../css/client/clientcoach.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

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

            <h1>Coaches - Volleyball</h1>
            
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
            ?>

                        <h3><b>Enroll with the classes we provide!</b><br><br>
                        Whether you're looking to learn a new skill, develop a new hobby, or advance your career, taking classes can help you achieve your goals.</h3>

            <table id="searchtable">
              <tr>
                <td>
                    <form method="post">

                        <select name="coach_email" class="search" id="disable">
                        <option value="" disabled selected>Search by Coach</option>
                        <?php
                            $query = "SELECT * from users WHERE type = 'coach' ";
                            $res = mysqli_query($linkDB, $query);
                            if($res == TRUE)
                            {
                                $count =mysqli_num_rows($res); //calculate the number of rows
                                if($count>0)
                                {
                                    $option = '';
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        $option .= '<option value="' .$rows['email'] . '">' .$rows['fname'] . " " . $rows['lname'] .'</option>';
                                    }
                                    echo '' . $option . '</select>';
                                } else{
                                    echo "0 results";
                                }
                            }
                        ?>

                        <input type="submit" name="go" value="Search" id="searchbtn">

                        <a href="clientbookings.php"><input type="submit" value="reset" id = "resetbtn"></a>
                    </form>
                    </td>

                    <td>
                    <button id="view-cv-btn">View CV</button>

                        <?php

                            if(isset($_POST['go'])){

                                $email = $_POST['coach_email'];

                                // Retrieve the pdf from the database
                                $folder = "../pdf/";
                                $sql = "SELECT * FROM pdf_data WHERE email = '$email' ";
                                $result = mysqli_query($linkDB, $sql);
                                $row = mysqli_fetch_array($result);
                                if($row){
                                    $filename = $row['filename'];
                                    // code to display the pdf
                                    } else {
                                    echo "CV not found for the given email.";
                                    }
                            }
                            
                            else {
                                echo "Please select a coach to view his/her CV";
                            }
        
                        ?>
                    </td>

            </tr>
            </table>

            <table class="table">

                <tr>

                    <th>Day</th>
                    <th>Age Group</th>
                    <th>Level</th>
                    <th>Time</th>
                    <th>Coach</th>
                    <th>Class Fee</th>
                    <th>Action</th>

                </tr>


                <?php
                    if(isset($_POST['go'])){

                        $email = $_POST['coach_email'];

                        $query = "SELECT * FROM coach_classes WHERE sport='volleyball'AND email = '$email' AND status = 1 ";

                    } else{

                        $query = "SELECT * FROM coach_classes WHERE sport='volleyball' AND status = 1 ";
                    }
                    $res = mysqli_query($linkDB, $query); 
                    if($res == TRUE) {
                        $count = mysqli_num_rows($res); //calculate number of rows
                        if($count>0) {
                            while($rows=mysqli_fetch_assoc($res)) 
                            {
                                $id=$rows['id'];
                                echo "<tr id='row_$id'>
                                        <td>" . $rows["day"]. "</td>
                                        <td>" . $rows["age_group"]. "</td>
                                        <td>" . $rows["level"]. "</td>
                                        <td>" . $rows["time"]. "</td>
                                        <td>" . $rows["coach"]. "</td>
                                        <td>" . $rows["fee"]. "</td>
                                        <td><button type='button' onclick='registerConfirmation($id)'>Register</button></td>
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
    const viewCvBtn = document.getElementById('view-cv-btn');
    
    viewCvBtn.addEventListener('click', () => {
        const url = "<?php echo $folder . $filename; ?>";
        window.open(url, '_blank');
    });
</script>

<script>
function registerConfirmation(id) {
    // Get the row with the class data
    var row = document.getElementById('row_' + id);

    // Get the class data from the row
    var day = row.cells[0].innerHTML;
    var age_group = row.cells[1].innerHTML;
    var level = row.cells[2].innerHTML;  
    var time = row.cells[3].innerHTML;
    var coach = row.cells[4].innerHTML;
    var fee = row.cells[5].innerHTML;

    // Create a custom confirm box
    var confirmBox = document.createElement('div');
    confirmBox.classList.add('confirm-box');
    confirmBox.innerHTML = '<h2>Confirm Registration?</h2></i><p>Class Details:</p><ul><li>Day: ' + day + '</li><li>Age Group: ' + age_group + '</li><li>Level: ' + level + '</li><li>Time: ' + time + '</li><li>Coach: ' + coach + '</li><li>Fee: ' + fee + '</li></ul><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

    // Add the confirm box to the page
    document.body.appendChild(confirmBox);

    // Add event listeners to the confirm and cancel buttons
    var confirmButton = document.getElementById('confirm-button');
    var cancelButton = document.getElementById('cancel-button');
    confirmButton.addEventListener('click', function() {
        // Redirect to the clientregisterclass.php page
        window.location.href = 'clientregisterclass.php?id=' + id;
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

    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
    if (unsuccessMessage) {
        unsuccessMessage.style.display = 'none';
    }
}, 3000);
</script>



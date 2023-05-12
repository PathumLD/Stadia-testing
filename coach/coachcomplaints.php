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
    <link rel="stylesheet" href="../css/coach/coachcomplaints.css">
 
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

            <h1>My Complaints</h1>
            
            <div class="content">



            <?php
                if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
                  echo "<div class='success-message' id='success-message'>Complaint updated successfully.</div>";
                } 
                if(isset($_GET['msg']) && $_GET['msg'] == 'notsuccess') {
                  echo "<div class='notsuccess-message' id='notsuccess-message'>Could not update complaint - Please try again.</div>";
                }
            ?>

            <script>
              // Get the message elements
              var successMessage = document.getElementById("success-message");
              var notsuccessMessage = document.getElementById("notsuccess-message");

              // Remove the message elements after 3 seconds
              setTimeout(function() {
                if (successMessage) {
                  successMessage.remove();
                }
                if (notsuccessMessage) {
                  notsuccessMessage.remove();
                }
              }, 3000);
            </script>

            

            <?php
              if(isset($_GET['mesg']) && $_GET['mesg'] == 'success') {
                echo "<div class='success-message' id='success-message'>Complaint submitted successfully.</div>";
              } 
              if(isset($_GET['mesg']) && $_GET['mesg'] == 'notsuccess') {
                echo "<div class='notsuccess-message' id='notsuccess-message'>Could not submit complaint - Please try again.</div>";
              }
            ?>

            <script>
                  // Get the message elements
                  var successMessage = document.getElementById("success-message");
                  var notsuccessMessage = document.getElementById("notsuccess-message");

                  // Remove the message elements after 3 seconds
                  setTimeout(function() {
                    if (successMessage) {
                      successMessage.remove();
                    }
                    if (notsuccessMessage) {
                      notsuccessMessage.remove();
                    }
                  }, 3000);
            </script>

            <div class="left">

              <table class="table">

                <tr>

                    <th>Subject</th>
                    <th>Details</th>
                    <th>Date Time</th>
                    <th>Action</th>

                </tr>

                <?php

                    $query = "SELECT * FROM complaints WHERE status = 1 AND email = '".$var."'" ;
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
                                                <td>" . $rows["subject"]. "</td>
                                                <td>" . $rows["details"]. "</td>
                                                <td>" . $rows["datetime"]. "</td>
                                                <td> <button class='submit-button' onclick='confirmRowData($id)'><i class='fa fa-trash'> /</i></button> 
                                                <button class='update-button' onclick=\"openPopup($id, '" . $rows["subject"] . "', '" . $rows["details"] . "')\"><i class='fa fa-pencil-square-o'></i></button>                                              
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

                <div class="top">

                    <h3>Submit a new complaint</h3>

                    <h4>Let us know how we can improve!</h4>

                    <div class="form" id="submitComplaint">

                      <form method="POST" >

                        <input type="text" name="subject" placeholder="Subject" required class="cmplnt"><br>
                        <textarea id="details" name="details" class="cmplnt" required>Enter Your Complaint Here... </textarea><br>
                        <input type="submit" name="submit" value="Submit" class="btn">
                        
                      </form>

                    </div>
                
                </div>

                <!-- <div class="bottom">

                  <img src="../images/complaint.jpg" alt="Girl in a jacket">

                </div> -->

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
  // Get the row with the complaint
  var row = document.getElementById('row_' + id);

  // Get the complaint from the row
  var subject = row.cells[0].innerHTML;
  var details = row.cells[1].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Deletion?</h2><p>Complaint Details:</p><ul><li>Subject: ' + subject + '</li><li>Details: ' + details + '</li></ul><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the coachdeletecomplaints.php page
    window.location.href = 'coachdeletecomplaints.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>

<?php

if(isset($_POST['submit'])){
  
include('linkDB.php');  

$subject = $_POST['subject'];
$details = $_POST['details'];
$email = $_SESSION['email'];


$sql = "INSERT INTO complaints (subject, details, email, datetime)
VALUES ('$subject', '$details' , '$email' , CURRENT_TIMESTAMP)";

$rs= mysqli_query($linkDB,$sql);

if($rs){
  
  echo "<script>window.location.href='coachcomplaints.php?mesg=success'; </script>";

}
else{
  echo "<script>window.location.href='coachcomplaints.php?mesg=notsuccess'; </script>";
}
 
}
?>

<!-- Popup to update complaint -->
<div id="complaint-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Update Complaint</h2>
        <form action="coachupdatecomplaints.php" method="post">
            <input type="hidden" id="complaint-id" name="complaint_id">
            <label for="complaint-subject">Subject:</label>
            <input type="text" id="complaint-subject" name="complaint_subject">
            <label for="complaint-details">Details:</label>
            <textarea id="complaint-details" name="complaint_details"></textarea>
            <input type="submit" value="Update Complaint" class="btn">
        </form>
    </div>
</div>

<script>
    function openPopup(id, subject, details) {
        // Set the complaint ID in the hidden input field
        document.getElementById('complaint-id').value = id;

         // Set the existing subject and details in the input fields
        document.getElementById('complaint-subject').value = subject;
        document.getElementById('complaint-details').value = details;

        // Show the popup
        document.getElementById('complaint-popup').style.display = 'block';
    }

    function closePopup() {
        // Hide the popup
        document.getElementById('complaint-popup').style.display = 'none';
    }
</script>

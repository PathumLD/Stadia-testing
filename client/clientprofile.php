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
    <link rel="stylesheet" href="../css/client/clientprofile.css">
 
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

            <h1>My Profile</h1>

            <div class="content">

            <?php
              // Check if a success message is present in the URL
              if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
                  echo "<div id='success-message' class='success-message'>Password updated successfully.</div>";
              }
              if(isset($_GET['msg']) && $_GET['msg'] == 'notsuccess') {
                echo "<div id='notsuccess-message' class='notsuccess-message'>Could not update password - Please try again.</div>";
              }
              if(isset($_GET['msg']) && $_GET['msg'] == 'unsuccess') {
                echo "<div id='unsuccess-message' class='notsuccess-message'>Your Passwords do not match - Please try again.</div>";
              }
            ?>

            <?php
              // Check if a success message is present in the URL
              if(isset($_GET['msg1']) && $_GET['msg1'] == 'success') {
                  echo "<div id='success-msg1' class='success-message'>Phone number updated successfully.</div>";
              }
              if(isset($_GET['msg1']) && $_GET['msg1'] == 'notsuccess') {
                echo "<div id='notsuccess-msg1' class='notsuccess-message'>Could not update Phone number - Please try again.</div>";
              }
            ?>

            <?php
              // Check if a success message is present in the URL
              if(isset($_GET['msg2']) && $_GET['msg2'] == 'success') {
                  echo "<div id='success-msg2' class='success-message'>Emergency contact number updated successfully.</div>";
              }
              if(isset($_GET['msg2']) && $_GET['msg2'] == 'notsuccess') {
                echo "<div id='notsuccess-msg2' class='notsuccess-message'>Could not update emergency contact number - Please try again.</div>";
              }
            ?>

            <?php
              // Check if a success message is present in the URL
              if(isset($_GET['msg3']) && $_GET['msg3'] == 'success') {
                  echo "<div id='success-msg3' class='success-message'>Emergency contact name updated successfully.</div>";
              }
              if(isset($_GET['msg3']) && $_GET['msg3'] == 'notsuccess') {
                echo "<div id='notsuccess-msg3' class='notsuccess-message'>Could not update emergency contact name - Please try again.</div>";
              }
            ?>

              <div class="left">

                <div class="top">

                  <h3>Profile Photo</h3>

                  <div class="profilepic">
                    
                    <table>
                      <tr>
                        <td>

                          <?php
                            // Check if a file was selected for upload
                            if(!empty($_FILES['image']['name'])) {

                                // Delete the old photo from the server
                                $result = mysqli_query($linkDB, "SELECT dp FROM users WHERE email = '".$var."'");
                                $row = mysqli_fetch_array($result);
                                $oldfile = $row['dp'];
                                if($oldfile != null) {
                                  $folder = "../img/";
                                  $target_file = $folder . basename($oldfile);
                                  unlink($target_file);
                                }
                              
                              // Upload the image to a temporary location
                              $tempname = uniqid() . '_' . $_FILES['image']['name'];
                              $folder = "../img/";
                              $target_file = $folder . basename($tempname);
                              move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                              $email = $_SESSION['email'];
                              
                              // Store the image file name in the database
                              $sql = "UPDATE users SET dp='$tempname' WHERE email= '".$var."'";
                              $rs=mysqli_query($linkDB, $sql);

                              if($rs){
                                echo "<img src='".$folder.$tempname."' alt='dp'>";
                              }
                            } else{
                              
                              // Retrieve the image from the database
                              $folder = "../img/";
                              $result = mysqli_query($linkDB, "SELECT * FROM users WHERE email = '".$var."'");
                              $row = mysqli_fetch_array($result);
                              $filename = $row['dp'];
                              
                              // Check if image exists in database, if not display message to upload profile photo
                              if($filename != null) {
                                // Display the image on the web page
                                echo '<img src="' . $folder . $filename . '" alt ="dp">';
                              } else {
                                echo '<img src="../img/noprofile.jpg"> ' ;
                              }
                            }
                          ?>

                        </td>

                        <td>
                            <!-- HTML form to upload the image -->
                            <form id="upload-form" method="post" enctype="multipart/form-data">
                                <label for="inputTag">
                                  <i class="fa fa-2x fa-camera"></i>
                                  <input type="file" id="inputTag" name="image" accept="image/*">
                                </label>
                            </form>

                        </td>
                      </tr>
                    </table>

                            
                        <!-- JavaScript to automatically submit the form when a file is selected -->
                        <script>
                          // Get the input element and the form
                          const inputTag = document.getElementById("inputTag");
                          const uploadForm = document.getElementById("upload-form");
                          
                          // Listen for changes to the input element
                          inputTag.addEventListener("change", (event) => {
                            // Submit the form when a file is selected
                            uploadForm.submit();
                            
                          });
                        </script>
                    
                  </div>
                      
                </div>

                <div class="bottom">

                <div class="details"><h3>Update Your Details</h3></div><br>

                <button class="btn" onclick="openPopup()">Change Password</button>
                <button class="btn" onclick="openPopup1()">Change Phone Number</button>
                <button class="btn" onclick="openPopup2()">Change Emergency Contact Number</button>
                <button class="btn" onclick="openPopup3()">Change Emergency Contact Name</button>

                </div>

              </div> 
              
              <div class="right">

                <h3>Profile Photo</h3>

                <table id="tableprofile">   

                  <?php

                      $sql = "SELECT * FROM users WHERE email = '".$var."'";

                      $result = mysqli_query($linkDB, $sql);

                      if ($result-> num_rows>0){
                          while($row = $result->fetch_assoc()){

                              echo "<tr>

                                  <td class='mylabel'>Name:</td>
                                  <td class='mydata'>".$row['fname']." ".$row['lname']."</td>
                                  </tr>

                                  <td class='mylabel'>Gender:</td>
                                  <td class='mydata'>".$row['gender']."</td>
                                  </tr>

                                  <td class='mylabel'>Phone:</td>
                                  <td class='mydata'>".$row['phone']."</td>
                                  </tr>

                                  <td class='mylabel'>Date of Birth:</td>
                                  <td class='mydata'>".$row['dob']."</td>
                                  </tr>

                                  <td class='mylabel'>NIC / Guardian NIC:</td>
                                  <td class='mydata'>".$row['NIC']."</td>
                                  </tr>

                                  <td class='mylabel'>Emergency Contact Number:</td>
                                  <td class='mydata'>".$row['emphone']."</td>
                                  </tr>

                                  <td class='mylabel'>Emergency Contact Name:</td>
                                  <td class='mydata'>".$row['emname']."</td>
                                  </tr>";
                              
                          }
                      }

                      ?>
                </table>

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
// Open the popup
function openPopup1() {
  document.getElementById("popup1").style.display = "block";
}

// Close the popup
function closePopup1() {
  document.getElementById("popup1").style.display = "none";
}
</script>

<div id="popup1" class="popup1">
  <div class="popup-content" >
    <span class="close" onclick="closePopup1()">&times;</span>
    <h3>Change Phone Number</h3>
    <form method="post" action="update_profile.php" >
    
      <label for='phone'>Update Phone</label>
      <input type='tel' placeholder='Enter phone' name='phone' pattern='[0-9]{10}'required>
                                    
      <input type='submit' class='btn' id='update-btn' name='update1' value='Update'>

    </form>
  </div>
</div>

<script>
// Open the popup
function openPopup2() {
  document.getElementById("popup2").style.display = "block";
}

// Close the popup
function closePopup2() {
  document.getElementById("popup2").style.display = "none";
}
</script>

<div id="popup2" class="popup2">
  <div class="popup-content">
    <span class="close" onclick="closePopup2()">&times;</span>
    <h3>Change Emergency Contact Number</h3>
    <form method="post" action="update_profile.php" >
    
      <label for='emphone'>Update Contact Number</label>
      <input type='tel' placeholder='Enter number' name='emphone' pattern='[0-9]{10}'required>
                                    
      <input type='submit' class='btn' id='update-btn' name='update2' value='Update'>

    </form>
  </div>
</div>

<script>
// Open the popup
function openPopup3() {
  document.getElementById("popup3").style.display = "block";
}

// Close the popup
function closePopup3() {
  document.getElementById("popup3").style.display = "none";
}
</script>

<div id="popup3" class="popup3">
  <div class="popup-content">
    <span class="close" onclick="closePopup3()">&times;</span>
    <h3>Change Emergency Contact Number</h3>
    <form method="post" action="update_profile.php" >

      <label for='emname'>Update Contact Name</label>
      <input type='text' placeholder='Enter name' name='emname' required>
                                    
      <input type='submit' class='btn' id='update-btn' name='update3' value='Update'>

    </form>
  </div>
</div>

<script>
        let input = document.getElementById("inputTag");
        let imageName = document.getElementById("imageName")

        input.addEventListener("change", ()=>{
            let inputImage = document.querySelector("input[type=file]").files[0];

            imageName.innerText = inputImage.name;
        })
</script>

<script>
// Open the popup
function openPopup() {
  document.getElementById("popup").style.display = "block";
}

// Close the popup
function closePopup() {
  document.getElementById("popup").style.display = "none";
}
</script>

<div id="popup" class="popup">
  <div class="popup-content">
    <span class="close" onclick="closePopup()">&times;</span>
    <h3>Change Password</h3>
    <form method="post" action="update_profile.php">
      <label for="currentpswd">Old Password</label>
      <input type="password" id="currentpswd" name="currentpswd" required>

      <label for="newpswd">New Password</label>
      <input type="password" id="newpswd" name="newpswd" required>

      <label for="confirmnewpswd">Confirm New Password</label>
      <input type="password" id="confirmnewpswd" name="confirmnewpswd" required>

      <input type="submit" value="Change Password" name="save" class="btn">

    </form>
  </div>
</div>

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

<script>
// Remove the success message after 3 seconds
setTimeout(function() {
    var successMessage = document.getElementById('success-msg1');
    var notsuccessMessage = document.getElementById('notsuccess-msg1');

    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
}, 3000);
</script>

<script>
// Remove the success message after 3 seconds
setTimeout(function() {
    var successMessage = document.getElementById('success-msg2');
    var notsuccessMessage = document.getElementById('notsuccess-msg2');

    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
}, 3000);
</script>

<script>
// Remove the success message after 3 seconds
setTimeout(function() {
    var successMessage = document.getElementById('success-msg3');
    var notsuccessMessage = document.getElementById('notsuccess-msg3');

    if (successMessage) {
        successMessage.style.display = 'none';
    }
    if (notsuccessMessage) {
        notsuccessMessage.style.display = 'none';
    }
}, 3000);
</script>
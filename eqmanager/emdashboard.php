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
    <link rel="stylesheet" href="../css/eqmanager.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/emsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/emnavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

            <h1>Dashboard</h1>

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

            <div class="content">

            <div>
              Equipment IDs
                Badminton - Ebdm
                Basketball - Ebsk
                Volleyball - Evlb
                Tennis - Etns
                Swimming - Eswm
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
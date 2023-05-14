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
    <link rel="stylesheet" href="../css/eqmanager/emchangepassword.css">
 
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

            <h1>Change Password</h1>

            <div class="content">

                <div class="left">

                    <div class="form" id="changePassword">

                        <form method="post" action="emupdate_password.php" >

                            <input type="password" id="currentpswd" name="currentpswd" placeholder="Old Password" required><br>
                           
                            <input type="password" id="newpswd" name="newpswd" placeholder="New Password" required><br>

                            <input type="password" id="confirmnewpswd" name="confirmnewpswd" placeholder="Confirm New Password" required><br>

                            <input type="submit" value="Change Password" name="save" class="btn">

                        </form>

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


<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?>


<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Stadia </title>

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/supplier.css">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../include/javascript.php'); ?>
    <?php include('../include/styles.php'); ?>

</head>

<body onload="initClock()">

    <div class="sidebar">

        <?php include('../include/suppliersidebar.php'); ?>

    </div>

    <section class="home-section">

        <nav>

            <?php include('../include/suppliernavbar.php'); ?>

        </nav>

        <div class="home-content">


            <div class="main-content">


                <?php $var = $_SESSION['email']; ?>

                <div class="form">
                <h1>Change Password</h1>

                        <form method="POST">

                        <p class="add">Current Password</p><input type="password" name="currentpswd">
                        <p class="add">New Password</p><input type="password" name="newpswd"> 
                        <p class="add">Confirm New Password</p><input type="password" name="confirmnewpswd">
                        <br>
                        <br>
                        <button type="submit" class="btn" name="save">Save</button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

        <footer>
            <div class="foot">
                <span>Created By <a href="#">Stadia.</a> | &#169; 2023 All Rights Reserved</span>
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
        dropdown[i].addEventListener("click", function () {
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

<?php

if(isset($_POST['save'])){
  

$currentpswd = $_POST['currentpswd'];
$newpswd = $_POST['newpswd'];
$confirmnewpswd = $_POST['confirmnewpswd'];

if($newpswd!==$confirmnewpswd){
        echo '<span class="error-new"><h3> Your Passwords does not match </h3></span>';
    }
else{

  $query = "SELECT * FROM adminuser WHERE email= '".$var."' ";
      $result = mysqli_query($linkDB, $query);
      $row = mysqli_fetch_array($result);
      $verify = md5($currentpswd);
      $encrypt = md5($newpswd);
      if (count($row)) {
                  
        if ($verify==$row['password']) {

          $sql = "UPDATE adminuser SET password = '$encrypt' WHERE email = '{$_SESSION['email']}' ";
          $rs= mysqli_query($linkDB,$sql);
                  
          if($rs){
            echo "Password Updated";
            echo "<script>window.location.href='supplierdashboard.php'; </script>";
          } else{
              echo "<p>Could not update password - please try again.</p>";
            }
        } else{
          echo "<p>Could not update password - please try again.</p>";
        }

    }
  } 
}

?>
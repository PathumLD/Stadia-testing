<!-- PHP command to link server.php file with registration form  -->
<?php include('server.php'); ?>

<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Stadia </title>
  <link rel="stylesheet" href="css/login.css">
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>


  <div class="container">

    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="images/rst.png" id="rst">
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Reset Password</div>

          <form method="POST">
            <div class="input-boxes">

            <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Enter Your New Password" name="newpassword" required>
              </div>
              <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Your New Password" name="confirmpassword" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Reset Password " name="reset">
              </div>

            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</body>

</html>

<?php
// Include the database connection code
include('linkDB.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Retrieve the new password and confirm password entered by the user
  $newpassword = $_POST['newpassword'];
  $confirmpassword = $_POST['confirmpassword'];
  $email = $_POST['email'];

  // Check if the passwords match
  if ($newpassword == $confirmpassword) {
    // Passwords match, check if email exists in users table
    $result = mysqli_query($linkDB, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($result) > 0) {
      // Email exists in users table, update password
      $hashedPassword = md5($password);
      mysqli_query($linkDB, "UPDATE users SET password='$hashedPassword' WHERE email='$email'");
    } else {
      // Email not found in users table, check if email exists in adminuser table
      $result = mysqli_query($linkDB, "SELECT * FROM adminuser WHERE email='$email'");
      if (mysqli_num_rows($result) > 0) {
        // Email exists in adminuser table, update password
        $hashedPassword = md5($password);
        mysqli_query($linkDB, "UPDATE adminuser SET password='$hashedPassword' WHERE email='$email'");
      } else {
        // Email not found in either table, show an alert
        echo "<script>alert('Email not found');</script>";
      }
    }

    // Redirect to the login page
    header("Location: login.php");
    exit();
  } else {
    // Passwords do not match, show an alert
    echo "<script>alert('Passwords do not match');</script>";
  }
}
?>

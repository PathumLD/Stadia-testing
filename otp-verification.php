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
        <img src="images/OTPverify.png" id="reset">
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Verify OTP</div>

          <form method="POST">
            <div class="input-boxes">

              <div class="input-box">
                <i class="fa fa-key"></i>
                <input type="text" placeholder="Enter the OTP" name="otp" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Verify" name="reset">
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

  // Retrieve the OTP entered by the user
  $otp = $_POST['otp'];
  // Query the OTPs table for the OTP entered by the user
  $sql = "SELECT * FROM otps WHERE otp = '$otp'";
  $result = $linkDB->query($sql);

  // Check if the OTP is valid
  if ($result->num_rows > 0) {
    // OTP is valid, redirect to the resetpassword.php page
    header("Location: resetpassword.php");
    exit();
  } else {
    // OTP is invalid, show an alert
    echo "<script>alert('Invalid OTP');</script>";
  }

  
}
?>

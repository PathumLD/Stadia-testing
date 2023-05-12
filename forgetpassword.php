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
        <img src="images/Reset password (1).png" id="reset">
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Forgot Password</div>

          <form method="POST">
            <div class="input-boxes">

              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your email" name="email" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Reset Password" name="Reset">
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
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Include the database connection code
include('linkDB.php');

// Initialize the $error1 and $error2 variables to empty strings
$error1 = '';
$error2 = '';

// Check if the Reset button was clicked
if (isset($_POST['Reset'])) {
  // Get the email address entered in the form
  $email = mysqli_real_escape_string($linkDB, $_POST['email']);

  // Check if the email address exists in the users or adminlogin tables
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($linkDB, $query);
    if (mysqli_num_rows($result) == 0) {
    $query = "SELECT * FROM adminlogin WHERE email='$email'";
    $result = mysqli_query($linkDB, $query);
    if (mysqli_num_rows($result) == 0) {
      // Email address not found in either table
      $error2 = 'Invalid email address.';
    }
  }

  // If the email address is valid, generate an OTP and store it in the database
  if (empty($error2)) {
    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    $query = "INSERT INTO otps (email, otp) VALUES ('$email', '$otp')";
    mysqli_query($linkDB, $query);

    // Send email using PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "25";
    $mail->Username = "stadia.system@gmail.com";
    $mail->Password = "ooxiphelmlrqyktf";
    $mail->Subject = "Your verify code";

    $mail->setFrom('stadia.system@gmail.com');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Body = "<p>Hello,</p>
                   <p>Dear user, </p> <p>Your OTP verify code is <b>$otp </b><br></p>
                  <p>Regards,</p>
                  <p>The Stadia Team</p>";

    if ($mail->send()) {
      // Redirect to OTP verification page passing the email as a parameter
      header('Location: otp-verification.php?email=' . $email);
    } else {
      // Display an error message if email was not sent successfully
      echo '<script>alert("Invalid OTP please try again.");</script>' . $mail->ErrorInfo;
    }


    $mail->smtpClose();
  }
}
?>
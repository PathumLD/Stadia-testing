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
  <?php if (!empty($error2)) echo "<div class='error'>$error2</div>"; ?>
  <?php if (!empty($error1)) echo "<div class='error'>$error1</div>"; ?>
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="images/frontImg.jpeg" >
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
            
          <form method="POST">
            <div class="input-boxes">

              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your email" name="email">
              </div>

              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password" name="password">
              </div>

              <div class="text"><a href="forgetpassword.php">Forgot password</a> </div>
              
              <div class="button input-box">
                <input type="submit" value="Login" name="logIn">
              </div>
              
              <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup now</label></div>
              

            </div>
        </form>
      </div>


          <div class="signup-form">
          <div class="title">Signup</div>
          
        <form method="POST" >
            <div class="input-boxes">
              
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="First Name" name="fname" required><input type="text" placeholder="Last Name" name="lname" required>
              </div>

              <div class="input-box">
                <i class="fas fa-venus-mars"></i>
                <select name="gender" placeholder="Gender" class="drop" required>
                    <option value="" disabled selected>Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <input type="text" placeholder="NIC/Guardian NIC" name="NIC" required>
              </div>

              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Email" name="email" required>
                <input type="text" name="dob" onfocus="(this.type = 'date')" placeholder="Date of Birth" max="<?php echo date('Y-m-d'); ?>" required>
              </div>

              <div class="input-box">
                <i class="fas fa-mobile"></i>
                <input type="tel" name="phone" placeholder="Phone" pattern="[0-9]{10}" required>
                <input type="radio" id="client" name="type" value="client" required>
                <label for="client">Client</label>
                <input type="radio" id="coach" name="type" value="coach">
                <label for="coach">Coach</label>
              </div>

              <div class="input-box">
                
                <i class="fa fa-home"></i>
                <input type="text" name="address" placeholder="Address" required>
              </div>

              <div class="input-box">
                
                <p><br>Emergency Contact Details:<br></p>
                <input type="tel" name="emphone" placeholder="Phone" pattern="[0-9]{10}" required>
                <input type="text" name="emname" placeholder="Name" required>
              </div>

              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="password" name="repeatPassword" placeholder="Repeat Password" required>
              </div>

              <div class="button input-box">
                <input type="submit" value="Signup" name="signUp">
              </div>
              <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
            </div>
      </form>
    </div>

    </div>
    </div>
  </div>
</body>
</html>
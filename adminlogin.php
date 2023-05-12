<!-- PHP command to link server.php file with registration form  -->
<?php include('adminserver.php'); ?>

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
                <img src="images/frontImg.jpeg" alt="">
                <!-- <div class="text">
          <span class="text-1">Every new friend is a <br> new adventure</span>
          <span class="text-2">Let's get connected</span>
        </div> -->
            </div>
            <!-- <div class="back"> -->
            <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
            <!-- <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div> -->
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Administration Login</div>
                    <?php echo "$error2"; ?>
                    <form method="POST">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your Email" required> <br><br>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Password" required><br>
                            </div>
                            <div class="text"><a href="adminchangepassword.php">Change password</a></div>
                            <div class="button input-box">
                                <input type="submit" value="Submit" name="logIn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</body>
</html>


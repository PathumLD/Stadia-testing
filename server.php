<?php 
$error1 = "";
$error2 = "";
session_start();
//------ PHP code for User registration form---

if (array_key_exists("signUp", $_POST)) {
 
     // Database Link
    include('linkDB.php');  
 
    //Taking HTML Form Data from User
    
    $email = mysqli_real_escape_string($linkDB, $_POST['email']);
    $password = mysqli_real_escape_string($linkDB, $_POST['password']);
    $repeatPassword = mysqli_real_escape_string($linkDB,  $_POST['repeatPassword']);
    $fname = mysqli_real_escape_string($linkDB, $_POST['fname']);
    $lname = mysqli_real_escape_string($linkDB, $_POST['lname']);
    $gender = mysqli_real_escape_string($linkDB, $_POST['gender']);
    $NIC = mysqli_real_escape_string($linkDB, $_POST['NIC']);
    $dob = mysqli_real_escape_string($linkDB, $_POST['dob']);
    $phone = mysqli_real_escape_string($linkDB, $_POST['phone']);
    $address = mysqli_real_escape_string($linkDB, $_POST['address']);
    $emname = mysqli_real_escape_string($linkDB, $_POST['emname']);
    $emphone = mysqli_real_escape_string($linkDB, $_POST['emphone']);
    $type = mysqli_real_escape_string($linkDB, $_POST['type']);

    // Form validation

    if($password!==$repeatPassword){
        $error1 = "<h3> Your Passwords does not match </h3>";
    } 
   
   else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error1 .= "<h3>Invalid email format. </h3>";
  }
  
  else if (!preg_match("/^[a-zA-Z-' ]*$/",$fname) || !preg_match("/^[a-zA-Z-' ]*$/",$lname) || !preg_match("/^[a-zA-Z-' ]*$/",$emname)) {
    $error1 .= "<h3>Only letters and white space allowed in name. </h3>";
  }
  
  else if (!preg_match("/^(\d{9}[vVxX]|\d{12})$/", $NIC)) {
    $error1 .= "<h3>Invalid NIC format.</h3> ";
}

else if (!preg_match("/^[0-9]{10}$/", $phone) || !preg_match("/^[0-9]{10}$/", $emphone) ) {
  $error1 .= "<h3>Invalid phone number format.</h3> ";
}
  
  else if ($type !== "client" && $type !== "coach") {
    $error1 .= "<h3>Invalid user type.</h3> ";
  }
  
  else if ($error1 === "") {
    $query = "SELECT id FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($linkDB, $query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) {
      $error1 = "<h3>Email already exists.</h3>";
    } else {
      $password = md5($password);
      $query = "INSERT INTO users (email, password, fname, lname, gender, NIC, dob, phone, address, emname, emphone, type)
                VALUES ('$email', '$password', '$fname', '$lname', '$gender', '$NIC', '$dob', '$phone', '$address', '$emname', '$emphone', '$type')";
      mysqli_query($linkDB, $query);
      $_SESSION['email'] = $email;
      $error1 .= "<h3>Successfully Registered!</h3>";
      header('location: login.php');
    }
  }
}

    
    
      //-------User Login PHP Code ------------
     
if (array_key_exists("logIn", $_POST)) {
    
    // Database Link
    include('linkDB.php'); 
    
    //Taking form Data From User
    $email = mysqli_real_escape_string($linkDB, $_POST['email']);
    $password = mysqli_real_escape_string($linkDB,  $_POST['password']); 

    // Check if email and password fields are not empty
    if(empty($email) || empty($password)){
      $error2 = "<h3>Please enter both email and password</h3>";
    } else {

        $query = "SELECT email FROM users WHERE email = '$email'";
            $result = mysqli_query($linkDB, $query);
            if (mysqli_num_rows($result) == 0) {
                $error2 = "<h3> You haven't signed up using this email! </h3>";
            } else {
        
                //matching email and password
                
                $query = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($linkDB, $query);
                        $row = mysqli_fetch_array($result);
                        $verify= md5($password);
                        if (count($row)) {
                            
                            if ($verify==$row['password']) {
                                
                                //session variables to keep user logged in
                                $_SESSION['email'] = $row['email'];  
                                
                                // //Logged in for long time until user didn't log out
                                // if ($_POST['stayLoggedIn'] == '1') {
                                //     setcookie('email', $row['email'], time() + 60*60*24); //Logged in permanently
                                // }
                                if ($row['type']=='client') {
                                    header("Location: client/clientdashboard.php");
                                }
                                else{
                                    header("Location: coach/coachdashboard.php");
                                }

                            } else {
                                $error2 = "<h3>Combination of email/password does not match! </h3>";
                              }
              
                        } else {
                              $error2 = "<h3>Combination of email/password does not match! </h3>";
                        }
                            
              }
      }
    }
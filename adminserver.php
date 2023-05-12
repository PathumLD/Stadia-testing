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
    $password = mysqli_real_escape_string($linkDB,  $_POST['password']); 
    $repeatPassword = mysqli_real_escape_string($linkDB,  $_POST['repeatPassword']);
    $type = mysqli_real_escape_string($linkDB, $_POST['type']);
    $gender =  mysqli_real_escape_string($linkDB, $_POST['gender']);
    $fname = mysqli_real_escape_string($linkDB, $_POST['fname']);
    $lname = mysqli_real_escape_string($linkDB, $_POST['lname']);
    $NIC = mysqli_real_escape_string($linkDB, $_POST['NIC']);
    $phone = mysqli_real_escape_string($linkDB, $_POST['phone']);
    $dob = mysqli_real_escape_string($linkDB, $_POST['dob']);
    $emphone = mysqli_real_escape_string($linkDB, $_POST['emphone']);
    $emname = mysqli_real_escape_string($linkDB, $_POST['emname']);
     
    if($password!==$repeatPassword){
        $error1 = "<h3> Your Passwords does not match </h3>";
    }
    else{
                 
        //Check if email is already exist in the Database
 
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($linkDB, $query);
        if (mysqli_num_rows($result) > 0) {
            $error1 = "<h3> Your email address has already been taken!  </h3>";
        } else {
 
            //Password encryption or Password Hashing
            $hashedPassword = md5($password); 
            $query = "INSERT INTO users (email, password, type, gender, fname, lname, NIC, phone, dob, emphone, emname) VALUES ('$email', '$hashedPassword', '$type', '$gender', '$fname', '$lname', '$NIC', '$phone', '$dob', '$emphone', '$emname')";
             
            if (!mysqli_query($linkDB, $query)){
                $error1 = "<h3> Could not sign you up - please try again.  </h3>";
                } else {
 
                    //session variables to keep user logged in
                $_SESSION['id'] = mysqli_insert_id($linkDB);  
                $_SESSION['email'] = $email;
 
                //Setcookie function to keep user logged in for long time
                // if ($_POST['stayLoggedIn'] == '1') {
                // setcookie('id', mysqli_insert_id($linkDB), time() + 60*60*365);
                // //echo "<p>The cookie id is :". $_COOKIE['id']."</P>";
                // }
                  
                //Redirecting user to home page after successfully logged in 

                if ($type=='client') {
                    header("Location: clientprofile.php");  
                }

                else{
                    header("Location: coachprofile.php");
                }
                
                }
             
            }
        }
        }  
    
    
      //-------User Login PHP Code ------------
     
if (array_key_exists("logIn", $_POST)) {
    
  
    // Database Link
    include('linkDB.php');
   
   
   // Get the values from the form
   $email = $_POST['email'];
   $password = $_POST['password'];
   
   // Check if the email and password exist in the database
   $sql = "SELECT * FROM adminlogin WHERE email = '$email' AND password = '$password'";
   $result = mysqli_query($linkDB, $sql);
   
   // If there is a match
   if (mysqli_num_rows($result) > 0) {
       $row = mysqli_fetch_assoc($result);
       $type = $row['type'];
   
       // If the user is an admin
       if ($type == "Admin") {
           header("Location: ./admin/admindashboard.php");
       }
       // If the user is a manager
       else if ($type == "Manager") {
           header("Location: managerdashboard.php");
       }
       // If the user is equipment manager
       else if ($type == "Equipment Manager") {
           header("Location: equipmentdashboard.php");
       }
       // If the user is external supplier
       else if ($type == "External Supplier") {
           header("Location: ./exsupplier/supplierdashboard.php");
       }
       // If the type is something else
       else {
           echo "Invalid user type.";
       }
   }
   // If the username and password don't match any records in the database
   else {
       echo "Invalid username or password.";
   }
}
   
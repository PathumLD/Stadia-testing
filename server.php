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
      $query = "INSERT INTO users (email, password, fname, lname, gender, NIC, dob, phone, address, emname, emphone, type, datetime)
                VALUES ('$email', '$password', '$fname', '$lname', '$gender', '$NIC', '$dob', '$phone', '$address', '$emname', '$emphone', '$type' , CURRENT_TIMESTAMP)";
      mysqli_query($linkDB, $query);
      $_SESSION['email'] = $email;
      $error1 .= "<h3>Successfully Registered!</h3>";
      header('location: login.php');
    }
  }
}

    
    
      //-------User Login PHP Code ------------
     // Initialize stored_password to an empty string
$stored_password = "";
$stored_password_admin="";

if (array_key_exists("logIn", $_POST)) {

// Database Link
include('linkDB.php');

//Taking form Data From User
$email = mysqli_real_escape_string($linkDB, $_POST['email']);
$password = mysqli_real_escape_string($linkDB, $_POST['password']);

$user_result = $linkDB->query("SELECT * FROM users WHERE email='$email'");
if ($user_result->num_rows > 0) {
$user = $user_result->fetch_assoc();
$stored_password = $user['password'];

// Hash the user's input password using md5
$input_password = $_POST['password'];
$hashed_input_password = md5($input_password);

// Compare the two hashes using ==
if ($stored_password == $hashed_input_password) {
if ($user['type'] == 'client') {
// Redirect to client dashboard
header('Location: clientdashboard.php');
exit();
} else if ($user['type'] == 'coach') {
// Redirect to coach dashboard
header('Location: coachdashboard.php');
exit();
}
}
}

else{

// Check if email exists in adminuser table
$admin_result = $linkDB->query("SELECT * FROM adminuser WHERE email='$email'");
if ($admin_result->num_rows > 0) {
// Email exists in adminuser table
$admin = $admin_result->fetch_assoc();

$stored_password = $admin['password'];

// Hash the user's input password using md5
$input_password_admin = $_POST['password'];

 $hashed_input_password_admin = md5($input_password_admin);

// Compare the two hashes using ==
if ($stored_password == $hashed_input_password_admin) {

if ($admin['type'] == 'admin') {
// Redirect to admin dashboard
header("Location: ./admin/admindashboard.php");
exit();
} else if ($admin['type'] == 'Manager') {
// Redirect to manager dashboard
header('Location: managerdashboard.php');
exit();
} else if ($admin['type'] == 'external supplier') {
// Redirect to supplier dashboard
header('Location: ./exsupplier/supplierdashboard.php');
exit();
} else if ($admin['type'] == 'Equipment Manager') {
// Redirect to equipment manager dashboard
header('Location: equipmentdashboard.php');
exit();
}
}
}

// Email not found in any table or password does not match
$error2="Invalid email or password";


}
}

?>

                           
                            
            
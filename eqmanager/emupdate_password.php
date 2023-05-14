<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?>

<?php

    if(isset($_POST['save'])){

    $currentpswd = $_POST['currentpswd'];
    $newpswd = $_POST['newpswd'];
    $confirmnewpswd = $_POST['confirmnewpswd'];
    $email = $_SESSION['email'];

    if($newpswd!==$confirmnewpswd){
        // Redirect to the emdashboard.php page with a success message
        header('location: emdashboard.php?msg=unsuccess');
    } else{

        $query = "SELECT * FROM adminuser WHERE email= '$email' ";
        $result = mysqli_query($linkDB, $query);
        $row = mysqli_fetch_array($result);
        $verify = md5($currentpswd);
        $encrypt = md5($newpswd);
        if (count($row)) {
                    
            if ($verify==$row['password']) {

            $sql = "UPDATE adminuser SET password = '$encrypt' WHERE email = '{$_SESSION['email']}' ";
            $rs= mysqli_query($linkDB,$sql);
                    
            if($rs){
                // Redirect to the emdashboard.php page with a success message
                header('location: emdashboard.php?msg=success');
            } else{
                // Redirect to the emdashboard.php page with a success message
                header('location: emdashboard.php?msg=notsuccess');
                }
            } else{
                // Redirect to the emdashboard.php page with a success message
                header('location: emdashboard.php?msg=notsuccess');
            }

        }
    } 
    }

?>
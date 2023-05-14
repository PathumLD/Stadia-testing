<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?>

                                /* Change Password */

                                <?php

                                  if(isset($_POST['save'])){

                                    $currentpswd = $_POST['currentpswd'];
                                    $newpswd = $_POST['newpswd'];
                                    $confirmnewpswd = $_POST['confirmnewpswd'];
                                    $email = $_SESSION['email'];

                                    if($newpswd!==$confirmnewpswd){
                                        // Redirect to the coachprofile.php page with a success message
                                        header('location: coachprofile.php?msg=unsuccess');
                                    } else{

                                        $query = "SELECT * FROM users WHERE email= '$email' ";
                                        $result = mysqli_query($linkDB, $query);
                                        $row = mysqli_fetch_array($result);
                                        $verify = md5($currentpswd);
                                        $encrypt = md5($newpswd);
                                        if (count($row)) {
                                                    
                                          if ($verify==$row['password']) {

                                            $sql = "UPDATE users SET password = '$encrypt' WHERE email = '{$_SESSION['email']}' ";
                                            $rs= mysqli_query($linkDB,$sql);
                                                    
                                            if($rs){
                                              // Redirect to the coachprofile.php page with a success message
                                              header('location: coachprofile.php?msg=success');
                                            } else{
                                                // Redirect to the coachprofile.php page with a success message
                                                header('location: coachprofile.php?msg=notsuccess');
                                              }
                                          } else{
                                              // Redirect to the coachprofile.php page with a success message
                                              header('location: coachprofile.php?msg=notsuccess');
                                          }

                                      }
                                    } 
                                  }

                                ?>
                                <script>
                                    // Hide error message after 3 seconds
                                    setTimeout(function() {
                                        document.getElementById('error-msg').style.display = 'none';
                                    }, 3000);
                                </script>
                


                                    /* Update Phone Number */

                <?php
                  if(isset($_POST['update1'])) {
                      $phone=$_POST['phone'];
                      $var = $_SESSION['email'];

                      $query = "UPDATE users SET phone=$phone WHERE email = '".$var."' ";

                      $res = mysqli_query($linkDB, $query); 

                      if($res){
                          // Redirect to the coachprofile.php page with a success message
                          header('location: coachprofile.php?msg1=success');
                      } else{
                          // Redirect to the coachprofile.php page with a not-success message
                          header('location: coachprofile.php?msg1=notsuccess');
                      }
                  }
                ?>
                


                                    /* Update Emergency Contact */

                <?php
                  if(isset($_POST['update2'])) {
                  $emphone=$_POST['emphone'];
                  $var = $_SESSION['email'];

                  $query = "UPDATE users SET emphone=$emphone WHERE email = '".$var."' ";

                  $res = mysqli_query($linkDB, $query) or die(mysqli_error($linkDB)); 

                  if($res){
                    // Redirect to the coachprofile.php page with a success message
                    header('location: coachprofile.php?msg2=success');
                  }
                  else{
                    // Redirect to the coachprofile.php page with a success message
                    header('location: coachprofile.php?msg2=notsuccess');
                  }

                  }
                ?>
                


                                    /* Update Emergency Contact Name */

                <?php
                  if(isset($_POST['update3'])) {
                  $emname=$_POST['emname'];
                  $var = $_SESSION['email'];

                  $query = "UPDATE users SET emname='$emname' WHERE email = '".$var."' ";

                  $res = mysqli_query($linkDB, $query) or die(mysqli_error($linkDB)); 
                      
                  if($res){
                    // Redirect to the coachprofile.php page with a success message
                    header('location: coachprofile.php?msg3=success');
                  }
                  else{
                    // Redirect to the coachprofile.php page with a success message
                    header('location: coachprofile.php?msg3=notsuccess');
                  }

                  }
                ?>
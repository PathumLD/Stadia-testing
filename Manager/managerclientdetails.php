<?php session_start(); ?>
<!-- <?php include("../linkDB.php"); //database connection function ?> -->


<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/manager.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/managersidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/managernavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

          <div class="content">

            

            <h1>Clients</h1>

            <table class="ps">
                <tr><td>    </td></tr>
               <tr><td> <form method="post">
                    <input type="text" name="search" class ="search" placeholder="Client Name...">
                    <input type="submit" name="go" value="search" id = "searchbtn">
                    <input type="submit" name="reset" value="reset" id = "resetbtn">
                </form></td></tr>
            </table>

            <table class="table">

                <tr>

                <th>NIC</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>DoB</th>
                <th>Emergency Contact</th>
                <th>Emergency Contact Name</th>  

                </tr>

                <?php
                    $query = "SELECT fname, lname, NIC, phone, dob, emphone, emname, email
                    FROM users WHERE type = 'client' ";

                    if (!$linkDB) {
                            die('Connection failed: ' . mysqli_connect_error());
                        }

                        if (isset($_POST['go'])) {
                            $search = $_POST['search'];
                        } else {
                            $search = null;
                        }

                        if ($search) {
                            $query = "SELECT * FROM users WHERE fname LIKE '%$search%'";
                        } elseif ($search) {
                            $query = "SELECT * FROM users WHERE NIC LIKE '%$search%'";
                        } else {
                            $query = "SELECT * FROM users";
                        }
                    $res = mysqli_query($linkDB, $query); 
                            if($res == TRUE) 
                            {
                                $count = mysqli_num_rows($res); //calculate number of rows
                                if($count>0)
                                {
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        $nic=$rows['NIC'];
                                        $name=$rows['fname'] . ' ' . $rows['lname'];
                                        $phone=$rows['phone'];
                                        $email=$rows['email'];
                                        $dob=$rows['dob'];
                                        $ephone=$rows['emphone'];
                                        $ename=$rows['emname'];
                                        
                                    ?>
                                    <tr>
                                                <td><?php echo $nic; ?> </td>
                                                <td><?php echo $name; ?> </td>
                                                <td><?php echo $phone; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $dob; ?></td>
                                                <td><?php echo $ephone; ?></td>
                                                <td><?php echo $ename; ?></td>
                                                
                                                
                                            </tr>
                                            <?php
                                    }
                                }    

                            }  
                    ?>


            </table>

          </div>

        </div>

    </div>

    <footer>
        <div class="foot">
          <?php include("../include/footer.php"); ?>
        </div>
    </footer> 

</section>

</body>
</html>

<script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;
        
        for (i = 0; i < dropdown.length; i++) {
          dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
              dropdownContent.style.display = "none";
            } else {
              dropdownContent.style.display = "block";
            }
          });
        }
</script>
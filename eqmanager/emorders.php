<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?> 

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/eqmanager/emorders.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/emsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/emnavbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

            <h1>Orders</h1>

            <div class="content">

                <table id="searchtable">
                    <tr>
                        <td>
                            <form method="post">
                                <input type="text" name="search" class="search" onfocus="(this.type = 'date')" placeholder="Search by Date">
                                <input type="submit" name="go" value="Search" id="searchbtn">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="text" name="name_search" class="search" id="name_search" placeholder="Search by Name">
                                <input type="submit" name="go2" value="Search" id="searchbtn">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="text" name="item_search" class="search" id="item_search" placeholder="Search by item">
                                <input type="submit" name="go3" value="Search" id="searchbtn">
                                <a href="emorders.php"><input type="submit" value="reset" id = "resetbtn"></a>
                            </form>
                        </td>
                    </tr>
                </table>

            <div class="left">

                <h3>To be Supplied </h3>

                <table class="table">

                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Client Name</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Supplied</th>
                    </tr>

                    <?php
                        if(isset($_POST['go'])){
                            $search = $_POST['search'];
                            $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                                    FROM orders o
                                    LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                    LEFT JOIN users u ON u.email = o.email
                                    WHERE o.date = '$search' AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 0
                                    ORDER BY o.date ASC ";
                        }

                        else if(isset($_POST['go2'])){
                            $name_search = $_POST['name_search'];
                            $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                            FROM orders o
                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                            LEFT JOIN users u ON u.email = o.email
                            WHERE o.date >= CURDATE() AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 0 AND CONCAT(u.fname, ' ', u.lname) LIKE '%$name_search%' 
                            ORDER BY o.date ASC ";
                        }

                        else if(isset($_POST['go3'])){
                            $item_search = $_POST['item_search'];
                            $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                            FROM orders o
                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                            LEFT JOIN users u ON u.email = o.email
                            WHERE o.date >= CURDATE() AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 0 AND e.itemname LIKE '%$item_search%' 
                            ORDER BY o.date ASC ";
                        }

                        else{
                            $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                            FROM orders o
                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                            LEFT JOIN users u ON u.email = o.email
                            WHERE o.date >= CURDATE() AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 0 AND o.type = 'equipment'
                            ORDER BY o.date ASC ";
                        }
   

                        $res = mysqli_query($linkDB, $query); 
                        if($res == TRUE) 
                        {
                            $count = mysqli_num_rows($res); //calculate number of rows
                            if($count>0)
                            {
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    $id=$rows['id'];

                                    //get the current date
                                    $currentDate = date("Y-m-d");
                                    
                                    //calculate the difference between the order date and the current date
                                    $orderDate = strtotime($rows["date"]);
                                    $currentDateTime = strtotime($currentDate);
                                    $diff = $orderDate - $currentDateTime;
                                    $daysDiff = round($diff / (60 * 60 * 24));
                                    
                                    //disable the submit button if the order date is less than or equal to the current date
                                    $disabled = ($daysDiff <= 0) ? 'disabled' : '';

                                    echo "<tr id='row__$id'>
                                            <td>" . $rows["date"]. "</td>
                                            <td>" . date('H:i', strtotime($rows["time"])). "</td>
                                            <td>" . $rows["name"]. "</td>
                                            <td>" . $rows["itemname"]. "</td>
                                            <td>" . $rows["quantity"]. "</td>
                                            <td>
                                                <form method='post'>
                                                    <input type='hidden' name='supply_id' value='$id'>
                                                    <button class='submit-button' $disabled><i class='fa fa-check'></i></button>
                                                </form>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "0 results";
                            }
                        }  
                    ?>

                    <?php
                        if(isset($_POST['supply_id'])) {
                            $order_id = $_POST['supply_id'];
                            $query = "UPDATE orders SET s_r = 1 WHERE id = '$order_id'";
                            $res = mysqli_query($linkDB, $query);

                            if ($res==TRUE)
                            {
                                echo "<script>window.location.href='emorders.php'; </script>";
                            }
                            else
                            {
                                echo "<script>window.location.href='emorders.php'; </script>";
                            }
                        }
                    ?>

                </table>

            </div>

            <div class="right">
                <div class="top">

                <h3>To be Returned</h3>

                <table class="table">

                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Client Name</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Returned</th>
                        </tr>

                        <?php
                            if(isset($_POST['go'])){
                                $search = $_POST['search'];
                                $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                                            FROM orders o
                                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                            LEFT JOIN users u ON u.email = o.email
                                            WHERE o.date = '$search' AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 1
                                            ORDER BY o.date ASC ";
                            }
    
                            else if(isset($_POST['go2'])){
                                $name_search = $_POST['name_search'];
                                $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                                            FROM orders o
                                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                            LEFT JOIN users u ON u.email = o.email
                                            WHERE o.date >= CURDATE() AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 1 AND CONCAT(u.fname, ' ', u.lname) LIKE '%$name_search%' 
                                            ORDER BY o.date ASC ";
                            }
    
                            else if(isset($_POST['go3'])){
                                $item_search = $_POST['item_search'];
                                $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                                            FROM orders o
                                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                            LEFT JOIN users u ON u.email = o.email
                                            WHERE o.date >= CURDATE() AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 1 AND e.itemname LIKE '%$item_search%' 
                                            ORDER BY o.date ASC ";
                            }
    
                            else{
                                $query = "SELECT o.id, o.date, o.time, e.itemname, o.quantity, CONCAT(u.fname, ' ', u.lname) as name
                                            FROM orders o
                                            LEFT JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
                                            LEFT JOIN users u ON u.email = o.email
                                            WHERE o.date >= CURDATE() AND o.type = 'equipment' AND o.status = 1 AND o.s_r = 1 AND o.type = 'equipment'
                                            ORDER BY o.date ASC ";
                            }

                            $res = mysqli_query($linkDB, $query); 
                            if($res == TRUE) 
                            {
                                $count = mysqli_num_rows($res); //calculate number of rows
                                if($count>0)
                                {
                                    while($rows=mysqli_fetch_assoc($res))
                                    {
                                        $id=$rows['id'];

                                       //get the current date
                                        $currentDate = date("Y-m-d");
                                        
                                        //calculate the difference between the order date and the current date
                                        $orderDate = strtotime($rows["date"]);
                                        $currentDateTime = strtotime($currentDate);
                                        $diff = $orderDate - $currentDateTime;
                                        $daysDiff = round($diff / (60 * 60 * 24));
                                        
                                        //disable the submit button if the order date is less than or equal to the current date
                                        $disabled = ($daysDiff <= 0) ? 'disabled' : '';

                                        echo "<tr id='row__$id'>
                                                <td>" . $rows["date"]. "</td>
                                                <td>" . date('H:i', strtotime($rows["time"])). "</td>
                                                <td>" . $rows["name"]. "</td>
                                                <td>" . $rows["itemname"]. "</td>
                                                <td>" . $rows["quantity"]. "</td>
                                                <td>
                                                    <form method='post'>
                                                        <input type='hidden' name='order_id' value='$id'>
                                                        <button class='submit-button' $disabled><i class='fa fa-check'></i></button>
                                                    </form>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                            }  
                        ?>

                        <?php
                        if(isset($_POST['order_id'])) {
                            $order_id = $_POST['order_id'];
                            $query = "UPDATE orders SET s_r = 2 WHERE id = '$order_id'";
                            $res = mysqli_query($linkDB, $query);

                            if ($res==TRUE)
                            {
                                echo "<script>window.location.href='emorders.php'; </script>";
                            }
                            else
                            {
                                echo "<script>window.location.href='emorders.php'; </script>";
                            }
                        }
                        ?>

                    </table>
                </div>

            </div>

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
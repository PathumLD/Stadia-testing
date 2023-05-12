<?php include("../linkDB.php"); //database connection function ?>


<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Stadia </title>

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/supplier.css">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../include/javascript.php'); ?>
    <?php include('../include/styles.php'); ?>

</head>

<body onload="initClock()">

    <div class="sidebar">

        <?php include('../include/suppliersidebar.php'); ?>

    </div>

    <section class="home-section">

        <nav>

            <?php include('../include/suppliernavbar.php'); ?>

        </nav>

        <div class="home-content">


            <div class="main-content">

                <div class="class">
                    <h1> My Orders</h1>

                    <table class="table" id="orders">

                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // execute the MySQL query to fetch the data
                            $query = "SELECT * FROM suppliermyorders";
                            $result = mysqli_query($linkDB, $query);

                            // loop through your orders and display them in the table
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['OrderId'] . '</td>';
                                echo '<td>' . $row['Date'] . '</td>';
                                echo '<td>' . $row['Quantity'] . '</td>';
                                echo '<td>' . $row['Amount'] . '</td>';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>


                    <!-- <?php
                    // $query = "SELECT * FROM  suppliermyorders";
                    // $res = mysqli_query($linkDB, $query);
                    // if ($res == TRUE) {
                    //     $count = mysqli_num_rows($res); //calculate number of rows
                    //     if ($count > 0) {
                    //         while ($rows = mysqli_fetch_assoc($res)) {
                    //             $OrderId = $rows['OrderId'];
                    //             $Date = $rows['Date'];
                    //             $Quantity = $rows['Quantity'];
                    //             $Amount = $rows['Amount'];
                    //             ?>
                    //             <tr>
                    //                 <td>
                    //                     <?php echo $OrderId; ?>
                    //                 </td>
                    //                 <td>
                    //                     <?php echo $Date; ?>
                    //                 </td>
                    //                 <td>
                    //                     <?php echo $Quantity; ?>
                    //                 </td>
                    //                 <td>
                    //                     <?php echo $Amount; ?>
                                    </td>
                                    

                                </tr>
                                <?php
                                //         }
                                //     }
                                
                                // }
                                // ?> -->


                </div>
            </div>

        </div>

        </div>

        <footer>
            <div class="foot">
                <span>Created By <a href="#">Stadia.</a> | &#169; 2023 All Rights Reserved</span>
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
        dropdown[i].addEventListener("click", function () {
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
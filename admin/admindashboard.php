
<?php include("../linkDB.php"); //database connection function 

/*queries for the boxes*/
//booked slots
$tb1 = "SELECT * FROM slots_badminton1 WHERE `start_event` >= CURRENT_DATE AND `start_event`<= CURRENT_DATE+7";
$tb2 = "SELECT * FROM slots_badminton2 WHERE `start_event` >= CURRENT_DATE AND `start_event`<= CURRENT_DATE+7";
$tb3 = "SELECT * FROM slots_basketball WHERE `start_event` >= CURRENT_DATE AND `start_event`<= CURRENT_DATE+7";
$tb4 = "SELECT * FROM slots_volleyball WHERE `start_event` >= CURRENT_DATE AND `start_event`<= CURRENT_DATE+7";
$tb5 = "SELECT * FROM slots_tennis WHERE `start_event` >= CURRENT_DATE AND `start_event`<= CURRENT_DATE+7";
$tb6 = "SELECT * FROM slots_swimming WHERE `start_event` >= CURRENT_DATE AND `start_event`<= CURRENT_DATE+7";
$r1 = mysqli_query($linkDB, $tb1);
$r_1 = mysqli_num_rows($r1);
$r2 = mysqli_query($linkDB, $tb2);
$r_2 = mysqli_num_rows($r2);
$r3 = mysqli_query($linkDB, $tb3);
$r_3 = mysqli_num_rows($r3);
$r4 = mysqli_query($linkDB, $tb4);
$r_4 = mysqli_num_rows($r4);
$r5 = mysqli_query($linkDB, $tb5);
$r_5 = mysqli_num_rows($r5);
$r6 = mysqli_query($linkDB, $tb6);
$r_6 = mysqli_num_rows($r6);
$booked = $r_1 + $r_2 + $r_3 + $r_4 + $r_5 + $r_6;


//cancelled slots
$tb1="SELECT * FROM slots_badminton1 WHERE status = 0 AND start_event BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$tb2="SELECT * FROM slots_badminton2  WHERE status = 0 AND start_event BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$tb3="SELECT * FROM slots_basketball WHERE status = 0 AND start_event BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$tb4="SELECT * FROM slots_volleyball WHERE status = 0 AND start_event BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$tb5="SELECT * FROM slots_tennis WHERE status = 0 AND start_event BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$tb6="SELECT * FROM slots_swimming WHERE status = 0 AND start_event BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$c1 = mysqli_query($linkDB, $tb1);
$c_1 = mysqli_num_rows($c1);
$c2 = mysqli_query($linkDB, $tb2);
$c_2 = mysqli_num_rows($c2);
$c3 = mysqli_query($linkDB, $tb3);
$c_3 = mysqli_num_rows($c3);
$c4 = mysqli_query($linkDB, $tb4);
$c_4 = mysqli_num_rows($c4);
$c5 = mysqli_query($linkDB, $tb5);
$c_5 = mysqli_num_rows($c5);
$c6 = mysqli_query($linkDB, $tb6);
$c_6 = mysqli_num_rows($c6);
$cancelled = $c_1 + $c_2 + $c_3 + $c_4 + $c_5 + $c_6;

//total no of members

$sql = "SELECT COUNT(*) as count FROM users WHERE MONTH(datetime) = MONTH(CURRENT_DATE()) AND YEAR(datetime) = YEAR(CURRENT_DATE())";
$result = mysqli_query($linkDB, $sql);
$count = mysqli_fetch_assoc($result)['count'];

//total complaints
$totalComplaintsQuery = "SELECT COUNT(*) AS total FROM complaints WHERE MONTH(datetime) = MONTH(CURRENT_DATE()) AND YEAR(datetime) = YEAR(CURRENT_DATE())";
$totalComplaintsResult = mysqli_query($linkDB, $totalComplaintsQuery);
$totalComplaints = mysqli_fetch_assoc($totalComplaintsResult)['total'];

/*chart start*/

// Retrieve data from the database
$sql = "SELECT quantity, itemname FROM equipment";
$result = mysqli_query($linkDB, $sql);

// Initialize empty arrays to hold the data
$itemNames = array();
$quantities = array();
$colors = array(
    'rgba(255, 99, 132, 0.8)',
    'rgba(54, 162, 235, 0.8)',
    'rgba(255, 206, 86, 0.8)',
    'rgba(75, 192, 192, 0.8)',
    'rgba(153, 102, 255, 0.8)',
    'rgba(255, 159, 64, 0.9)'
);

// Perform database query
$sql = "SELECT e.itemname, SUM(o.quantity) AS ordered_quantity, e.quantity - SUM(o.quantity) AS remaining_quantity
FROM orders o
JOIN equipment e ON o.product_id = e.itemid AND o.type = 'equipment'
GROUP BY e.itemname";


$result = mysqli_query($linkDB, $sql);

// Set up chart data
$labels = array();
$orderedData = array();
$remainingData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['itemname'];
    $orderedData[] = $row['ordered_quantity'];
    $remainingData[] = $row['remaining_quantity'];
}


// Loop through the result set and store the data in the arrays
$i = 0;

// Loop through the result set and store the data in the arrays
while ($row = mysqli_fetch_assoc($result)) {
    $itemNames[] = $row['itemname'];
    $quantities[] = $row['quantity'];
    $i++;
}



// // The pie chart
// // Retrieve data from database
$query = "SELECT r.itemname, SUM(o.quantity) AS ordered_quantity
FROM orders o
JOIN (
  SELECT itemid, itemname FROM refreshments_snacks
  UNION ALL
  SELECT itemid, itemname FROM refreshments_drinks
) r ON o.product_id = r.itemid AND (o.type = 'drink' OR o.type='snack') 
GROUP BY r.itemname";


$result = mysqli_query($linkDB, $query);

$data = array();
$colors = array(
    'rgba(255, 99, 132, 0.9)',
    'rgba(54, 162, 235, 0.9)',
    'rgba(255, 206, 86, 0.9)',
    'rgba(75, 192, 192, 0.9)',
    'rgba(153, 102, 255, 0.9)',
    'rgba(255, 159, 64, 0.9)'
);


$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'label' => $row['itemname'],
        'value' => $row['ordered_quantity'],
        'color' => $colors[$i]
    );
    $i++;
    if ($i == count($colors)) {
        $i = 0;
    }
}



?>


<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Stadia </title>

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link rel="stylesheet" href="../css/admin.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../include/javascript.php'); ?>
    <?php include('../include/styles.php'); ?>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
            text-align: center;
            border: #6d9976 2px solid;
            border-radius: 20px;

        }


        .parent-container {
            display: flex;
            justify-content: flex-end;
        }

        .boxes {
            background-color: #fff;
            border: 1px solid #ccc;
            max-width: auto;
            padding: 20px;
            border-radius: 12px;
            width: 26%;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            height: 372px;

        }

        .left-box {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            border: 1px solid #ccc;
            max-width: auto;
            padding: 20px;
            border-radius: 12px;
            width: 70%;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin-left: 16px;
            height: 385px;
            margin-top: -403px;
            
        }

        td,
        th {
            padding: 8px;
            text-align: left;
        }



        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body onload="initClock()">

    <div class="sidebar">

        <?php include('../include/adminsidebar.php'); ?>

    </div>

    <section class="home-section">

        <nav>

            <?php include('../include/adminnavbar.php'); ?>

        </nav>
        <div class="home-content">


            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Booked Slots</div>
                        <div class="number">
                            <?php echo $booked; ?>
                        </div>
                        <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">For this week</span>
                        </div>
                    </div>
                    <i class='bx bx-calendar-alt'></i>
                </div>
                
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Cancelled slots</div>
                    <div class="number"><?php echo $cancelled; ?></div>
                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">For this week</span>
                    </div>
                </div>
                <i class='bx bx-calendar-x'></i>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Members</div>
                    <div class="number"><?php echo $count; ?></div>
                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">For this month</span>
                    </div>
                </div>
                <i class='bx bx-calendar-check'></i>
            </div>
            <div class="box" style="padding-top: 15px; width: 327px;">
                    <div class=" right-side">
                    <div class="box-topic">Total complaints</div>
                    <div class="number"><?php echo $totalComplaints; ?></div>
                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">For this month</span>
                    </div>
                </div>
                <i class='bx bx-calendar-plus'></i>
            </div>
        </div>
        </div>
        </div>
        </div>
        <div class="parent-container">
            <div class="boxes">

                <div class="title">Users of the system</div>
                <div style=" height:300px; overflow: auto;">

                <?php
                // Query to retrieve the logged in users and their types
                $query = "SELECT fname, lname, type FROM users WHERE MONTH(datetime) = MONTH(CURRENT_DATE()) AND YEAR(datetime) = YEAR(CURRENT_DATE())";

                // Execute the query
                $result = mysqli_query($linkDB, $query);

                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    // Start the table
                    echo "<table>";
                    echo "<tr><th>#</th><th>Name</th><th>Type</th></tr>";

                    // Initialize the counter variable
                    $i = 1;

                    // Loop through the results and display them in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "</tr>";
                        $i++;
                    }

                    // End the table
                    echo "</table>";
                } else {
                    // Display a message if there are no results
                    echo "No users currently logged in.";
                }

                // Close the database connection
                mysqli_close($linkDB);

                ?>
            </div>
        </div>
        </div>

        <div class="left-box">
            <div class=" title">Equipment Summary
                <?php $currentDate = date('F j, Y');
                echo "<p> for $currentDate</p>"; ?><canvas id="myChart" style="width:100%;"></canvas>
            </div>
            <script>
                // Generate chart
                $ctx = document.getElementById('myChart').getContext('2d');
                $chart = new Chart($ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [
                            {
                                label: 'Ordered Quantity',
                                data: <?php echo json_encode($orderedData); ?>,
                                backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                borderColor: 'rgba(255, 0, 0, 0.7)',
                                borderWidth: 1
                            },
                            {
                                label: 'Remaining Quantity',
                                data: <?php echo json_encode($remainingData); ?>,
                                backgroundColor: 'rgba(0, 0, 255, 0.5)',
                                borderColor: 'rgba(0, 0, 255, 0.7)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>

        

            <div class=" title">Refreshment Order Summary<canvas id="myChart2" style="width:100%;height:80%"></canvas>
            </div>


            <script>
                var ctx = document.getElementById('myChart2').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [
                                <?php foreach ($data as $item) {
                                    echo $item['value'] . ',';
                                } ?>
                            ],
                            backgroundColor: [
                                <?php foreach ($data as $item) {
                                    echo "'" . $item['color'] . "',";
                                } ?>
                            ]
                        }],
                        labels: [
                            <?php foreach ($data as $item) {
                                echo "'" . $item['label'] . "',";
                            } ?>
                        ]
                    },

                    options: {
                        title: {
                            display: true,

                        }
                    }
                });
            </script>



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
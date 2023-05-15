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

          

                <h1>Complaints</h1>

            <div class="content">

                
                <div class="all">
                    
                    <h4> Complaints </h4>

                    <div class = "data-table">

                        <table class="table-nh">

                            <tr>
                            <th>Date</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>More Details</th>
                            <th>Verify</th>

                            </tr>

                            <?php


        // Fetch classes with handled=0
        $sql = "SELECT * FROM complaints WHERE handled = 3";
        $result = $linkDB->query($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . date('Y-m-d H:i', strtotime($row['datetime'])) . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["subject"] . "</td>";
                echo "<td>" . $row["details"] . "</td>";
                
                echo "<td><form method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><button class='btn-new' type='submit' name='verify-n'><i class='fa fa-check' aria-hidden='true'></i></button>
            </form></td>";
echo "</tr>";

            }
        
            echo "</table>";
        } else {
            echo "No classes to be verified.";
        }

        // Verify button logic
        if (isset($_POST['verify-n'])) {
            $id = $_POST['id'];
            $sql = "UPDATE complaints SET handled = 4 WHERE id = '$id'";
            mysqli_query($linkDB, $sql);
        
        
        }
?>

                        </table>
                    
                    </div>

                </div>

                <div class="handled">

                    <h4> Handled Complaints </h4>

                    <div class = "frame-h">

                        <table class="table-h">
                            <tr>
                            <th>Subject</th>
                            <th>More Details</th>
                            <th>Action</th>
                            </tr>

                            <?php


// Fetch classes with handled=0
$sql = "SELECT * FROM complaints WHERE handled = 4";
$result = $linkDB->query($sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        echo "<tr>";
        echo "<td>" . $row["subject"] . "</td>";
        echo "<td>" . $row["details"] . "</td>";
        echo "<td><form method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><button class='btn-new' type='submit' name='verify-h'><i class='fa fa-check' aria-hidden='true'></i></button>
        </form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No handled complaints.";
}
 // Verify button logic
if (isset($_POST['verify-h'])) {
  $id = $_POST['id'];
  $sql = "UPDATE complaints SET handled = 5 WHERE id = '$id'";
  mysqli_query($linkDB, $sql);


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

<script>
function confirmRowData(id) {
  // Get the row with the booking data
  var row = document.getElementById('row_' + id);

  // Get the booking data from the row
  var complaintID = row.cells[0].innerHTML;
  var subject = row.cells[1].innerHTML;
  var details = row.cells[2].innerHTML;

  // Create a custom confirm box
  var confirmBox = document.createElement('div');
  confirmBox.classList.add('confirm-box');
  confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2><p>Order Details:</p><ul><li>Date: ' + complaintID + '</li><li>Item: ' + subject + '</li><li>Ordered Quantity: ' + details + '</li></ul><h4><p>NOTE: We will be only refunding 75% of your payment per each cancellation</p></h4><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

  // Add the confirm box to the page
  document.body.appendChild(confirmBox);

  // Add event listeners to the confirm and cancel buttons
  var confirmButton = document.getElementById('confirm-button');
  var cancelButton = document.getElementById('cancel-button');
  confirmButton.addEventListener('click', function() {
    // Redirect to the clientcancelequipment.php page
    window.location.href = 'managerdismisscomplaint.php?id=' + id;
  });
  cancelButton.addEventListener('click', function() {
    // Remove the confirm box from the page
    document.body.removeChild(confirmBox);
  });
}
</script>
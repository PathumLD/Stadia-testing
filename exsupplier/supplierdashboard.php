<?php session_start(); ?>
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

                <h1>Records</h1>

                <table class="table" id="products-refreshments">
                    <tr>
                        <?php


                        // Retrieve drinks data
                        $drinks_query = "SELECT itemid,itemname, price, image FROM refreshments_drinks WHERE status = 1";
                        $drinks_result = mysqli_query($linkDB, $drinks_query);

                        // Display drinks data in table
                        while ($row = mysqli_fetch_assoc($drinks_result)) {
                            $id = $row['itemid'];
                            echo "<td itemid='row_$id' style='border:none;'>
                            <div style='position:relative'>
                            <img src='../products/" . $row['image'] . "'><br>" .
                                $row['itemname'] . "<br><span style='font-size:16px;'>Rs. " . $row['price'] . "</span><br>
                                <form method='post' action='supplierdeleteitem1.php' style='display: inline-block;'> 
                                <input type='hidden' name='itemid' value='$id'> 
                                <button class='submit-button'  style=' border: none; background-color:white;' type='submit' name='delete'><i class='fa fa-trash'></i></button> 
                                </form>
                            <button class='update-button' style=' border: none; background-color:white; font-size:19px;'  onclick=\"openPopup1('" . $row["itemid"] . "', '" . $row["itemname"] . "', '" . $row["price"] . "')\">
                            <i class='fa fa-pencil-square-o'></i></button> 
                            </div>
                        </td>";

                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        // Retrieve snacks data
                        $snacks_query = "SELECT itemid,itemname, price, image FROM refreshments_snacks WHERE status = 1";
                        $snacks_result = mysqli_query($linkDB, $snacks_query);

                        // Display snacks data in table
                        while ($row = mysqli_fetch_assoc($snacks_result)) {
                            $id = $row['itemid'];
                            echo "<td itemid='row_$id' style='border:none;'>
                            <div style='position:relative'>
                                <img src='../products/" . $row['image'] . "'><br>" .
                                $row['itemname'] . "<br><span style='font-size:16px;'>Rs. " . $row['price'] . "</span><br>
                                <form method='post' action='supplierdeleteitem2.php' style=' display: inline-block;'> 
                                <input type='hidden' name='itemid' value='$id'> 
                                <button class='submit-button' style='display: inline; border: none; background-color:white;' type='submit' name='delete'><i class='fa fa-trash'></i></button> 
                                </form>
                                <button class='update-button'   style='display: inline; border: none; background-color:white; font-size:19px;' onclick=\"openPopup2('" . $row["itemid"] . "', '" . $row["itemname"] . "', '" . $row["price"] . "')\">
                            <i class='fa fa-pencil-square-o'></i></button>
                            </div>
                        </td>";

                        }
                        ?>
                    </tr>
                    </tr>
                </table>
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


<!-- Popup to delete refreshment records - drinks -->
<script>
    function confirmRowData1(id) {
        // Get the row with the booking data
        var row = document.getElementById('row_' + id);

        // Get the booking data from the row
        var itemid = row.cells[0].innerHTML;
        var itemname = row.cells[1].innerHTML;
        var price = row.cells[2].innerHTML;

        // Create a custom confirm box
        var confirmBox = document.createElement('div');
        confirmBox.classList.add('confirm-box');
        confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2><p>Refreshment Details:</p><ul><li>Id: ' + itemid + '</li><li>Item: ' + itemname + '</li><li>Price: ' + price + '</li></ul><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

        // Add the confirm box to the page
        document.body.appendChild(confirmBox);

        // Add event listeners to the confirm and cancel buttons
        var confirmButton = document.getElementById('confirm-button');
        var cancelButton = document.getElementById('cancel-button');
        confirmButton.addEventListener('click', function () {
            // Redirect to the clientcancelequipment.php page
            window.location.href = 'supplierdeleteitem1.php?id=' + id;
        });
        cancelButton.addEventListener('click', function () {
            // Remove the confirm box from the page
            document.body.removeChild(confirmBox);
        });
    }
</script>

<!-- Popup to update refreshment records - drinks-->

<div id="refreshment-popup" class="popup_u">
    <div class="popup_u-content">
        <span class="close_u" onclick="closePopup1()">&times;</span>
        <h2>Update Refreshment</h2>
        <form action="supplierupdateitem1.php" method="post">

            <input type="hidden" id="itemid" name="itemid">
            <label for="itemname">Item Name:</label>
            <input type="text" id="itemname" name="itemname" class="input-field">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" class="input-field">
            <input type="submit" value="Update Refreshments" class="btn">
        </form>

    </div>
</div>

<script>
    function openPopup1(itemid, itemname, price) {
        // Set the ID in the hidden input field
        document.getElementById('itemid').value = itemid;

        // Set the existing subject and details in the input fields
        document.getElementById('itemid').value = itemid;
        document.getElementById('itemname').value = itemname;
        document.getElementById('price').value = price;

        // Show the popup
        document.getElementById('refreshment-popup').style.display = 'block';
    }

    function closePopup1() {
        // Hide the popup
        document.getElementById('refreshment-popup').style.display = 'none';
    }
</script>


<!-- Popup to delete refreshment records - snacks -->

<script>
    function confirmRowData2(id) {
        // Get the row with the booking data
        var row = document.getElementById('row_' + id);

        // Get the booking data from the row
        var itemid = row.cells[0].innerHTML;
        var itemname = row.cells[1].innerHTML;
        var price = row.cells[2].innerHTML;

        // Create a custom confirm box
        var confirmBox = document.createElement('div');
        confirmBox.classList.add('confirm-box');
        confirmBox.innerHTML = '<h2>Confirm Cancellation?</h2><p>Refreshment Details:</p><ul><li>Id: ' + itemid + '</li><li>Item: ' + itemname + '</li><li>Price: ' + price + '</li></ul><button id="confirm-button">Confirm</button><button id="cancel-button">Cancel</button>';

        // Add the confirm box to the page
        document.body.appendChild(confirmBox);

        // Add event listeners to the confirm and cancel buttons
        var confirmButton = document.getElementById('confirm-button');
        var cancelButton = document.getElementById('cancel-button');
        confirmButton.addEventListener('click', function () {
            // Redirect to the clientcancelequipment.php page
            window.location.href = 'supplierdeleteitem2.php?id=' + id;
        });
        cancelButton.addEventListener('click', function () {
            // Remove the confirm box from the page
            document.body.removeChild(confirmBox);
        });
    }
</script>


<!-- Popup to update refreshment records - snacks-->

<div id="refreshment-popup" class="popup_u">
    <div class="popup_u-content">
        <span class="close_u" onclick="closePopup2()">&times;</span>
        <h2>Update Refreshment</h2>
        <form action="supplierupdateitem1.php" method="post">

            <input type="hidden" id="itemid" name="itemid">
            <label for="itemname">Item Name:</label>
            <input type="text" id="itemname" name="itemname" class="input-field">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" class="input-field">
            <input type="submit" value="Update Refreshments" class="btn">
        </form>

    </div>
</div>

<script>
    function openPopup2(itemid, itemname, price) {
        // Set the complaint ID in the hidden input field
        document.getElementById('itemid').value = itemid;

        // Set the existing subject and details in the input fields
        document.getElementById('itemid').value = itemid;
        document.getElementById('itemname').value = itemname;
        document.getElementById('price').value = price;

        // Show the popup
        document.getElementById('refreshment-popup').style.display = 'block';
    }

    function closePopup2() {
        // Hide the popup
        document.getElementById('refreshment-popup').style.display = 'none';
    }
</script>
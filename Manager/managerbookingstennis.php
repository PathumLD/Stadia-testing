<?php session_start();?>
<?php include("../linkDB.php"); //database connection function ?> 

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/calendar.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../include/javascript.php'); ?>
    <?php include('../include/styles.php'); ?>

    <link rel="stylesheet" href="../css/manager.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <script>
      $(document).ready(function() {
          var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'agendaWeek,month'
            },
            defaultView: 'agendaWeek',
            events: 'bookingstennisload.php',
            views: {
                month: {
                  selectable: false
                },
                agenda: {
                  slotDuration: '01:00:00',
                  slotLabelInterval: '01:00:00',
                  minTime: '07:00:00',
                  maxTime: '22:00:00'
                }
            },
            

          });
      });
    </script>


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

                  

                  <h1>Bookings - Tennis Court</h1>

                  <div class="content">

                  <div class="container">
                    <div id="calendar"></div>
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
Footer
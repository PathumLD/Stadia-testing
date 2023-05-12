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
            events: 'bookingsvolleyballload.php',
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

            selectable:true,
            selectHelper:true,
            select: function(start, end, allDay)
            {
              var today = moment().startOf('day');
              var now = moment();

              // check if the selected start time is before the current time + 30 minutes
              var threshold = moment().add(30, 'minutes');
              if (start < threshold) {
                alert("Cannot add booking for past or current time slots.");
                return;
              }

              // check if the selected start time is within the next 3 months
              var maxDate = moment().add(3, 'months');
              if (start > maxDate) {
                alert("Cannot add booking more than 3 months in advance.");
                return;
              }

              var numSlots = parseInt(prompt("Enter the number of consecutive slots you want to book:"));
              if (isNaN(numSlots) || numSlots <= 0) {
                alert("Please enter a valid number of slots.");
                return;
              }

              var title = prompt("Enter Your Name");
              if (!title) {
                return;
              }

              var slotStart = moment(start).startOf('hour');
              var slotEnd = moment(slotStart).add(numSlots, 'hours').startOf('hour');

              // check if any of the slots in between the selected start and end times are already booked
              var eventOverlap = false;
              calendar.fullCalendar('clientEvents', function(existingEvent) {
                if (existingEvent.start < slotEnd && existingEvent.end > slotStart) {
                  eventOverlap = true;
                  return false;
                }
              });

              if (eventOverlap) {
                alert("Cannot book consecutive slots. A slot in between is already booked.");
                return;
              }

              for (var i = 0; i < numSlots; i++) {
                var slotTitle = title + ' - Slot ' + (i + 1) + ' of ' + numSlots;
                var slotStartDate = $.fullCalendar.formatDate(slotStart, "Y-MM-DD HH:mm:ss");
                var slotEndDate = $.fullCalendar.formatDate(moment(slotStart).add(1, 'hour'), "Y-MM-DD HH:mm:ss");

                $.ajax({
                  url:"bookingsbadminton1insert.php",
                  type:"POST",
                  data:{title:slotTitle, start:slotStartDate, end:slotEndDate},
                  success:function() {
                    calendar.fullCalendar('refetchEvents');
                  }
                });

                slotStart.add(1, 'hour');
              }

              alert("Slots booked successfully.");
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

                  

                  <h1>Bookings - Volleyball Court</h1>

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
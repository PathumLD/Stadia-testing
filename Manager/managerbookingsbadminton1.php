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

    <link rel="stylesheet" href="../css/calender.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <script>
      $(document).ready(function() {
          var loggedInUserEmail = "<?php echo $_SESSION['email']; ?>";
          var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'agendaWeek,month'
            },
            defaultView: 'agendaWeek',
            events: 'bookingsbadminton1load.php',
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

              var email = prompt("Enter the email associated with this booking:");
              if (!email) {
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
                  data:{title:slotTitle, start:slotStartDate, end:slotEndDate, email:email},
                  success:function() {
                    calendar.fullCalendar('refetchEvents');
                  }
                });

                slotStart.add(1, 'hour');
              }

              alert("Slots booked successfully.");
            },

            editable:true,
            eventResize:function(event)
            {
              if (event.email !== loggedInUserEmail) {
                alert("You are not authorized to edit this booking.");
                calendar.fullCalendar('refetchEvents');
                return;
              }
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.start.add(1, 'hour'), "Y-MM-DD HH:mm:ss");
                var title = event.title;
                var id = event.id;

                // check if the new start time is before the current time + 30 minutes
                var threshold = moment().add(30, 'minutes');
                if (event.start < threshold) {
                  alert("Cannot update booking for past or current time slots.");
                  calendar.fullCalendar('refetchEvents');
                  return;
                }

                // check if the new start time is within the next 3 months
                var maxDate = moment().add(3, 'months');
                if (event.start > maxDate) {
                  alert("Cannot update booking more than 3 months in advance.");
                  calendar.fullCalendar('refetchEvents');
                  return;
                }

                $.ajax({
                  url:"bookingsbadminton1update.php",
                  type:"POST",
                  data:{title:title, start:start, end:end, id:id},
                  success:function(){
                      calendar.fullCalendar('refetchEvents');
                      alert('Booking Update');
                  }
                })
            },

            eventDrop:function(event, delta, revertFunc)
              {
                if (event.email !== loggedInUserEmail) {
                  alert("You are not authorized to edit this booking.");
                  revertFunc();
                  return;
                }
                  var start = event.start.format("Y-MM-DD HH:mm:ss");
                  var end = event.end.format("Y-MM-DD HH:mm:ss");
                  var title = event.title;
                  var id = event.id;
                  
                  // check if the new start time is before the current time + 30 minutes
                  var threshold = moment().add(30, 'minutes');
                  if (event.start < threshold) {
                    alert("Cannot move bookings to past or current time slots.");
                    revertFunc();
                    return;
                  }

                  // check if the new start time is within the next 3 months
                  var maxDate = moment().add(3, 'months');
                  if (event.start > maxDate) {
                    alert("Cannot move bookings more than 3 months in advance.");
                    revertFunc();
                    return;
                  }

                  // check if the new slot is available
                  var newEventOverlap = false;
                  calendar.fullCalendar('clientEvents', function(existingEvent) {
                    if (existingEvent.id !== event.id && existingEvent.start < event.end && existingEvent.end > event.start) {
                      newEventOverlap = true;
                      return false;
                    }
                  });

                  if (newEventOverlap) {
                    alert("This slot is already booked. Please select another slot.");
                    revertFunc();
                    return;
                  }

                  // if the new slot is available, update the event's start and end time
                  $.ajax({
                    url:"bookingsbadminton1update.php",
                    type:"POST",
                    data:{title:title, start:start, end:end, id:id},
                    success:function(){
                        calendar.fullCalendar('refetchEvents');
                        alert('Booking Updated!');
                    }
                  });
              },

            eventClick:function(event)
              {
                if (loggedInUserEmail !== 'chamudisandu@gmail.com' && event.email !== loggedInUserEmail) {
            alert("You are not authorized to delete this booking.");
            return;
          }

          // check if the event start time is before the current time
          var threshold = moment();
          if (event.start < threshold) {
            alert("Cannot remove bookings from past time slots.");
            return;
          }

          // get today's date
          var today = moment().startOf('day');

          // check if the event start date is before today's date
          var eventDate = moment(event.start).startOf('day');
          if (eventDate < today) {
            alert("Cannot remove bookings from past dates.");
            return;
          }

          if (confirm("Are you sure you want to remove it?")) {
            var id = event.id;
            $.ajax({
              url: "bookingsbadminton1delete.php",
              type: "POST",
              data: { id: id },
              success: function () {
                calendar.fullCalendar('refetchEvents');
                alert("Booking Cancelled!");
              }
            })
          }
        },
        eventRender: function (event, element, view) {
          if (event.email === loggedInUserEmail) {
            $(element).css('background-color', '#3B6E51');
          }
        }
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

                  <?php $var = $_SESSION['email']; ?>

                  <h1>Bookings - Badminton Court 1</h1>

                  <div class="content">

                    <div class="segmented-control">
              
                      <input type="radio" name="radio2" value="1" id="tab-1" checked/>
                      <label for="tab-1" class= "segmented-control__1">
                        <p><a href="managerbookingsbadminton1.php">Court 1</a></p>
                      </label>
                                      
                      <input type="radio" name="radio2" value="2" id="tab-2" />
                      <label for="tab-2" class= "segmented-control__2">
                        <p><a href="managerbookingsbadminton2.php">Court 2</a></p>
                      </label>
                      
                      <div class="segmented-control__color"></div>
                    </div>

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
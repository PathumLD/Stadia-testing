<?php

//delete.php

if(isset($_POST["id"]))
{
 $linkDB = mysqli_connect('localhost', 'root', '', 'stadia-new');

 // Escape the id parameter to prevent SQL injection attacks
 $id = mysqli_real_escape_string($linkDB, $_POST['id']);

 // Update the status of the slot to cancelled
 $query = "UPDATE slots_badminton2 SET status = 3 WHERE id = '$id'";
 mysqli_query($linkDB, $query);

 // Retrieve the email addresses of clients who booked the cancelled slot
 $query = "SELECT DISTINCT email, DATE(start_event) AS cancelled_date
           FROM slots_badminton2
           WHERE status = 3 AND start_event >= NOW()";
 $result = mysqli_query($linkDB, $query);

 // Loop through the query result and insert a notification for each client who booked the cancelled slot
 while ($row = mysqli_fetch_assoc($result)) {
   $email = $row['email'];
   $cancelled_date = $row['cancelled_date'];
   $message = "All your bookings for $cancelled_date have been cancelled due to unavoidable reasons. Sorry for the inconvenience";
   $created_at = date('Y-m-d H:i:s');
   
   // Escape the variables before inserting them into the database to prevent SQL injection attacks
   $email = mysqli_real_escape_string($linkDB, $email);
   $message = mysqli_real_escape_string($linkDB, $message);
   $created_at = mysqli_real_escape_string($linkDB, $created_at);
   
   $query = "INSERT INTO notifications (email, message, created_at) VALUES ('$email', '$message', '$created_at')";
   mysqli_query($linkDB, $query);
 }
 
 mysqli_close($linkDB);
}
?>
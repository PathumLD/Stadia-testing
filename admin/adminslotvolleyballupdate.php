<?php

//update.php

$connect = new PDO('mysql:host=127.0.0.1:3300;dbname=stadia-new', 'root', '');

session_start(); // Start the session

if(isset($_POST["id"]))
{
 $query = "
 UPDATE slots_volleyball 
 SET title=:title, start_event=:start_event, end_event=:end_event 
 WHERE id=:id AND email=:email
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id'   => $_POST['id'],
   ':email' => $_SESSION['email'] // Check if the email address matches the one in the session
  )
 );
}

?>
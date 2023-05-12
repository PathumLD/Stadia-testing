<?php

//insert.php

$connect = new PDO('mysql:host=localhost;dbname=stadia-new', 'root', '');

session_start(); // Start the session

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO slots_basketball 
 (title, start_event, end_event, email) 
 VALUES (:title, :start_event, :end_event, :email)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':email' => $_SESSION['email'] // Use the email address from the session
  )
 );
}


?>
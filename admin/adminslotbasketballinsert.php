<?php

//insert.php

$connect = new PDO('mysql:host=127.0.0.1:3300;dbname=stadia-new', 'root', '');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO adminslotbasketball
 (day, start_time, end_time) 
 VALUES (:day, :start_time, :end_time)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':day'  => $_POST['day'],
   ':start_time' => $_POST['start_time'],
   ':end_time' => $_POST['end_time']
  )
 );
}
?>
<?php

//update.php

$connect = new PDO('mysql:host=127.0.0.1:3300;dbname=stadia-new', 'root', '');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE adminslottennis
 SET day=:day, start_time=:start_time, end_time=:end_time
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':day'  => $_POST['day'],
   ':start_time' => $_POST['start_time'],
   ':end_time' => $_POST['end_time'],
   ':id'   => $_POST['id']
  )
 );
}

?>
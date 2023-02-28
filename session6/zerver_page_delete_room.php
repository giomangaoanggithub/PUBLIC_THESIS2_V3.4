<?php

include 'zerver_entrance.php';

session_start();

error_reporting(0);

$room_name = $_POST["room_name"];
$room_code = $_POST["room_code"];
$email = $_SESSION["curr_email_user"];
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "UPDATE classrooms SET deletion = 1 WHERE room_name = '$room_name' AND room_code = '$room_code' AND owner_email = '$email'";

  // Prepare statement
  $stmt = $conn->prepare($sql);

  // execute the query
  $stmt->execute();

  // echo a message to say the UPDATE succeeded
  echo $stmt->rowCount() . " ROOM UPDATED successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
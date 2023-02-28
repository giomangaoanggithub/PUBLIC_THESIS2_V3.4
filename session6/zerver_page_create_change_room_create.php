<?php
//CHECKED
include 'zerver_entrance.php';

session_start();

error_reporting(0);

$room_name = $_POST["room_name"];
$room_code = $_POST["room_code"];
$email = $_SESSION["curr_email_user"];
$company = $_SESSION["teacher_company"];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO classrooms (room_name, room_code, owner_email, company_src, deletion)
  VALUES ('$room_name','$room_code', '$email', '$company', '0')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "ROOM CREATED";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
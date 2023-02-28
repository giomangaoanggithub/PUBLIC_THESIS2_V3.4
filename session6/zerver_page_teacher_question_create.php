<?php
//CHECKED
include 'zerver_entrance.php';

session_start();

error_reporting(0);

$question = $_POST["question"];
$auto = $_POST["autocheck"];

$email_input = $_SESSION["curr_email_user"];

$room = $_SESSION["teacher_curr_room"];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO created_questions (question, time_of_issue, due_date, owner_teacher, classroom_id, publish, checking_param)
  VALUES ('$question', 'current_timestamp()', '', '$email_input', '$room', '0', '$auto')";
  // use exec() because no results are returned
  $conn->exec($sql);
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
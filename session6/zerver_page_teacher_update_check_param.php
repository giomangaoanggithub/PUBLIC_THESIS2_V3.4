<?php

include 'zerver_entrance.php';

session_start();

error_reporting(0);

$param = $_POST["param"];
$q_id = $_POST["q_id"];
$email = $_SESSION["curr_email_user"];
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "UPDATE created_questions SET checking_param = '$param' WHERE question_id = $q_id AND owner_teacher = '$email'";

  // Prepare statement
  $stmt = $conn->prepare($sql);

  // execute the query
  $stmt->execute();

  // echo a message to say the UPDATE succeeded
  echo "UPDATED successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
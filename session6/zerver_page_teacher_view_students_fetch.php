<?php

include 'zerver_entrance.php';

session_start();

error_reporting(0);

$email_input = $_SESSION["curr_email_user"];
$room = $_SESSION["teacher_curr_room"];
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM (`teacher_student_connection` INNER JOIN `user_accounts` ON teacher_student_connection.student_email = user_accounts.email) INNER JOIN `classrooms` ON teacher_student_connection.room_name = classrooms.room_name WHERE teacher_email = '$email_input' AND room_id = '$room'");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;

?>
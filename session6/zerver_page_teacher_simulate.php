<?php
//CHECKED
include 'zerver_entrance.php';

session_start();

error_reporting(0);

$matter = $_POST["step"];
$email = $_SESSION["curr_email_user"];
$classroom = $_SESSION["teacher_curr_room"];
$question_id = "";

if($matter == "0"){
    $question = $_POST["question"];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO created_questions (question, time_of_issue, due_date, owner_teacher, classroom_id, publish, checking_param)
        VALUES ('$question', 'current_timestamp()', '0000-00-00 00:00:00', '$email', '$classroom', '0', '')";
        // use exec() because no results are returned
        $conn->exec($sql);
        // echo "created questions";
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
      
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT question_id FROM created_questions ORDER BY question_id DESC LIMIT 1");
        $stmt->execute();
    
        // set the resulting array to associative
        $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
        json_encode($result);
        $_SESSION["curr_question_id"] = $result[0]["question_id"];
    
        } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        }
    
}

else if ($matter == "1"){
    try {
        $question_id = $_SESSION["curr_question_id"];
        $arr_answers = $_POST["answers"];
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO student_answers (answer, question_id, owner_student, time_of_submission, grades, checked, system_confidence) VALUES ('".$arr_answers."', '$question_id', 'bot', CURRENT_TIMESTAMP, '0', '0', '-1')";
    
        $conn->exec($sql);
        // use exec() because no results are returned
    
        echo "SIMULATION READY";
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}


  $conn = null;

?>
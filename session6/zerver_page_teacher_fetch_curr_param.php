<?php

include 'zerver_entrance.php';

session_start();

error_reporting(0);

$q_id = $_POST["q_id"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT checking_param FROM created_questions WHERE question_id = '$q_id'");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);

    } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    }

?>
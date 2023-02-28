<?php

include 'zerver_entrance.php';

session_start();

error_reporting(0);

$cor_param = '';
$inc_param = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM created_questions WHERE question_id = '64'");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    // echo strpos($result[0]["checking_param"], "<&*>");

    for($x = 0; $x < strlen($result[0]["checking_param"]); $x++){
        if(strpos($result[0]["checking_param"], "<&*>") > $x){
            $inc_param .= $result[0]["checking_param"][$x];
        } else {
            $cor_param .= $result[0]["checking_param"][$x];
        }
    }

    $cor_param = array_values(array_filter(explode("<&*>", $cor_param)));
    $inc_param = array_values(array_filter(explode("<&^>", $inc_param)));

    // print_r($cor_param);
    // echo"<br><br>";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM student_answers WHERE question_id = '64'");
        $stmt->execute();
      
        // set the resulting array to associative
        $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    
        $text_inputs_arr = array();

        for($x = 0; $x < count($result); $x++){
            array_push($text_inputs_arr, $result[$x]["answer"]);
        }

        // print_r($text_inputs_arr); 
        //CORRECT AND INCORRECT IS READY TO CHECK THE REST OF ESSAYS
        //IF 0 to 20% then consider absolute wrong and beyond 20% and yet lower 45% will give another chance by the teacher to check it
        //and beyond 6
    
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}



$conn = null;
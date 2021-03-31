<?php
    $isSessionValid = $_SESSION["isSessionValid"];
    if(!$isSessionValid) {
        header('Location: ../hub.php');
    }
    
    //connection variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    $code = $_POST['action'];

    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //check connection
    if($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }

    $uname = $_SESSION["uName"];

    $sql = "SELECT notificationReference FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $references = $row["notificationReference"];
    }
    echo $references;
    $refs = explode(",", $references);
    //generate new string without code
    $newRefs = ",";
    for($i = 0; $i < count($refs); $i++) {
        if($refs[$i] !== $code) {
            $newRefs .= ",".$refs[$i];
        }
    }

    $sql = "UPDATE users SET notificationReference = '$newRefs' WHERE Username = '$uname'";
    $result = $conn->query($sql);

?>
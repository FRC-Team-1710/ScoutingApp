<?php
    session_start();
    $isSessionValid = $_SESSION["isSessionValid"];
    if(!$isSessionValid || $_SESSION["perms"] != 6) {
        header('Location: ../index.php');
    }

    //connection variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    $id = $_POST['action'];

    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //check connection
    if($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }

    $sql = "DELETE FROM feedback WHERE entryId = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

?>
<?php
    session_start();
    $isSessionValid = $_SESSION["isSessionValid"];
    if(!$isSessionValid || $_SESSION["perms"] != 6) {
        header('Location: ../index.php');
    }

    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }

    $id = $_POST['action'];

    $sql = "SELECT isRead FROM feedback WHERE entryId = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    while($row = $result->fetch_assoc()) {
        if($row["isRead"] == 1) {
            $sql = "UPDATE feedback SET isRead = 0 WHERE entryId = ?";
        } else {
            $sql = "UPDATE feedback SET isRead = 1 WHERE entryId = ?";
        }
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
        }
    }

?>
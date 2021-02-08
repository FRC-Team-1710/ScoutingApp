<?php
    session_start();
    $isSessionValid = $_SESSION["isSessionValid"];
    if(!$isSessionValid) {
        header('Location: ../../index.php');
    }
    if($_SESSION["perms"] != 1) {
        if($_SESSION["perms"] != 6) {
            header('Location: ../../hub.php');
        }
    }

    //Connection variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if($conn->connect_error) {
        die($conn->connect_error);
    }

    $id = $_POST["action"];
    $team = $_SESSION["Team"];

    if($id == 1) {
        $sql = "UPDATE authkeys SET Head = 'no' WHERE Team = ?";
    } else if($id == 2) {
        $sql = "UPDATE authkeys SET Assistant = 'no' WHERE Team = ?";
    } else if($id == 3) {
        $sql = "UPDATE authkeys SET Coach = 'no' WHERE Team = ?";
    } else if($id == 4) {
        $sql = "UPDATE authkeys SET Basic = 'no' WHERE Team = ?";
    } else if($id == 5) {
        $sql = "UPDATE authkeys SET Other = 'no' WHERE Team = ?";
    }
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There's an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $team);
        mysqli_stmt_execute($stmt);
    }
    $result = $conn->query($sql);
?>
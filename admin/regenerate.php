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

    //Generate random alphanumeric string
    $permittedChars = "0123456789abcdefghijklmnopqrstvuwxyz";
    $key = substr(str_shuffle($permittedChars), 0, 15);

    if($id == 1) {
        $sql = "UPDATE authkeys SET Head = ? WHERE Team = ?";
    } else if($id == 2) {
        $sql = "UPDATE authkeys SET Assistant = ? WHERE Team = ?";
    } else if($id == 3) {
        $sql = "UPDATE authkeys SET Coach = ? WHERE Team = ?";
    } else if($id == 4) {
        $sql = "UPDATE authkeys SET Basic = ? WHERE Team = ?";
    } else if($id == 5) {
        $sql = "UPDATE authkeys SET Other = ? WHERE Team = ?";
    }
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "si", $key, $team);
        mysqli_stmt_execute($stmt);
    }
?>
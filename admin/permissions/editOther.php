<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: ../index.php');
    }
    if($_SESSION["perms"] != 1) {
        if($_SESSION["perms"] != 6) {
            header('Location: ../hub.php');
        }
    }

    //Connection variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbName = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbName);
    //Check connection
    if($conn->connect_error) {
        die("Error: " . $conn->connect_error);
    }

    //Post varaibles
    $editSchedule = $_POST["editSchedule"];
    $broadcastMessages = $_POST["broadcastMessages"];
    $scout = $_POST["scout"];
    $viewData = $_POST["viewData"];
    $haveShekels = $_POST["haveShekels"];
    $viewStocks = $_POST["viewStocks"];

    $team = $_SESSION["Team"];

    //Generate permission number
    $newValue = 1000000;
    if($editSchedule == "on") {
        $newValue += 100000;
    }
    if($broadcastMessages == "on") {
        $newValue += 10000;
    }
    if($scout == "on") {
        $newValue += 1000;
    }
    if($viewData == "on") {
        $newValue += 100;
    }
    if($haveShekels == "on") {
        $newValue += 10;
    }
    if($viewStocks == "on") {
        $newValue += 1;
    }
    $_SESSION["newValue"] = $newValue;
    $sql = "UPDATE `permissions` SET Other = '$newValue' WHERE Team = '$team'";
    $result = $conn->query($sql);
    header('Location: other.php');
?>
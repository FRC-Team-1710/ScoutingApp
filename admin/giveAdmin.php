<?php
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    $perms = $_SESSION["perms"];
    if($sessionValid != true) {
        header('Location: ../index.php');
    } else if($perms != 1) {
        if($perms != 2) {
            header('Location: ../hub.php');
        }
    }

    $uname = $_POST["username"];
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($perms != 2) {
        $sql = "UPDATE users SET Permissions = 1 WHERE Username = '$uname'";
        $result = $conn->query($sql);
    }

    header('Location: index.php');
?>
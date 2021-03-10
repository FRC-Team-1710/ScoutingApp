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
    $amt = $_POST["amount"];
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

    if($_POST["transactionType"] == 0) {
        $sql = "SELECT Shekels FROM users WHERE Username = '$uname'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $shekels = $row["Shekels"];
        }
        $shekels = $shekels + $amt;
        $sql = "UPDATE users SET Shekels = '$shekels' WHERE Username = '$uname'";
        $result = $conn->query($sql);
    } else if($_POST["transactionType"] == 1) {
        $sql = "SELECT Shekels FROM users WHERE Username = '$uname'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $shekels = $row["Shekels"];
        }
        $shekels = $shekels - $amt;
        $sql = "UPDATE users SET Shekels = '$shekels' WHERE Username = '$uname'";
        $result = $conn->query($sql);
    } else if($_POST["transactionType"] == 2) {
        $sql = "UPDATE users SET Shekels = '$amt' WHERE Username = '$uname'";
        $result = $conn->query($sql);
    }
    
    header('Location: index.php');

?>
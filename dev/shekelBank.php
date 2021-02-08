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
        $sql = "SELECT Shekels FROM users WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        while($row = $result->fetch_assoc()) {
            $shekels = $row["Shekels"];
        }
        $shekels = $shekels + $amt;
        $sql = "UPDATE users SET Shekels = ? WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "is", $shekels, $uname);
            mysqli_stmt_execute($stmt);
        }
    } else if($_POST["transactionType"] == 1) {
        $sql = "SELECT Shekels FROM users WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        while($row = $result->fetch_assoc()) {
            $shekels = $row["Shekels"];
        }
        $shekels = $shekels - $amt;
        $sql = "UPDATE users SET Shekels = ? WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "is", $shekels, $uname);
            mysqli_stmt_execute($stmt);
        }
    } else if($_POST["transactionType"] == 2) {
        $sql = "UPDATE users SET Shekels = ? WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "is", $amt, $uname);
            mysqli_stmt_execute($stmt);
        }
    }
?>
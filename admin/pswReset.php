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

    $verifyUsername = false;

    $uname = $_POST["username"];
    $team = $_SESSION["Team"];
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

    //Check if user exists
    $sql = "SELECT Username FROM users WHERE Username = ? && Team = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "si", $uname, $team);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = $result->fetch_assoc()) {
            if($row["Username"] == $uname) {
                $verifyUsername = true;
            }
        }
    }

    if($verifyUsername) {
        $hash = password_hash('password', PASSWORD_DEFAULT);
        $sql = "UPDATE users SET Password = '$hash' WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uname);
            mysqli_stmt_execute($stmt);
        }
    } else {
        $_SESSION["alert"] = true;
        $_SESSION["prompt"] = "That user doesn't exist or isn't registered to Team " . $team;
    }

    header('Location: index.php');
?>
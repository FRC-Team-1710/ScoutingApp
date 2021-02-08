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

    $sql = "SELECT * FROM users WHERE Team = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["Team"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    while($row = $result->fetch_assoc()) {
        $id = $row["UserID"];
        $broadcast = $row["Notifications"] . $_SESSION["fName"] . " " . $_SESSION["lName"] . ":" . $_POST["broadcast"] . "*";
        $sql = "UPDATE users SET Notifications = ? WHERE UserID = '$id'";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $broadcast);
            mysqli_stmt_execute($stmt);
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "Broadcast transmitted";
            header('Location: broadcast.php');
        }    
    }
?>
<?php
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    if($sessionValid != true) {
        header('Location: index.php');
    }

    $pswCheck = false;
    $psw = $_POST["psw"];
    $uname = $_SESSION["uName"];

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

    $sql = "SELECT Password FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        if(password_verify($psw, $row["Password"])) {
            $pswCheck = true;
        } else {
            $_SESSION["alert"] = true;
            $_SESSION["alertType"] = "delete";
            $_SESSION["prompt"] = "Your password is not correct. Termination aborted.";
            header('Location: ../settings.php');
        }
    }
    
    $sql = "SELECT UserID FROM users WHERE Username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    while($row = $result->fetch_assoc()) {
        $userID = $row["UserID"];
    }

    if($pswCheck) {
        if($_POST["deleteCheck"] == "on") {
            $sql = "DELETE FROM users WHERE Username = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                echo "There was an error";
            } else {
                mysqli_stmt_bind_param($stmt, "s", $uname);
                mysqli_stmt_execute($stmt);
            }
            $_SESSION["isSessionValid"] = false;
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "Thank you for feeding the fiery inferno";
            header('Location: ../index.php');
        } else {
            $_SESSION["alert"] = true;
            $_SESSION["alertType"] = "delete";
            $_SESSION["prompt"] = "You didn't confirm the delete order. Termination aborted.";
            header('Location: ../settings.php');
        }
    }
?>
<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: ../index.php');
    }
    date_default_timezone_set('America/North_Dakota/Center');

    $formFeedback = $_POST["feedback"];
    $uname = $_SESSION["uName"];

    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";
    $date = date('m/d/Y');
    $time = date('h:i');
    $read = 1;

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO feedback (Date, Subject, username, isRead, Time) VALUES ('$date', ?, ?, ?, '$time')";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "ssi", $formFeedback, $uname, $read);
        mysqli_stmt_execute($stmt);
        $_SESSION["alert"] = true;
        $_SESSION["prompt"] = "Feedback successfully submitted!";
        header('Location: ../feedback.php');
    }    
?>
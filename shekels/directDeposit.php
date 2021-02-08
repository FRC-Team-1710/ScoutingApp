<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: ../index.php');
    }

    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";
    $uname = $_SESSION["uName"];

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($_SESSION["matchComplete"]) {  //THIS MUST BE UPDATED TO A VARIABLE THAT WILL RETURN TRUE WHEN DATA IS SUBMITTED BY SCOUT.
        $shekels = $_SESSION["shekelCount"] + 20;
        $sql = "UPDATE users SET Shekels = '$shekels' WHERE Username = '$uname'";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "is", $shekels, $uname);
            mysqli_stmt_execute($stmt);
        }
        $_SESSION["shekelCount"] = $shekels;
    }

    $_SESSION["matchComplete"] = false;
    header('Location: ../hub.php');
?>
<?php
    session_start();
    $verifyPassword = true;

    //Database variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    $uname = $_POST['user'];
    $psw = $_POST['psw'];
    $pswd = $_POST['pswd'];

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Verify passwords match
    if($psw != $pswd) {
        $verifyPassword = false;
        $_SESSION["alert"] = true;
        $_SESSION["prompt"] = "Your passwords don't match!";
        header('Location: ../resetPassword.php/?user=' . urlencode(base64_encode($uname)));
    }

    if($verifyPassword){
        $hash = password_hash($psw, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET Password = ? WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $hash, $uname);
            mysqli_stmt_execute($stmt);
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "Password changed successfully!";
            header('Location: ../index.php');
        }
    }
?>
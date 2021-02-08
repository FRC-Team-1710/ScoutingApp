<?php
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    if($sessionValid != true) {
        header('Location: ../index.php');
    }

    $uname = $_SESSION["uName"];
    $isPswValid = true;
    $doesPswMatch = true;

    //POST variables
    $oldPsw = $_POST["oldPsw"];
    $newPsw = $_POST["newPsw"];
    $newPswChk = $_POST["newPswChk"];
    
    //Connection variables
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

    //Check if the old password matches
    $sql = "SELECT Password FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        if(!password_verify($oldPsw, $row["Password"])) {
            $isPswValid = false;
            $_SESSION["alert"] = true;
            $_SESSION["alertType"] = "change";
            $_SESSION["prompt"] = "That's not the current password";
        }
    }

    //Check if the new passwords match
    if($isPswValid) {
        if($newPsw != $newPswChk) {
            $doesPswMatch = false;
            $_SESSION["alert"] = true;
            $_SESSION["alertType"] = "change";
            $_SESSION["prompt"] = "Your new passwords don't match!";
        }
    }

    if($isPswValid && $doesPswMatch) {
        $hash = password_hash($newPsw, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET Password = ? WHERE Username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $hash, $uname);
            mysqli_stmt_execute($stmt);
        }
    }

    header('Location: ../settings.php');

?>
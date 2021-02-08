<?php
    session_start();
    $verifyUsername = true;
    $verifyPassword = true;
    $verifyAuthKey = false;

    //Database variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //Post variables
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uname = $_POST["uname"];
    $psw = $_POST["psw"];
    $pswd = $_POST["pswd"];
    $authKey = $_POST["authKey"];
    $shekel = 100;

    if($authKey == 'no') {
        $_SESSION["alert"] = true;
        $_SESSION["prompt"] = "This authkey is disabled right now. If you think this is a mistake, contact your head scout.";
        header('Location: ../createAccount.php');
    }

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Verify username isn't taken
    $sql = "SELECT Username FROM users";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        if($row["Username"] == $uname) {
            $verifyUsername = false;
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "That username has already been taken!";
        }
    }

    if($verifyUsername) {
        //Verify passwords match
        if($psw != $pswd) {
            $verifyPassword = false;
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "Your passwords don't match!";
        }
    }

    $sql = "SELECT * FROM authkeys WHERE Head = '$authKey'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $team = $row["Team"];
        $perms = 1;
        $verifyAuthKey = true;
    }
    $sql = "SELECT * FROM authkeys WHERE Assistant = '$authKey'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $team = $row["Team"];
        $perms = 2;
        $verifyAuthKey = true;
    }
    $sql = "SELECT * FROM authkeys WHERE Coach = '$authKey'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $team = $row["Team"];
        $perms = 3;
        $verifyAuthKey = true;
    }
    $sql = "SELECT * FROM authkeys WHERE Basic = '$authKey'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $team = $row["Team"];
        $perms = 4;
        $verifyAuthKey = true;
    }
    $sql = "SELECT * FROM authkeys WHERE Other = '$authKey'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $team = $row["Team"];
        $perms = 5;
        $verifyAuthKey = true;
    }
    if($team == NULL) {
        $_SESSION["alert"] = true;
        $_SESSION["prompt"] = "That's not a valid authKey. Contact your headscout to get your authKey.";
        $verifyAuthKey = false;
        header('Location: ../createAccount.php');
    }
    
    if($verifyPassword && $verifyUsername && $verifyAuthKey) {  
        $hash = password_hash($psw, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO users (Username, FirstName, LastName, Password, Team, Shekels, Permissions) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
             echo "There's an error";
        } else {
            mysqli_stmt_bind_param($stmt, "ssssiii", $uname, $fname, $lname, $hash, $team, $shekel, $perms);
            mysqli_stmt_execute($stmt);
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "Account successfully created. Log in to get started.";
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../createAccount.php');
    }
?>
<?php
    session_start();
    $verifyEmail = false;

    //Database variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    $email = $_POST["email"];

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $_SESSION['alert']=true;
    //Verify email is valid
    $sql = "SELECT Email, Username, FirstName FROM users";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        if($row["Email"] == $email) {
            $verifyEmail = true;
            $uname = $row["Username"];
            $fname = $row["FirstName"];

            $msg = "Hello, " . $fname . "!\n\nChange your password by going to https://team1710.com/scouting/resetPassword.php/?user=" . urlencode(base64_encode($uname));
            mail($email, 'Scouting Password Reset', $msg);

            $_SESSION['prompt']="Success! Check email for further instructions.";
            header('Location: ../index.php');
        }
    }
    if($verifyEmail == false){
        $_SESSION['prompt'] = "There is no account under the email you entered.";
        header('Location: ../forgotPassword.php');
    }
?>
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
    $sql = "SELECT Email FROM users";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        if($row["Email"] == $email) {
            $verifyEmail = true;
            $fname = $row["FirstName"];

            //$msg = "Hello, " . $fname . "!\n\nThis feature is a work in progress, but if it were finished you would be receiving a link to reset your account password."
            //mail($email, 'Scouting Password Reset', $msg);

            $_SESSION["prompt"]="Success! Check email for further instructions.";
            header('Location: ../index.php');
        }
    }
    if($verifyEmail == false){
        $_SESSION['prompt'] = "There is no account under the email you entered."
        header('Location: ../forgotPassword.php');
    }
?>
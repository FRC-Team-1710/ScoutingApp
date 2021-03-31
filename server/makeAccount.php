<?php
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    $perms = $_SESSION["perms"];
    if($sessionValid != true) {
        header('Location: ../index.php');
    } else if($perms != 1) {
        header('Location: ../hub.php');
    }

    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    $uName = $_POST["username"];
    $fName = $_POST["firstName"];
    $lName = $_POST["lastName"];
    $psw = $_POST["password"];
    $pswChk = $_POST["passwordChk"];

    if($psw != $pswChk) {
        header('Location: ../admin/index.php');
    }

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql="INSERT INTO users (Username, FirstName, LastName, Password) VALUES ('$uName', '$fName', '$lName', '$psw')";
    $result = $conn->query($sql);

    header('Location: ../admin/index.php');
?>
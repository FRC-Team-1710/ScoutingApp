<?php
session_start();
$_SESSION["isSessionValid"] = false;
$servername = "localhost";
$username = "mattbzco_779ccb2";
$password = "q1w2E#R$";
$dbname = "mattbzco_Scouting";
$usernameCheck = false;

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//only do below stuff if username exists
$uname = $_POST["uname"];
$sql = "SELECT Username FROM users";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    if($row["Username"]==$uname) {
        $usernameCheck = true;
    }
}
if($usernameCheck) {
    $psw = $_POST["psw"];
    $sql = "SELECT Password FROM users WHERE Username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    while($row = $result->fetch_assoc()) {
        if(password_verify($psw, $row["Password"])) {
            $loginCheck = true;
        } else {
            $_SESSION["alert"] = true;
            $_SESSION["prompt"] = "The password you entered did not the match the password on file for this account";
            header('Location: ../index.php');
        }
    }
} else {
    $_SESSION["alert"] = true;
    $_SESSION["prompt"] = "Oops! That username doesn't exist";
    header('Location: ../index.php');
}

if($loginCheck) {
    //Set Session variables
    $sql = "SELECT * FROM users WHERE Username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    while($row = $result->fetch_assoc()) {
        $_SESSION["uName"] = $row["Username"];
        $_SESSION["fName"] = $row["FirstName"];
        $_SESSION["lName"] = $row["LastName"];
        $_SESSION["perms"] = $row["Permissions"];
        $_SESSION["Team"] = $row["Team"];
        $loginCount = $row["loginCount"];
        $loginCount++;
        if($row["Shekels"] == 69420) {
            $_SESSION["shekelCount"] = 68000;
        } else {        
            $_SESSION["shekelCount"] = $row["Shekels"];
        }
        $_SESSION["isSessionValid"] = true;
    }

    $sql = "UPDATE users SET loginCount='$loginCount' WHERE Username='$uname'";
    $result = $conn->query($sql);



    header('Location: ../hub.php');
}

?>
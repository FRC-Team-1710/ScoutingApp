<?php 
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    if($sessionValid != true) {
        header('Location: index.php');
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

    $sql = "SELECT Shekels FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $_SESSION["shekelCount"] = $row["Shekels"];
    }



?>
<!DOCTYPE html>
<html>
<head>
    <title> <?php echo $_SESSION["fName"] . "'s Settings"; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="icon" href="logo.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="utility.js"></script>
</head>
<body style="background-color: rgb(54, 59, 66)">
<div class="container">
<center>
    <div class="pt-3">
        <h2 class="display-4 text-white text-center"><?php echo $_SESSION['fName'] . "'s Settings"?></h2>
    </div>
    <hr style="border:1px solid white; width:80%">
    <h4 class="text-white pt-3 pb-4">Profile Information</h4>
    <div class="col-xs-12">
        <h5 class="text-center text-white"><?php
        echo "Username: " . $_SESSION["uName"] . "<br><br>" .
        "First Name: " . $_SESSION["fName"] . "<br><br>" . 
        "Last Name: " . $_SESSION["lName"] . "<br><br>".
        "Shekels: " . $_SESSION["shekelCount"] . "<br><br>".
        "Registered Team: " . $_SESSION["Team"] . "<br><br>";
        ?></h5>
    </div>
    <hr style="border:1px solid white; width:80%" class="mt-5">
    <br>
    <div class="py-3">
        <h4 class="text-white pt-3">Change your password</h4>
    </div>
    <?php
        if($_SESSION["alert"] && $_SESSION["alertType"] == "change") {
            echo '
            <div class="alert alert-danger" role="alert"> ' .
                $_SESSION["prompt"] .                        
            '</div>';
        }
    ?>
    <form action="server/updatePsw.php" method="post">
        <label for="oldPsw" class="pt-3">
            <b class="text-white">Current Password:</b>
        </label>
        <div class="col-xs-12">
            <input id="input1" style="position:relative; left:12px;" type="password" name="oldPsw" placeholder="Current Password" required>
            <i  id="eye1" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input1', 'eye1');"></i>
        </div>
        <label for="newPsw" class="pt-3">
            <b class="text-white">New Password:</b>
        </label>
        <div class="col-xs-12">
            <input id="input2" style="position:relative; left:12px;" type="password" name="newPsw" placeholder="New Password" required>
            <i  id="eye2" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input2', 'eye2');"></i>
        </div>
        <label for="newPswChk" class="pt-3">
            <b class="text-white">Retype New Password:</b>
        </label>
        <div class="col-xs-12">
            <input id="input3" style="position:relative; left:12px;" type="password" name="newPswChk" placeholder="Retype Password" required>
            <i  id="eye3" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input3', 'eye3');"></i>
        </div>
        <div class="col-xs-12 pt-3">
            <button type="submit" class="btn btn-lg btn-success mt-2">Change Password</button>
        </div>
    </form>
    <hr style="border:1px solid white; width:80%" class="mt-5">
    <br>
    <div class="py-3">
        <h4 class="text-danger pt-3">Delete your account</h4>
    </div>
    <?php
        if($_SESSION["alert"] && $_SESSION["alertType"] == "delete") {
            echo '
            <div class="alert alert-danger" role="alert"> ' .
                $_SESSION["prompt"] .                        
            '</div>';
        }
    ?>
    <form action="server/deleteAccount.php" method="post">
        <label for="psw" class="pt-3">
            <b class="text-white">Current Password:</b>
        </label>
        <div class="col-xs-12">
            <input id="psw" style="position:relative; left:12px;" type="password" name="psw" placeholder="Current Password" required>
        </div>
        <label for="deleteAccount" class="pt-5">
            <b class="text-white">Are you sure you want to delete your account? <br> (This CANNOT be undone)</b>
        </label>
        <div class="form-check">
            <input type="checkbox" name="deleteCheck" class="form-check-input" id="deleteCheck" onclick="reallyDelete();">
            <label class="form-check-label text-white" for="deleteCheck">I'd like my account terminated in a large inferno</label>
        </div>
        <div class="col-xs-12 pt-5">
            <button id="deleteBtn" type="submit" class="btn btn-lg btn-danger mt-2">Delete My Account</button>
        </div>
    </form>
    <hr style="border:1px solid white; width:80%" class="mt-5">
    <br>
    <div class="col-xs-12 py-3">
        <a href="hub.php">
            <button type="button" class="btn btn-success btn-lg">Back to hub</button>
        </a>
    </div>
</center>
</div>
</body>
</html>
<?php
    $_SESSION["alert"] = false;
?>
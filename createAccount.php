<?php
    session_start();
    $_SESSION["fromAdmin"] = false;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>FRC Scouting App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Bootstrap imports-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--utility import-->
    <script src="utility.js"></script>
    <!--FontAwesome import-->
    <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
</head>
<body style="background-color:rgb(54,59,66)">
    <header class="container">
        <div class="pt-3">
            <h2 class="display-4 text-white text-center" id="headText">
                Create an Account
            </h2>
        </div>
    </header>
    <hr style="border:1px solid white; width:80%">
    <div class="container">
        <center>
            <?php
                if($_SESSION["alert"]) {
                    echo '
                <div class="alert alert-danger" role="alert"> ' .
                    $_SESSION["prompt"] . '
                </div>
                ';
                }
            ?>
            <form action="server/processAccountCreation.php" method="post">
                <label for="fname" class="pt-2">
                    <b class="text-white">First Name:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input type="text" autocomplete="off" placeholder="Enter your first name" name="fname" required>
                </div>
                <label for="lname" class="pt-2">
                    <b class="text-white">Last Name:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input type="text" autocomplete="off" placeholder="Enter your last name" name="lname" required>
                </div>
                <label for="uname" class="pt-2">
                    <b class="text-white">Username:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input type="text" autocomplete="off" placeholder="Enter Username" name="uname" required>
                </div>
                <label for="psw" class="pt-2">
                    <b class="text-white">Password:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input id="input1" autocomplete="off" type="password" style="position:relative; left:12px;" placeholder="Enter Password" name="psw" required>
                    <i  id="eye1" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input1', 'eye1');"></i>
                </div>
                <div class="col-xs-12 pt-1">
                    <input id="input2" autocomplete="off" type="password" style="position:relative; left:12px;" placeholder="Retype Password" name="pswd" required>
                    <i  id="eye2" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input2', 'eye2');"></i>
                </div>
                <label for="authKey" class="pt-2">
                    <b class="text-white">Authorization Key</b>
                </label>
                <div class="col-xs-12 pt-1" id="authKey">
                    <input type="text" autocomplete="off" placeholder="Enter Authkey" name="authKey" required>
                </div>
                <div class="col-xs-2 pt-3">
                    <button type="submit" class="btn btn-success btn-lg mt-2">Create Account</button>
                </div>
            </form>  
            <div class="col-xs-12 pt-5">
                <a href="index.php">
                    <button class="btn btn-primary">Already have an account? Click here</button>
                </a>
            </div>
        </center>
    </div>
</body>
</html>
<?php
    $_SESSION["alert"] = false;
?>
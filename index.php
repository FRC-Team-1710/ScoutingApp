<?php
session_start();
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
    <!--Js utilities-->
    <script src="utility.js"></script>
    <!--FontAwesome imports-->
    <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: rgb(54, 59, 66)">
    <header class="container">
        <div class="pt-3">
            <h2 class="display-4 text-white text-center" id="headText">
                FRC Scouting App Login
            </h2>
        </div>
    </header>
    <hr style="border:1px solid white; width:80%">
    <div class="container">
        <center>
        <h3 class="text-white text-center">
            We are currently under construction. Sorry for the inconvenience!
        </h3>
            <?php
                if($_SESSION['alert'] && ($_SESSION["prompt"] != "Account successfully created. Log in to get started.")) {    
                    echo '
                    <div class="alert alert-danger" role="alert"> ' .
                        $_SESSION["prompt"] .                        
                    '</div>';
                } else if($_SESSION['alert'] && ($_SESSION['prompt'] == "Account successfully created. Log in to get started.")) {
                    echo '
                    <div class="alert alert-success" role="alert"> ' .
                        $_SESSION["prompt"] .                        
                    '</div>';
                }
            ?>
            <form action="server/login.php" method="post" id="securityForm">
                <label for="uname" class="pt-2">
                    <b class="text-white">Username:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input type="text" placeholder="Enter Username" name="uname" required>
                </div>
                <label for="psw" class="pt-2">
                    <b class="text-white">Password:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input id="input1" style="position:relative; left:12px;" type="password" placeholder="Enter Password" name="psw" required>
                    <i  id="eye1" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input1', 'eye1');"></i>
                </div>
                <div class="col-xs-2 pt-3">
                    <button type="submit" class="btn btn-success btn-lg mt-2">Login</button>
                </div>
            </form>  
            <div class="col-xs-12 pt-5">
                <a href="createAccount.php">
                    <button class="btn btn-primary m-2">No Account? Click here</button>
                </a>
            </div>
        </center>
    </div>
</body>
</html>
<?php
    $_SESSION["alert"] = false;
?>
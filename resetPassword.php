<?php
    session_start();
    if(!$_GET['user']){
        header('Location: ../forgotPassword.php');
    }
    $uname = base64_decode(urldecode($_GET['user']))
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
                Reset Password
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
                echo'
                <h3 class="text-white text-center">
                    Hello, ' . $uname . '!
                </h3>
                <h3 class="text-white text-center">
                    Enter your new password:
                </h3>';
            ?>
            <form action="../server/changePassword.php" method=post>
                <?php
                    echo '<input type="hidden" name="user" value='.$uname.'>';
                ?>
                <div class="col-xs-12 pt-1">
                    <input id="input1" autocomplete="off" type="password" style="position:relative; left:12px;" maxlength="32" placeholder="Enter Password" name="psw" required>
                    <i  id="eye1" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input1', 'eye1');"></i>
                </div>
                <div class="col-xs-12 pt-1">
                    <input id="input2" autocomplete="off" type="password" style="position:relative; left:12px;" maxlength="32" placeholder="Retype Password" name="pswd" required>
                    <i  id="eye2" class="fas fa-eye" style="position:relative; right:20px;" onclick="togglePasswordDisplay('input2', 'eye2');"></i>
                </div>
                <div class="col-xs-2 pt-3">
                    <button type="submit" class="btn btn-success btn-lg mt-2">Submit</button>
                </div>
            </form>
        </center>
    </div>
</body>
</html>
<?php
    $_SESSION["alert"] = false;
?>
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
            ?>
            <h3 class="text-white text-center">
                This page is a work in progress and not yet functional. Sorry for the inconvenience!
            </h3>
            <form action="server/pswResetEmail.php" method=post>
                <label for="email" class="pt-2">
                    <b class="text-white">Email:</b>
                </label>
                <div class="col-xs-12 pt-1">
                    <input type="email" autocomplete="off" placeholder="Enter your email" name="email" maxlength="100" required>
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
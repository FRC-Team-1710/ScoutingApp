<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Broadcast a Message</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body style="background-color:rgb(54,59,66);">
    <div class="container">
        <center>
        <div class="pt-3">
            <h2 class="display-4 text-white text-center">Broadcast to <?php echo $_SESSION["Team"]; ?></h2>
        </div>
        <hr style="border:1px solid white; width:80%">
        <?php
            if($_SESSION['alert']) {    
                echo '
                <div class="alert alert-success" role="alert"> ' .
                    $_SESSION["prompt"] .                        
                '</div>';
            }
        ?>
        <form action="sendBroadcast.php" method="post">
            <div class="form-group pb-3 mt-4">
                <textarea class="form-control" id="broadcast" name="broadcast" placeholder="Put your message here" rows="3"></textarea>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success btn-lg">Broadcast Message</button>
            </div>
        </form>
        <br>
        <div class="col-xs-12">
            <a href="index.php">
                <button type="button" class="btn btn-success">Back</button>
            </a>
        </div>
        </center>
    </div>
</body>
</html>
<?php
    $_SESSION["alert"] = false;
?>
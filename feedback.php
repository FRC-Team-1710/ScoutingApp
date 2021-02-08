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
    <title>Feedback</title>
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
            <h2 class="display-4 text-white text-center">We want to hear from you!</h2>
        </div>
        <hr style="border:1px solid white; width:80%">
        <h4 class="text-white pt-3 pb-4">Fill out the feedback form below!</h4>
        <?php
            if($_SESSION['alert']) {    
                echo '
                <div class="alert alert-success" role="alert"> ' .
                    $_SESSION["prompt"] .                        
                '</div>';
            }
        ?>
        <form action="server/processFeedback.php" method="post">
            <div class="form-group pb-3 mt-4">
                <textarea class="form-control" id="feedback" name="feedback" placeholder="Insert your feedback here" rows="3"></textarea>
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" name="codebreaker" class="form-check-input" id="codebreaker" onclick="reallyDelete();">
                <label class="form-check-label text-white" for="codebreaker">This feedback is in regards to a bug on the site.</label>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success btn-lg">Submit Feedback</button>
            </div>
        </form>
        <br>
        <div class="col-xs-12">
            <a href="hub.php">
                <button type="button" class="btn btn-success">Back to Hub</button>
            </a>
        </div>
        </center>
    </div>
</body>
</html>
<?php
    $_SESSION["alert"] = false;
?>
<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: ../index.php');
    }
    if($_SESSION["perms"] != 6) {
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
    <link rel="icon" href="logo.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
    var activeChecks = false;
    function toggleSelectAll() {
        if(!activeChecks) {
            document.getElementById('headScout').setAttribute('checked', 'checked');
            document.getElementById('assistantScout').setAttribute('checked', 'checked');
            document.getElementById('coach').setAttribute('checked', 'checked');
            document.getElementById('basicScout').setAttribute('checked', 'checked');
            document.getElementById('other').setAttribute('checked', 'checked');
            activeChecks = true;
        } else {
            document.getElementById('headScout').setAttribute('checked', '');
            document.getElementById('assistantScout').setAttribute('checked', '');
            document.getElementById('coach').setAttribute('checked', '');
            document.getElementById('basicScout').setAttribute('checked', '');
            document.getElementById('other').setAttribute('checked', '');
            activeChecks = false;
        }
    }
    function checkTextBoxValue(){
        if(document.getElementById('broadcast').value){
            document.getElementById('submitButton').disabled = false;
        }else{
            document.getElementById('submitButton').disabled = true;
        }
    }
    </script>
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
                <textarea class="form-control" id="broadcast" name="broadcast" placeholder="Put your message here" rows="3" onkeyup="checkTextBoxValue()" required></textarea>
            </div>
            <div class="col-xs-12 pt-4">
                <button type="submit" class="btn btn-success btn-lg" id="submitButton" disabled>Broadcast Message</button>
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
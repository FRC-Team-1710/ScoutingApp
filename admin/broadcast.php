<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: ../index.php');
    }
    if($_SESSION["perms"] != 1) {
        if($_SESSION["perms"] != 6) {
            header('Location: index.php');
        }
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
    <script>
    var activeChecks = false;
    function toggleSelectAll() {
        if(!activeChecks) {
            document.getElementById('headScout').checked = true;
            document.getElementById('assistantScout').checked = true;
            document.getElementById('coach').checked = true;
            document.getElementById('basicScout').checked = true;
            document.getElementById('other').checked = true;
            activeChecks = true;
        } else {
            document.getElementById('headScout').checked = false;
            document.getElementById('assistantScout').checked = false;
            document.getElementById('coach').checked = false;
            document.getElementById('basicScout').checked = false;
            document.getElementById('other').checked = false;
            activeChecks = false;
        }
    }
    function checkIfAllChecked() {
        if(document.getElementById('headScout').checked &&
           document.getElementById('assistantScout').checked &&
           document.getElementById('coach').checked &&
           document.getElementById('basicScout').checked &&
           document.getElementById('other').checked)
        {
            document.getElementById('checkAll').checked = true;
            activeChecks = true;
        }else{
            document.getElementById('checkAll').checked = false;
            activeChecks = false;
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
                <textarea class="form-control" id="broadcast" name="broadcast" placeholder="Put your message here" rows="3"></textarea>
            </div>
            <div class="form-check pt-3">
                <label class="text-white">
                    <b style="font-size:20px">Who should this message go to?</b>
                </label>
                <input type="checkbox" name="checkAll" class="ml-2 form-check-input" onclick="toggleSelectAll()">
            </div>
            <div class="form-check pt-3">
                <label style="font-size:130%" class="mr-2 form-check-label text-white text-left" for="headScout">Head Scout</label>
                <input style="width:6%;height:45%;right:15vw" type="checkbox" name="headScout" class="ml-2 form-check-input" id="headScout" onclick="checkIfAllChecked()">
            </div>
            <div class="form-check pt-3">
                <label style="font-size:130%" class="mr-2 form-check-label text-white" for="assistantScout">Assistant Head Scout</label>
                <input style="width:6%;height:45%;right:15vw" type="checkbox" name="assistantScout" class="ml-2 form-check-input" id="assistantScout" onclick="checkIfAllChecked()">
            </div>
            <div class="form-check pt-3">
                <label style="font-size:130%" class="mr-2 form-check-label text-white" for="coach">Coaches / Mentors</label>
                <input style="width:6%;height:45%;right:15vw" type="checkbox" name="coach" class="ml-2 form-check-input" id="coach" onclick="checkIfAllChecked()">
            </div>
            <div class="form-check pt-3">
                <label style="font-size:130%" class="mr-2 form-check-label text-white" for="basicScout">Basic Scouts</label>
                <input style="width:6%;height:45%;right:15vw" type="checkbox" name="basicScout" class="ml-2 form-check-input" id="basicScout" onclick="checkIfAllChecked()">
            </div>
            <div class="form-check pt-3">
                <label style="font-size:130%" class="mr-2 form-check-label text-white" for="other">Other</label>
                <input style="width:6%;height:45%;right:15vw" type="checkbox" name="other" class="ml-2 form-check-input" id="other" onclick="checkIfAllChecked()">
            </div>
            <div class="col-xs-12 pt-4">
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
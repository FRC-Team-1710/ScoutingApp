<?php
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    $perms = $_SESSION["perms"];
    if($sessionValid != true) {
        header('Location: ../index.php');
    } else if($perms != 1) {
        if($perms != 6) {
            header('Location: ../hub.php');
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Assistant Scout Permission Editor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Bootstrap imports-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color:rgb(54,59,66)">
        <div class="container">
            <center>
                <div class="pt-3">
                    <h2 class="display-4 text-white text-center">Assistant Scout Editor</h2>
                </div>
                <hr style="border:1px solid white; width:80%">
                <form method="POST" src="#">
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white text-left" for="editSchedule">Edit Schedule</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="editSchedule" class="ml-2 form-check-input" id="editSchedule">
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="broadcastMessages">Broadcast Messages</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="broadcastMessages" class="ml-2 form-check-input" id="broadcastMessages">
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="scout">Scout</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="scout" class="ml-2 form-check-input" id="scout">
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="viewData">View Data</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="viewData" class="ml-2 form-check-input" id="viewData">
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="haveShekels">Have Shekels</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="haveShekels" class="ml-2 form-check-input" id="haveShekels">
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="viewStocks">View Shekel Stocks</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="viewStocks" class="ml-2 form-check-input" id="viewStocks">
                    </div>
                    <div class="pt-4 pb-2">
                        <button type="submit" class="btn btn-primary">Apply Changes</button>
                    </div>
                </form>
                <div class="pt-5">
                    <a href="../index.php">
                        <button class="btn btn-success">Back</button>
                    </a>
                </div>
            </center>
        </div>
    </body>
</html>
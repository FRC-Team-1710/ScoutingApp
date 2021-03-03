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

    $team = $_SESSION["Team"];

    //Collect authkeys
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";
    $disabledHead = false;
    $disabledAssistant = false;
    $disabledCoach = false;
    $disabledBasic = false;
    $disabledOther = false;

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM authkeys WHERE Team = '$team'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $head = $row["Head"];
        $assistant = $row["Assistant"];
        $coach = $row["Coach"];
        $basic = $row["Basic"];
        $other = $row["Other"];
    }
    if($head == 'no') {
        $head = 'Disabled';
        $disabledHead = true;
    }

    if($assistant == 'no') {
        $assistant = 'Disabled';
        $disabledAssistant = true;
    }

    if($coach == 'no') {
        $coach = 'Disabled';
        $disabledCoach = true;
    }

    if($basic == 'no') {
        $basic = 'Disabled';
        $disabledBasic = true;
    }

    if($other == 'no') {
        $other = 'Disabled';
        $disabledOther = true;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Bootstrap imports-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--Js import-->
    <script src="../utility.js"></script>
    <!--FontAwesome import-->
    <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
</head>
<body style="background-color:rgb(54,59,66)">
    <div class="container">
        <center>
            <div class="pt-3">
                <h2 class="display-4 text-white text-center">Admin Settings</h2>
            </div>
            <hr style="border:1px solid white; width:80%">
            <h5 class="text-white pt-3">Edit Schedule</h5>
            <div class="col-xs-12 pt-3">
                <a href="editSchedule.php"><button class="btn btn-success">Edit</button></a>
            </div>
            <hr style="border:1px solid white; width:80%">
            <h5 class="text-white pt-3">Broadcast Center</h5>
            <div class="col-xs-12 pt-3">
                <a href="broadcast.php"><button class="btn btn-success">Broadcast Message</button></a>
            </div>
            <hr style="border:1px solid white; width:80%">
            <?php
            if($_SESSION["alert"]) {
                echo '
                <div class="alert alert-danger" role="alert"> ' .
                    $_SESSION["prompt"] . '
                </div>
                ';
            }
            ?>
            <form action="pswReset.php" method="post">
                <h5 class="text-white pt-3">Password Reset</h5>
                <label for="username" class="pt-1">
                    <b class="text-white">Username:</b> <br>
                    <p class="text-white">(This will reset the users password to "password")</p>
                </label>
                <div class="col-xs-12">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="col-xs-12 pt-3">
                    <button type="submit" class="btn btn-success">Reset password</button>
                </div>
            </form>
            <hr style="border:1px solid white; width:80%" class="mt-5">
            <br>
            <h5 class="text-white pt-3 pb-3">AuthKey Controls</h5>
            <div class="btn-group py-3">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;">
                    Head Scout
                </button>
                <div id="dropdown" class="dropdown-menu" style="width:60vw;">
                <center>
                    <p class="my-2 dropdown-item">Key: <?php echo $head;?></p>
                    <div class="my-2 dropdown-item"><button class="btn btn-warning" onclick="regenerate(1)">Regenerate Key</button><div>
                    <div class="my-2 dropdown-item"><button class="btn btn-danger" onclick="disable(1)" <?php if($disabledHead) {echo 'disabled';} ?>>Disable Key</button></div>
                </center>
                </div>
            </div>
            <div class="btn-group py-3">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;">
                    Assistant Head Scout
                </button>
                <div id="dropdown" class="dropdown-menu" style="width:60vw;">
                <center>
                    <p class="my-2 dropdown-item">Key: <?php echo $assistant;?></p>
                    <div class="my-2 dropdown-item"><button class="btn btn-warning" onclick="regenerate(2)">Regenerate Key</button><div>
                    <div class="my-2 dropdown-item"><button class="btn btn-danger" onclick="disable(2)" <?php if($disabledAssistant) {echo 'disabled';} ?>>Disable Key</button></div>
                    <div class="my-2 dropdown-item"><a href="permissions/assistant.php"><button class="btn btn-success">Edit Permissions</button></a></div>
                </center>
                </div>
            </div>    
            <div class="btn-group py-3">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;">
                    Coach/Mentor
                </button>
                <div id="dropdown" class="dropdown-menu" style="width:60vw;">
                <center>
                    <p class="my-2 dropdown-item">Key: <?php echo $coach;?></p>
                    <div class="my-2 dropdown-item"><button class="btn btn-warning" onclick="regenerate(3)">Regenerate Key</button><div>
                    <div class="my-2 dropdown-item"><button class="btn btn-danger" onclick="disable(3)" <?php if($disabledCoach) {echo 'disabled';} ?>>Disable Key</button></div>
                    <div class="my-2 dropdown-item"><a href="permissions/coach.php"><button class="btn btn-success">Edit Permissions</button></a></div>
                </center>
                </div>
            </div>    
            <div class="btn-group py-3">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;">
                    Basic Scout
                </button>
                <div id="dropdown" class="dropdown-menu" style="width:60vw;">
                <center>
                    <p class="my-2 dropdown-item">Key: <?php echo $basic;?></p>
                    <div class="my-2 dropdown-item"><button class="btn btn-warning" onclick="regenerate(4)">Regenerate Key</button><div>
                    <div class="my-2 dropdown-item"><button class="btn btn-danger" onclick="disable(4)" <?php if($disabledBasic) {echo 'disabled';} ?>>Disable Key</button></div>
                    <div class="my-2 dropdown-item"><a href="permissions/basic.php"><button class="btn btn-success">Edit Permissions</button></a></div>
                </center>
                </div>
            </div>    
            <div class="btn-group py-3">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;">
                    Other
                </button>
                <div id="dropdown" class="dropdown-menu" style="width:60vw;">
                <center>
                    <p class="my-2">Key: <?php echo $other;?></p>
                    <div class="my-2 dropdown-item"><button class="btn btn-warning" onclick="regenerate(5)">Regenerate Key</button><div>
                    <div class="my-2 dropdown-item"><button class="btn btn-danger" onclick="disable(5)" <?php if($disabledOther) {echo 'disabled';} ?>>Disable Key</button></div>
                    <div class="my-2 dropdown-item"><a href="permissions/other.php"><button class="btn btn-success">Edit Permissions</button></a></div>
                </center>
                </div>
            </div>                     
            <hr style="border:1px solid white; width:80%" class="mt-5">
            <br>
            <div class="col-xs-12 py-3">
                <a href="../hub.php">
                    <button class="btn btn-success btn-lg">Back to Hub</button>
                </a>
            </div>
        </center>
    </div>
</body>
<script>
    function disable(id) {
        $.ajax({
            type: "POST",
            url: 'disable.php',
            data:{action:id},
            success:function() {
                location.reload();
            }
        });
    }

    function regenerate(id) {
        $.ajax({
            type: "POST",
            url: 'regenerate.php',
            data:{action:id},
            success:function() {
                location.reload();
            }
        });
    }
</script>
</html>
<?php
    $_SESSION["alert"] = false;
?>
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

    //Connection variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbName = "mattbzco_Scouting";

    $team = $_SESSION["Team"];

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbName);
    //Check connection
    if($conn->connect_error) {
        die("Error: " . $conn->connect_error);
    }

    $sql = "SELECT ShiftLength FROM authkeys WHERE Team = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $team);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    while($row = $result->fetch_assoc()) {
        $shift = $row["ShiftLength"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $_SESSION["Team"];?> Schedule Editor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="icon" href="logo.jpg">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color:rgb(54,59,66)">
        <div class="container">
            <center>
                <div class="pt-3">
                    <h2 class="display-4 text-white text-center">
                        Schedule Editor
                    </h2>
                </div>
                <hr style="width:80%;border:1px solid white;">
                <form action="setShift.php" method="post">
                <h5 class="text-white pt-3">Set Shift Length</h5>
                <div class="col-xs-12">
                    <input class="mb-2 py-2" type="number" placeholder="Current Shift Size: <?php echo $shift; ?>" name="shift" required>
                </div>
                <div class="col-xs-12 pt-3">
                    <button type="submit" class="btn btn-success">Update Shift Frequency</button>
                </div>
                </form>
                <hr style="width:80%;border:1px solid white;">
                <div class="col-xs-12 py-3">
                    <a href="competitionEditor.php">
                        <button type="button" class="btn btn-success btn-lg">GKC</button> <!--Collect this info from API-->
                    </a>
                </div>
                <div class="col-xs-12 py-3">
                    <a href="index.php">
                        <button type="button" class="btn btn-success">Back</button>
                    </a>
                </div>
            </center>
        </div>
    </body>
</html>
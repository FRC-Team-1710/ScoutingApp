<?php
    session_start();
    $isSessionValid = $_SESSION["isSessionValid"];
    $perms = $_SESSION["perms"];
    if(!$isSessionValid) {
        header('Location: ../index.php');
    }
    if($perms != 1) {
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

    $sql = "SELECT * FROM users WHERE Team = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $team);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $_SESSION["Team"];?> Schedule Editor | GKC</title> <!--Should be based on actual competition name-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color:rgb(54,59,66)">
        <div class="container">
            <center>
                <div class="btn-group py-3">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;background-color:white;">
                        Qualification 01
                    </button>
                    <div id="dropdown" class="dropdown-menu multi-level" role="menu" style="width:60vw;">
                    <center>
                        <button class="btn my-1 btn-danger">1710</button>
                        <button class="btn my-1 btn-danger">1810</button>
                        <button class="btn my-1 btn-danger">1910</button>
                        <button class="btn my-1 btn-primary">2010</button>
                        <button class="btn my-1 btn-primary">2110</button>
                        <button class="btn my-1 btn-primary">2210</button>                        
                    </center>
                    </div>
                </div>
                <div class="col-xs-12 my-5">
                    <a href="editSchedule.php">
                        <button type="button" class="btn btn-success" style="position:fixed;width:75%;height:5vh;bottom:25px;margin-left:-37.5%;left:50%">Back</button>
                    </a>
                </div>
            </center>
        </div>
    </body>
</html>
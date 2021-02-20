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

    //Connection Variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $team = $_SESSION["Team"];

    $sql = "SELECT * FROM `permissions` WHERE Team = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $team);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    while($row = $result->fetch_assoc()) {
        $coachPerm = $row["Coach"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Coach Permission Editor</title>
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
            <?php echo $coachPerm . "<br>" . $_SESSION["newValue"];?>
                <div class="pt-3">
                    <h2 class="display-4 text-white text-center">Coach Editor</h2>
                </div>
                <hr style="border:1px solid white; width:80%">
                <form method="post" action="editCoach.php">
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white text-left" for="editSchedule">Edit Schedule</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="editSchedule" class="ml-2 form-check-input" id="editSchedule" <?php if(((int)($coachPerm/100000)%2) != 0) {echo "checked";} ?>>
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="broadcastMessages">Broadcast Messages</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="broadcastMessages" class="ml-2 form-check-input" id="broadcastMessages" <?php if(((int)($coachPerm/10000)%2) != 0) {echo "checked";} ?>>
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="scout">Scout</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="scout" class="ml-2 form-check-input" id="scout" <?php if(((int)($coachPerm/1000)%2) != 0) {echo "checked";} ?>>
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="viewData">View Data</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="viewData" class="ml-2 form-check-input" id="viewData" <?php if(((int)($coachPerm/100)%2) != 0) {echo "checked";} ?>>
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="haveShekels">Have Shekels</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="haveShekels" class="ml-2 form-check-input" id="haveShekels" <?php if(((int)($coachPerm/10)%2) != 0) {echo "checked";} ?>>
                    </div>
                    <div class="form-check pt-3">
                        <label style="font-size:130%" class="mr-2 form-check-label text-white" for="viewStocks">View Shekel Stocks</label>
                        <input style="width:6%;height:45%;right:15vw" type="checkbox" name="viewStocks" class="ml-2 form-check-input" id="viewStocks"<?php if(((int)($coachPerm/1)%2) != 0) {echo "checked";} ?>>
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
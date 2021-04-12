<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: index.php');
    }

    //Connection Variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbName = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbName);
    //Check connection
    if($conn->mysqli_error) {
        die("Error: " . $conn->mysqli_error);
    }

    $uname = $_SESSION["uName"];
    $team = $_SESSION["Team"];
    $devTeam = 34522;

    $sql = "UPDATE users SET unreadNotification = 0 WHERE Username = '$uname'";
    $result = $conn->query($sql);

    //Collect notifications
    $sql = "SELECT * FROM notifications WHERE Team = '$team' || Team = '$devTeam'";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Notifications</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <!--FontAwesome import-->
        <!-- <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script> -->
    </head>
    <body style="background-color:rgb(54,59,66)">
        <div class="container">
            <center>
            <div class="pt-3">
                <h2 class="display-4 text-white text-center">Notifications</h2>
            </div>
            <hr style="width:80%;border:1px solid white">
            <table style="width:80%" class="table table-striped table-light mt-5">
                <tbody>
                    <!--in a php loop-->
                    <?php
                        //Display notifications for each existing notification
                        $validPerm = false;
                        while($row = $result->fetch_assoc()) {
                            //collect permission information
                            if($_SESSION["perms"] == 1 && ($row["perms"]/10000)%2 != 0) {
                                $validPerm = true;
                            } else if($_SESSION["perms"] == 2 && ($row["perms"]/1000)%2 != 0) {
                                $validPerm = true;
                            } else if($_SESSION["perms"] == 3 && ($row["perms"]/100)%2 != 0) {
                                $validPerm = true;
                            } else if($_SESSION["perms"] == 4 && ($row["perms"]/10)%2 != 0) {
                                $validPerm = true;
                            } else if($_SESSION["perms"] == 5 && ($row["perms"]/1)%2 != 0) {
                                $validPerm = true;
                            } else if($_SESSION["perms"] == 6) {
                                $validPerm = true;
                            }

                            if($validPerm) {
                                $author = $row["Author"];
                                $msg = $row["Message"];
                                $time = $row["Time"];
                                echo '
                                <tr>
                                    <td>
                                        <strong>'.$author.': </strong>'.$msg.'
                                    </td>
                                    <td> '
                                        .$time.
                                    '</td>
                                </tr>
                                ';
                            }
                        }
                    ?>
                </tbody>
            </table>
            <div class="col-xs-12 my-5">
                <a href="hub.php">
                    <button type="button" class="btn btn-success" style="position:fixed;width:75%;height:5vh;bottom:25px;margin-left:-37.5%;left:50%">Back to Hub</button>
                </a>
            </div>
            </center>
        </div>
    </body>
</html>
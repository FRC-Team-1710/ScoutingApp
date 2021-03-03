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

    $team = $_SESSION["Team"];
    $perms = $_SESSION["perms"];

    //Collect notifications
    $sql = "SELECT * FROM notifications WHERE Team = '$team'";
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
                        while($row = $result->fetch_assoc()) {
                            $validMessage = false;
                            if($perms == 1 && ($row["Permission"]/10000)%2 != 0) {
                                $validMessage = true;
                            } else if($perms == 2 && ($row["Permission"]/1000)%2 != 0) {
                                $validMessage = true;
                            } else if($perms == 3 && ($row["Permission"]/100)%2 != 0) {
                                $validMessage = true;
                            } else if($perms == 4 && ($row["Permission"]/10)%2 != 0) {
                                $validMessage = true;
                            } else if($perms == 5 && ($row["Permission"]/1)%2 != 0) {
                                $validMessage = true;
                            } else if($perms == 6) {
                                $validMessage = true;
                            }
                            if($validMessage) {
                                $author = $row["Author"];
                                $msg = $row["Message"];
                                $time = $row["Time"];
                                echo '
                                <tr>
                                    <td>
                                        <strong>'.$author.': </strong>'.$msg.'
                                    </td>
                                    <td> '.$time.
                                        // <div id="2" style="float:right;">
                                        //     <i class="far fa-trash-alt" style="color:black;width:30px;height:30px"></i>
                                        // </div>
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
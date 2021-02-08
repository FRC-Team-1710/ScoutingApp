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
    $activeAuthor = true;
    $activeMsg = false;
    $msg = "";
    $author = "";

    //Collect notifications string
    $sql = "SELECT Notifications FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $str = $row["Notifications"];
    }

    //determine number of notifications
    $numNots = 0;
    for($i = 0; $i < strlen($str); $i++) {
        if($str[$i] == "*") {
            $numNots++;
        } 
    }

    //return author of a given notification
    function getAuthor($param) {
        global $author;
        $author = "";
        $authorCount = 1;
        for($i = 0; $i < strlen('$str'); $i++) {
            if($str[$i] != ":" && $authorCount == $param && $activeAuthor) {
                $author .= $str[$i];
                $author = "Charlie";
            } else if($str[$i] == ":") {
                $authorCount++;
                $activeAuthor = false;
                $activeMsg = true;
            } else if($str[$i] == "*") {
                $activeAuthor = true;
                $activeMsg = false;
            }
        }
    }

    //return message of a given notification
    function getMsg($param) {
        global $msg;
        $msg = "";
        $msgCount = 1;
        for($i = 0; $i < strlen('$str'); $i++) {
            if($str[$i] != "*" && $msgCount == $param && $activeMsg) {
                $msg .= $str[$i];
            } else if($str[$i] == "*") {
                $msgCount++;
                $activeAuthor = true;
                $activeMsg = false;
            } else if($str[$i] == ":") {
                $activeAuthor = false;
                $activeMsg = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Team 1710 Scouting App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <!--FontAwesome import-->
        <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
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
                        $count = 1;
                        while($count <= $numNots) {
                            getAuthor($count);
                            getMsg($count);
                            echo '
                                <tr>
                                    <td>
                                        <strong>'.$author.': </strong>'.$msg.'
                                    </td>
                                    <td>
                                        <div id="2" style="float:right;">
                                            <i class="far fa-trash-alt" style="color:black;width:30px;height:30px"></i>
                                        </div>
                                    </td>
                                </tr>
                            ';
                            $count++;
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
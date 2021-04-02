<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: index.php');
    }

    $uname = $_SESSION["uName"];

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

    $code = "yfxX7G12Kz";

    $sql = "SELECT notificationReference FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $references = $row["notificationReference"];
    }
    $refs = explode(",", $references);
    //generate new string without notification
    $newRefs = "";
    for($i = 0; $i < count($refs); $i++) {
        if($refs[$i] !== $code) {
            if($i == 0) {
                $newRefs .= $refs[$i];
            } else {
                $newRefs .= "," . $refs[$i];
            }
        }
    }

    $sql = "UPDATE users SET notificationReference = '$newRefs' WHERE Username = '$uname'";
    $result = $conn->query($sql);

    ////////////////////////////////////////////////////////////

    $sql = "UPDATE users SET unreadNotification = 0 WHERE Username = '$uname'";
    $result = $conn->query($sql);

    $team = $_SESSION["Team"];
    $perms = $_SESSION["perms"];

    //Collect notifications
    $sql = "SELECT notificationReference FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $references = $row["notificationReference"];
    }

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
        <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
        <script>
            function deleteNotification(code) {
                $.ajax({
                    type: "POST",
                    url: 'server/deleteNotification.php',
                    data:{action:code},
                    success:function() {
                        var element = document.getElementById(code);
                        element.parentNode.removeChild(element);
                    }
                });
            }
        </script>
    </head>
    <body style="background-color:rgb(54,59,66)">
        <div class="container">
            <center>
            <div class="pt-3">
                <h2 class="display-4 text-white text-center">Notifications</h2>
            </div>
            <hr style="width:80%;border:1px solid white">
            <!-- <table style="width:80vw" class="table table-striped table-light mt-5"> -->
                <!-- <tbody> -->
                    <!--in a php loop-->
                    <?php
                        //get the references from the user column
                        $refs = explode(",", $references);
                        //collect the notifications from the database
                        for($i = 0; $i < count($refs); $i++) {
                            $code = $refs[$i];
                            
                            $sql = "SELECT * FROM notifications WHERE Code = '$code'";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                //print the notifications onto the screen
                                $author = $row["Author"];
                                $msg = $row["Message"];
                                $time = $row["Time"];
                                $date = $row["Date"];
                                // echo '
                                // <tr>
                                //     <td style="word-wrap: break-word">
                                //         '.$author.': '.$msg.'
                                //     </td>
                                //     <td> '.$time.
                                //         // '<div id="2" style="float:right;">
                                //         //     <i class="far fa-trash-alt" style="color:black;width:30px;height:30px"></i>
                                //         // </div>
                                //     '</td>
                                // </tr>
                                // ';
                                echo '
                                    <div id="'.$code.'" class="text-white my-3" style="overflow:hidden;background-color:black;border-radius:10px;">
                                        <div class="mt-3">
                                            <strong>'.$author.'</strong>
                                        </div>
                                        <span style="float:left;" class="m-2 mt-4">
                                            '.$time.'<br>'.$date.'
                                        </span>
                                        <span class="m-2 mt-4" style="font-size:110%;word-wrap:break-word;width:80%">
                                            '.$msg.'
                                        </span>
                                        <span style="float:right;" class="m-2">
                                            <i class="far fa-trash-alt" style="color:white; width:30px; height:30px" onclick="deleteNotification(\''.$code.'\')"></i>
                                        </span>
                                    </div>
                                ';
                            }
                        }

                        // //Display notifications for each existing notification
                        // while($row = $result->fetch_assoc()) {
                        //     $validMessage = false;
                        //     if($perms == 1 && ($row["Permission"]/10000)%2 != 0) {
                        //         $validMessage = true;
                        //     } else if($perms == 2 && ($row["Permission"]/1000)%2 != 0) {
                        //         $validMessage = true;
                        //     } else if($perms == 3 && ($row["Permission"]/100)%2 != 0) {
                        //         $validMessage = true;
                        //     } else if($perms == 4 && ($row["Permission"]/10)%2 != 0) {
                        //         $validMessage = true;
                        //     } else if($perms == 5 && ($row["Permission"]/1)%2 != 0) {
                        //         $validMessage = true;
                        //     } else if($perms == 6) {
                        //         $validMessage = true;
                        //     }
                        //     if($validMessage) {
                        //         $author = $row["Author"];
                        //         $msg = $row["Message"];
                        //         $time = $row["Time"];
                        //         echo '
                        //         <tr>
                        //             <td style="word-wrap: break-word">
                        //                 <strong>'.$author.': </strong>'.$msg.'
                        //             </td>
                        //             <td> '.$time.
                        //                 // '<div id="2" style="float:right;">
                        //                 //     <i class="far fa-trash-alt" style="color:black;width:30px;height:30px"></i>
                        //                 // </div>
                        //             '</td>
                        //         </tr>
                        //         ';
                        //     }
                        // }
                    ?>
                <!-- </tbody> -->
            <!-- </table> -->
            <div class="col-xs-12 my-5">
                <a href="hub.php">
                    <button type="button" class="btn btn-success" style="position:fixed;width:75%;height:5vh;bottom:25px;margin-left:-37.5%;left:50%">Back to Hub</button>
                </a>
            </div>
            </center>
        </div>
    </body>
</html>
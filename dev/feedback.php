<?php
    session_start();
    $perms = $_SESSION["perms"];
    if($_SESSION["isSessionValid"] == false) {
        header('Location: ../index.php');
    } else if($perms != 6) {
        header('Location: ../hub.php');
    }

    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //check connection
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM feedback";
    $result = $conn->query($sql);

?>

<!--Use the authkey table system here-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Feedback - Dev</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script>
        function isRead(id) {
            $.ajax({
                type: "POST",
                url: 'isRead.php',
                data:{action:id},
                success:function() {
                    location.reload();
                }
            });
        }
        function deleteFeedback(id) {
            $.ajax({
                type: "POST",
                url: 'deleteFeedback.php',
                data:{action:id},
                success:function() {
                    var element = document.getElementById(id);
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
                    <h2 class="display-4 text-white text-center">Feedback</h2>
                </div>
                <hr style="border:1px solid white; width:80%">
                <table style="width:80%" class="table table-dark mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Mark as Read</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--in a php loop-->
                        <?php
                            while($row = $result->fetch_assoc()) {
                                if($row["isRead"] == 1) {
                                    $isRead = "Read";
                                } else {
                                    $isRead = "Unread";
                                }
                                $id = $row["entryId"];
                                $subject = "<strong>".$row["username"] . ":</strong> " . $row["Subject"];
                                echo '
                                <tr id="'.$id.'">
                                    <td>'.$row["Date"].'</td>
                                    <td>'.$subject.'</td>
                                    <td><button class="btn btn-info" onclick="isRead('.$id.')">Mark as '.$isRead.'</button></td>
                                    <td><button class="btn btn-info" onclick="deleteFeedback('.$id.')">Delete</button></td>
                                    <td>'.$row["Time"].'</td>
                                </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
                <div class="col-xs-12 py-3">
                    <a href="index.php">
                        <button type="button" class="btn btn-success btn-lg">Back to Dev</button>
                    </a>
                </div>
            </center>
        </div>
    </body>
</html>
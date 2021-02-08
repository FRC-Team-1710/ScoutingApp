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
    </head>
    <body>
    </body>
</html>
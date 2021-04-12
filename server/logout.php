<?php
    session_start();
    $_SESSION["isSessionValid"] = false;
    $_SESSION["psw"] = NULL;
    $_SESSION["uName"] = NULL;
    $_SESSION["fName"] = NULL;
    $_SESSION["lName"] = NULL; 
    $_SESSION["perms"] = NULL;
    $_SESSION["shekels"] = NULL;
    $_SESSION["prompt"] = NULL;
    session_destroy();
    header('Location: ../index.php');
?>
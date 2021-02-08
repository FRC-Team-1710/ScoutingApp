<?php
session_start();

$newId = $_POST["newCompId"];

if($newId == 'test' || $newId == 'gkc' || $newId == 'ia') {
$_SESSION['compId'] = $_POST["newCompId"];
$_SESSION['isCompConfiged'] = true;
} else {
    $_SESSION['compId'] = 'Not valid';
    $_SESSION['isCompConfiged'] = false;
}
header('Location: compConfigure.php');

?>
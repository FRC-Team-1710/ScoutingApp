<?php
session_start();
if($_SESSION["compId"] == null) {
    $_SESSION["compId"] = '';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, intial-scale=1">
<title>Configure Competition Id</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
function goHome() {
    window.location.replace('hub.php');
}
</script>
</head>
<body style="background-color:rgb(54,59,66);">
<center>
    <h3 class="text-white display-4"><?php echo "Competition Id: " . $_SESSION["compId"]; ?></h3>
    <b class="text-white pt-3 text-danger">DO NOT EDIT WITHOUT INSTRUCTION</b>
    <form action="setCompId.php" method="post">
        <label class="pt-4">
            <b class="text-white">Set the competition Id here:</b>
        </label>
        <div class="col-xs-12">
            <input type="text" name="newCompId" placeholder="Put new Competition Id here...">
        </div>
        <input type="submit" class="btn btn-danger btn-lg mt-5" value="Update">
    </form>
    <button class="btn btn-success mt-4" onclick="goHome();">Back to Hub</button>
</center>
</body>
</html>
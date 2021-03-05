<?php
    session_start();
    $perms = $_SESSION["perms"];
    if($_SESSION["isSessionValid"] == false) {
        header('Location: ../index.php');
    } else if($perms != 6) {
        header('Location: ../hub.php');
    }

    $count = 0;
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

    $sql = "SELECT * FROM feedback WHERE isRead = 1";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $count++;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dev Tools</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body style="background-color:rgb(54,59,66)">
    <div class="container">
        <center>
            <div class="pt-3">
                <h2 class="display-4 text-white text-center">
                    Developer Tools
                </h2>
            </div>
            <hr style="border: 1px solid white; width:80%">
            <br>
            <h5 class="text-white pt-3">Broadcast Message</h5>
            <div class="col-xs-12 pt-3">
                <a href="broadcast.php"><button class="btn btn-success">Broadcast</button></a>
            </div>
            <hr style="border:1px solid white; width:80%">
            <form action="giveDev.php" method="post">
                <h5 class="text-white pt-3">Give Dev Abilities</h5>
                <label for="username" class="pt-1">
                    <b class="text-white">Username:</b> <br>
                </label>
                <div class="col-xs-12">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="col-xs-12 pt-3">
                    <button type="submit" class="btn btn-success">Give Dev</button>
                </div>
            </form>
            <hr style="border:1px solid white; width:80%" class="mt-5">
            <br>
            <form action="shekelBank.php" method="post">
                <h5 class="text-white pt-3">Shekel Bank</h5>
                <label for="user" class="pt-1">
                    <b class="text-white">Username:</b>
                </label>
                <div class="col-xs-12 pt-3">
                    <input type="text" placeholder="Username" name="username" required>
                </div> 
                <label for="amount" class="pt-1">
                    <b class="text-white">Amount:</b>
                </label>
                <div class="col-xs-12 pt-3">
                    <input type="number" placeholder="Amount" name="amount" required>
                </div>
                <label class="pt-4">
                    <b class="text-white">Transaction Type:</b>
                </label>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="deposit" name="transactionType" value="0">
                    <label class="custom-control-label text-white" for="deposit">Deposit</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="withdrawal" name="transactionType" value="1">
                    <label class="custom-control-label text-white" for="withdrawal">Withdrawal</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="setBalance" name="transactionType" value="2">
                    <label class="custom-control-label text-white" for="setBalance">Set Balance</label>
                </div>
                <div class="col-xs-12 pt-3">
                    <button type=submit" class="btn btn-success">Process Transaction</button>
                </div>
            </form>
            <hr style="border:1px solid white; width:80%" class="mt-5">
            <br>
            <h5 class="text-white pt-2">Check feedback results</h5>
            <div class="col-xs-12 pt-4">
                <a href="feedback.php">
                    <button class="btn btn-success">Check feedback  <?php echo '<strong>'.$count.'</strong>';?>  </button>
                </a>
            </div>
            <hr style="border:1px solid white; width:80%" class="mt-5">
            <br>
            <div class="col-xs-12 py-3">
                <a href="../hub.php">
                    <button type="button" class="btn btn-success btn-lg">Back to hub</button>
                </a>
            </div>
        </center>
    </div>
</body>
</html>
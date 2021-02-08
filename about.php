<?php
    session_start();
    if($_SESSION["isSessionValid"] == false) {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>About</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color:rgb(54,59,66)">
        <div class="container">
            <center>
                <h2 class="display-4 text-white text-center">
                    About the App
                </h2>
                <hr style="border: 1px solid white; width:80%">
                <div class="col-xs-12 pt-3">
                    <p class="text-white text-center">
                        Welcome to the official Team 1710 Scouting App! <br>
                        We are constantly updating this web app, so please feel free to give us any ideas for updates you'd like to see.<br>
                        We'd like to give a huge thank you to Team 1710 for allowing us to facilitate this app, as well as to Mr. B for allowing us to use his domain space.<br>
                        A special thanks goes out to all the mentors that helped us learn the required code to make this project. <br>
                        &copy; 2019-<?php echo date('Y');?>
                    </p>
                </div>
                <hr style="border: 1px solid white; width:80%" class="mt-5">
                <br>
                <div class="col-xs-12 pt-3">
                    <h5 class="text-white text-center">Instructions</h5>
                    <p class="text-white text-center pt-1">
                        This web app is designed to collect data on FRC Teams during competitions. <br>
                        Before you can begin collecting data as a scout, you must have a valid Competition Key (compKey). <br>
                        The head scout should have access to a different key for each competition. <br>
                        To set your competition key, visit your settings page and enter a value into the Competition Key form. <br> 
                        Do not click submit more than once within 5 seconds as the form may take a second to accept your key. <br>
                        When scouting, be sure to fill out the entire form before submitting.
                    </p>
                </div>
                <hr style="border: 1px solid white; width:80%" class="mt-5">
                <br>
                <div class="col-xs-12 pt-3">
                    <h5 class="text-white text-center mb-4">Changelog</h5>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Version 2</th>
                                <td>Currently in production</td>
                                <td>The "Charlie actually finished the project this time" update</td>
                            </tr>
                            <!-- <tr>
                                <th scope="row">2.9</th>
                                <td></td>
                                <td>Implemented blue alliance api to make scout data more reliable and prevent cheating while shekel betting</td>
                            </tr> -->
                            <!-- <tr>
                                <th scope="row">2.8</th>
                                <td></td>
                                <td>Added a shekel system to allow scouts to bet on matches and climb the leaderboards</td>
                            </tr> -->
                            <!-- <tr>
                                <th scope="row">2.7</th>
                                <td></td>
                                <td>Added a scheduling system so head scouts can schedule shifts for scouts. Scouts can see this in the scout page</td>
                            </tr> -->
                            <!-- <tr>
                                <th scope="row">2.6</th>
                                <td></td>
                                <td>Added a messaging and an internal notification system so that those with the correct permissions can broadcast messages to their team, while team members can send private messages to head scouts</td>
                            </tr> -->
                            <tr>
                                <th scope="row">2.5</th>
                                <td>January 30, 2021</td>
                                <td>Added a feedback form to help devs improve site. Accounts can now be deleted, and team permissions are set. Passwords are now hashed, and SQL injection prevention methods are in place.</td>
                            </tr>
                            <tr>
                                <th scope="row">2.4</th>
                                <td>October 25, 2020</td>
                                <td>Added direct deposit to pay scouts with shekels immediately after scouting. New accounts now get 100 shekels. Shekel count updates to match server when opening settings.</td>
                            </tr>
                            <tr>
                                <th scope="row">2.3</th>
                                <td>October 25, 2020</td>
                                <td>Added alerts to aid user when logging in, creating an account, and resetting password.</td>
                            </tr>
                            <tr>
                                <th scope="row">2.2</th>
                                <td>July 9, 2020</td>
                                <td>Password fields on forms and in settings can now toggle visibility</td>
                            </tr>
                            <tr>
                                <th scope="row">2.1</th>
                                <td>May 18, 2020</td>
                                <td>Added an about page and a changelog</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12 py-3">
                    <a href="hub.php">
                        <button type="button" class="btn btn-success btn-lg">Back to hub</button>
                    </a>
                </div>
            </center>
        </div>
    </body>
</html>
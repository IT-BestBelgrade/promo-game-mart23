<?php

require "dbBroker.php";
require "user.php";


session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['user_id']) && isset($_POST["submit"]) && $_POST["submit"]=="logout") {
    echo "Uspesna odjava";

    session_destroy();
    header('Location: login.php');
    exit();
} 

$user_id = $_SESSION['user_id'];

$user_name = User::returnName($user_id, $conn);
$user_score = User::returnScore($user_id, $conn);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zmijica</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
    <div class="bestica">
    <h1>BESTica</h1>
    <p class="tekst"><b>Tvoj BEST rezultat:</b> <b><?php echo $user_score?></b>!</p>
    <canvas id="board"></canvas>
    <h2>Score: <span id="score"> 0</span></h2>
    </div>

    <form method="POST" action="#">
            <button type="submit" name="submit" value="logout" class="btn btn-logout">Odjavi se</button>
    </form>


    <!-- restart i logout container -->
    <div class="container hide" data-restart>
        <p class="rezultat">Tvoj rezultat je: <b><span id="score-end">0</span></b></p>

        <button class="btn btn-restart" data-restart-btn>Restart</button>
        
        <form method="POST" action="#">
            <button type="submit" name="submit" value="logout" class="btn btn-logout">Odjavi se</button>
        </form>

        <div class="saznajvise">
            <p style="font-size: 15px;">Saznaj više</p> 
            <div class="vise">
            <a href="https://best.rs/" target="_blank"><button class="btn btn-small">O BEST-u</button></a>
            </div>
        </div>

        <!-- <a href="scoreboard.php" target="_blank"><button class="btn">Scoreboard</button></a> -->
    </div>


    <div class="buttons">
        <button id="up" class="btn">UP</button>
        <div style="display:flex; flex-direction:row; justify-content:center;">
            <button id="left" class="btn">LEFT</button>
            <button id="right" class="btn">RIGHT</button>
        </div>
        <button id="down" class="btn">DOWN</button>
    </div>

</body>
</html>
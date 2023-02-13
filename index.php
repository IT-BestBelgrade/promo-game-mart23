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

// $user_id = $_SESSION['user_id'];

// $user_name = User::returnName($user_id, $conn);
// $user_score = User::returnScore($user_id, $conn);


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
</head>
<body>
    <div>
    <h1>BESTica</h1>
    <canvas id="board"></canvas>
    <h2>Score: <span id="score"> 0</span></h2>
    </div>

    <form method="POST" action="#">
            <button type="submit" name="submit" value="logout" class="btn btn-logout">Odjavi se</button>
    </form>

</body>
</html>
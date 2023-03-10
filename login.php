<?php
    
require "dbBroker.php";
require "user.php";

// session_destroy();
session_start();

if(isset($_POST['email']) && isset($_POST['name'])){
    $uemail = $_POST['email'];
    $uname = $_POST['name'];

    $korisnik = new User(null, $uemail, $uname);

    // $odg = $korisnik->loginUser($korisnik, $conn);
    $odg = User::loginUser($korisnik, $conn); //pristup statickim funkcijama preko klasa
    
    if ($odg->num_rows==1){  //email vec postoji u bazi
        $kor = $odg->fetch_assoc();
        echo "postoji user";

        if ($kor['name'] == $uname) {  //user postoji u bazi
            $_SESSION['user_id'] = $kor['id'];
            header('Location: index.php');
            exit();

        } else {  //nije unet isti email i name
            echo "NISTE UNELI DOBRE PODATKE";

            $_SESSION['pogresan_name'] = "pogresan name";
            $_SESSION['pogresan_email'] = $kor['email'];
            header('Location: pogresanLogin.php');
            exit();
        }

    } else if ($odg->num_rows==0){   //novi user
        User::loginNewUser($korisnik, $conn);
        
        $odg2 = User::loginUser($korisnik, $conn); 
        $_SESSION['user_id'] = $odg2->fetch_assoc()['id'];
        header('Location: index.php');
        exit();

    } else{
        echo `<script>console.log( "Neuspesna prijava");</script>`;
        // $korisnik = null;
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BESTica</title>

    <link rel="shortcut icon" href="images/best_logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="css/button.css"> -->
    <!-- <link rel="stylesheet" href="css/drugi.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

    <div class="header" style="justify-content:space-between">
        <img src="images/best_logo_standard.png" alt="BEST Logo" class="logo">
        <h1>BESTica</h1>
        <img src="images/best_logo_white.png" alt="BEST Logo" class="logo">

    </div>

    
    <!-- <img src="images/pozadina.jpg" alt="" class="background"> -->

    <div class="login-form">
        <form method="POST" action="#">

            <div class="container">
                <label for="email" class="lbl">Email</label>
                <input type="email" name="email" id="email" class="inpt" required>
                <br>
                <label for="neme" class="lbl">Instagram</label>
                <input type="text" name="name" id="name" class="inpt" value="@">
                <p class="fusnota" style="font-size:13px; font: weight 500px;">
                    Ako nemate Instagram, unesite nadimak.<br>
                    <!-- <i>Zapamtite vase podatke :)</i> -->
                </p>
                <br>
                <button type="submit" name="submit" value="login" class="button btn-login">Prijavi se</button>
            </div>

        </form>
    </div>

    
</body>
</html>
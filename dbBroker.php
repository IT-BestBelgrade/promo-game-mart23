<?php

$host = "localhost";
$db = "bestica";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_errno){
    // console.log("Neuspesna konekcija. Greska".$conn->connect_error."poz");
    exit("Nauspesna konekcija: greska> ".$conn->connect_error.", err kod>".$conn->connect_errno);
}


?>
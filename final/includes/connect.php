<?php
$user = 'arpitahl_final';
$password = 'password';
$db = 'arpitahl_final';
$host = 'localhost';
$port = 3306;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link, 
   $host, 
   $user, 
   $password, 
   $db,
   $port
);
?>

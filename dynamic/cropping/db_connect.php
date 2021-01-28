<?php
/* Database connection start */
$servername = "localhost";
$username = "chitfind_magni";
$password = "l[NDiNrU9x2";
$dbname = "chitfind_magnafic";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
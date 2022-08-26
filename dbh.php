<?php

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "knightswebsite";

$conn = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);

if (!$conn){
    die("Could not connect to database" . mysqli_connect_error());
}
?>
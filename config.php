<?php
$hostName = 'e-learning-database.co5mt8s56l5r.ap-south-1.rds.amazonaws.com:3306';
$userName = 'shivam';
$password = 'qwerty12345';
$databaseName = 'mini';

$mysqli = new mysqli($hostName, $userName, $password, $databaseName);

if ($mysqli->connect_error){
    echo "Connection Error....<br>";
}
else{
    echo "";
}
?>
<?php

$hostname = "localhost";
$user = "root";
$pass = "";
$db = "lab5";

$conn = new mysqli($hostname, $user, $pass, $db);
if (!$conn) {
    echo "Connection failed";
    die();
}

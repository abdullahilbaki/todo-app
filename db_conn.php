<?php

$hostname = 'localhost';
$username = 'baki';
$password = 'user_baki_pass';
$database = 'todoapp';


$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
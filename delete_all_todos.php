<?php
$conn = new mysqli('localhost', 'baki', 'user_baki_pass', 'todoapp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM todos";

// Execute the SQL statement
$conn->query($sql);

// Reset auto-increment value
$sql = "ALTER TABLE todos AUTO_INCREMENT = 1";

// Execute the SQL statement
$conn->query($sql);

$conn->close();

header("Location: /");
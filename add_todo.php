<?php
// Connect to MariaDB
$conn = new mysqli('localhost', 'baki', 'user_baki_pass', 'todoapp');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get todo task from POST request
$task = htmlspecialchars($_POST['task']);
$description = htmlspecialchars($_POST['description']);
$completed = isset($_POST['completed']) ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO todos (task, description, completed) VALUES (?, ?, ?)");

if ($stmt) {
    $stmt->bind_param("ssi", $task, $description, $completed);
    $stmt->execute();

    $stmt->close();
}

$conn->close();
header("Location: /");

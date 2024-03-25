<?php
// Connect to MariaDB
$conn = new mysqli('localhost', 'baki', 'user_baki_pass', 'todoapp');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get todo task from POST request
$id = $_POST['id'];
$task = htmlspecialchars($_POST['task']);
$description = htmlspecialchars($_POST['description']);
$completed = isset($_POST['completed']) ? 1 : 0;

$stmt = $conn->prepare("UPDATE todos SET task = ?, description = ?, completed = ? WHERE id = ?");

if ($stmt) {
    $stmt->bind_param("ssii", $task, $description, $completed, $id);
    $stmt->execute();

    $stmt->close();
}

$conn->close();
header("Location: /");

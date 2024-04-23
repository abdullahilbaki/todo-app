<?php

include "db_conn.php";

$task = htmlspecialchars($_POST['task'] ?? '');
$description = htmlspecialchars($_POST['description'] ?? '');
$completed = isset($_POST['completed']) ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO todos (task, description, completed) VALUES (?, ?, ?)");

if ($stmt) {
    $stmt->bind_param("ssi", $task, $description, $completed);
    $stmt->execute();

    $todo_id = $stmt->insert_id;

    $uploadDir = "uploads/files/$todo_id/";
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die("Failed to create directory");
        }
    }

    include "upload_files.php";

    $stmt->close();
}

$conn->close();

header("Location: /");

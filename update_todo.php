<?php

include "db_conn.php";

$id = $_POST['id'];
$task = htmlspecialchars($_POST['task']);
$description = htmlspecialchars($_POST['description']);
$completed = isset($_POST['completed']) ? 1 : 0;

$currentTime = date('Y-m-d H:i:s');
$stmt = $conn->prepare("UPDATE todos SET task = ?, description = ?, completed = ?, updated_at = ? WHERE id = ?");

if ($stmt) {
    $stmt->bind_param("ssisi", $task, $description, $completed, $currentTime, $id);
    $stmt->execute();


    $todo_id = $id;

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

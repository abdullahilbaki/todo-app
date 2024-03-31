<?php

$conn = new mysqli('localhost', 'baki', 'user_baki_pass', 'todoapp');

if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

$task = htmlspecialchars($_POST['task']);
$description = htmlspecialchars($_POST['description']);
$completed = isset($_POST['completed']) ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO todos (task, description, completed) VALUES (?, ?, ?)");

if ($stmt) {
   $stmt->bind_param("ssi", $task, $description, $completed);
   $stmt->execute();

   $todo_id = $stmt->insert_id;

   $uploadDir = "uploads/" . $todo_id;
   if (!file_exists($uploadDir)) {
       mkdir($uploadDir, 0777, true);
   }

   $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["attachment"])) {
   $targetDir = "uploads/" . $todo_id . "/";
   $targetFile = $targetDir . basename($_FILES["attachment"]["name"]);

   move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile);

}

$conn->close();

header("Location: /");
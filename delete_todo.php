<?php

// Function to establish a database connection
function connectToDatabase()
{
    $conn = new mysqli('localhost', 'baki', 'user_baki_pass', 'todoapp');
    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to delete a single todo item by ID
function deleteTodoById($conn, $todo_id)
{
    $sql_delete = "DELETE FROM todos WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $todo_id);
    $stmt_delete->execute();
    $stmt_delete->close();
}

// Function to delete multiple todo items by IDs
function deleteTodosByIds($conn, $ids)
{
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "DELETE FROM todos WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $types = str_repeat('i', count($ids)); // 'i' represents integer data type
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error: Unable to prepare SQL statement.";
    }
}

// Main code logic

// Ensure that IDs are provided in the URL
if (isset ($_GET['id']) && !empty ($_GET['id'])) {
    $todo_id = $_GET['id'];
    $conn = connectToDatabase();
    deleteTodoById($conn, $todo_id);
    $conn->close();
    header("Location: /");
    exit(); // Ensure no further execution after redirection

} elseif (isset ($_GET['ids']) && !empty ($_GET['ids'])) {
    $ids = explode(',', $_GET['ids']);
    $conn = connectToDatabase();
    deleteTodosByIds($conn, $ids);
    $conn->close();
    header("Location: /");
    exit(); // Ensure no further execution after redirection

} else {
    echo "Error: No todo IDs provided.";
}

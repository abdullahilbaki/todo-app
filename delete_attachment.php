<?php

include "db_conn.php";

$uuid = $_GET['uuid'];

// Delete the file from the filesystem
$stmt_select = $conn->prepare("SELECT * FROM files WHERE uuid = ?");
$stmt_select->bind_param("s", $uuid);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $todo_id = $row['todo_id'];
    $file = "uploads/files/$todo_id/$uuid." . $row['mime_type'];

    if (file_exists($file)) {
        unlink($file);
    }
}

$stmt_select->close();

// Delete the row from the database
$stmt_delete = $conn->prepare("DELETE FROM files WHERE uuid = ?");
$stmt_delete->bind_param("s", $uuid);
$stmt_delete->execute();

$stmt_delete->close();
$conn->close();

header("Location: edit_form.php?id=$todo_id");
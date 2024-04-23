<?php

include "db_conn.php";

function deleteTodoById($conn, $todo_id)
{

    $sql_delete = "DELETE FROM todos WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $todo_id);
    $stmt_delete->execute();
    $stmt_delete->close();

}

function delete_directory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

function deleteFilesById($conn, $todo_id)
{

    $sql_delete = "DELETE FROM files WHERE todo_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $todo_id);
    $stmt_delete->execute();
    $stmt_delete->close();
    delete_directory("uploads/files/$todo_id");
}

function deleteTodosByIds($conn, $ids)
{
    $sql_delete = "DELETE FROM todos WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
    $stmt_delete = $conn->prepare($sql_delete);
    $types = str_repeat('i', count($ids));
    $stmt_delete->bind_param($types, ...$ids);
    $stmt_delete->execute();
    $stmt_delete->close();


}

function deleteFilesByIds($conn, $ids)
{
    $sql_delete = "DELETE FROM files WHERE todo_id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
    $stmt_delete = $conn->prepare($sql_delete);
    $types = str_repeat('i', count($ids));
    $stmt_delete->bind_param($types, ...$ids);
    $stmt_delete->execute();
    $stmt_delete->close();

    foreach ($ids as $id) {
        deleteFilesById($conn, $id);
    }

}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $todo_id = $_GET['id'];
    deleteFilesById($conn, $todo_id);
    deleteTodoById($conn, $todo_id);
    $conn->close();
    header("Location: /");
    exit();

} elseif (isset($_GET['ids']) && !empty($_GET['ids'])) {
    $ids = explode(',', $_GET['ids']);
    deleteFilesByIds($conn, $ids);
    deleteTodosByIds($conn, $ids);
    $conn->close();
    header("Location: /");
    exit();

} else {
    echo "Error: No todo IDs provided.";
}

<?php

$is_post_request = strtolower($_SERVER['REQUEST_METHOD']) === 'post';
$has_files = isset($_FILES['files']);

if ($is_post_request && $has_files) {
    $files = $_FILES['files'];
    $file_count = count($files['name']);

    $errors = [];
    for ($i = 0; $i < $file_count; $i++) {
        $status = $files['error'][$i];
        $filename = $files['name'][$i];
        $tmp = $files['tmp_name'][$i];
        $fileNameCmps = explode(".", $filename);
        $mime_type = strtolower(end($fileNameCmps));
        $uuid = md5(time() . $filename);
        $name = pathinfo($filename, PATHINFO_FILENAME);


        if ($status !== UPLOAD_ERR_OK) {
            $errors[$filename] = $status;
            continue;
        }

        $stmt = $conn->prepare("INSERT INTO files (todo_id, uuid, name, filename, mime_type) VALUES (?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("issss", $todo_id, $uuid, $name, $filename, $mime_type);
            $stmt->execute();
            move_uploaded_file($tmp, $uploadDir . $uuid . "." . $mime_type);
        }

    }
}
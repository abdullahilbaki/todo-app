<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    include "db_conn.php";
    $uuid = pathinfo(basename($file), PATHINFO_FILENAME);
    $stmt = $conn->prepare("SELECT filename FROM files WHERE uuid = ?");
    $stmt->bind_param("s", $uuid);
    $stmt->execute();

    $stmt->bind_result($filename);

    $stmt->fetch();

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');
        // Read the file and output it to the browser
        readfile($file);
        $stmt->close();
        $conn->close();
        exit;
    } else {
        // File doesn't exist
        die('File not found');
    }
} else {
    // No file specified
    die('No file specified');
}
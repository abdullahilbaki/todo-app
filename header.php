<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $default_title = "To Do App";
    echo "<title>" . (($title == "To Do App") ? $title : "{$title} | {$default_title}") . "</title>";
    ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
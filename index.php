<!DOCTYPE html>
<html lang="en">

<?php
$title = "To Do App";
include "header.php";

?>

<body>
    <div class="w-full h-full flex flex-no-wrap">
        <?php include "sidebar.php"; ?>
        <div style="min-height: 100vh;"
            class="container mx-auto py-10 h-64 md:w-4/5 w-11/12 px-6 overflow-y-auto max-h-screen">
            <?php
            $action = "add_todo.php";
            $task = "";
            $description = "";
            $completed = "";
            include "form.php";
            ?>
        </div>

    </div>

    <?php include "script.php" ?>

</body>

</html>
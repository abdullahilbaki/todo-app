<!DOCTYPE html>
<html lang="en">

<?php
$title = "Edit Todo";
include "header.php";
?>

<body class="bg-gray-100">
    <div class="w-full h-full flex flex-no-wrap">

        <?php include "sidebar.php";

        include "db_conn.php";

        $todo_id = $_GET['id'];

        $sql_todos = "SELECT * FROM todos WHERE id = ?";
        $stmt_todos = $conn->prepare($sql_todos);
        $stmt_todos->bind_param("i", $todo_id);
        $stmt_todos->execute();
        $result_todos = $stmt_todos->get_result();

        $sql_files = "SELECT * FROM files WHERE todo_id = ?";
        $stmt_files = $conn->prepare($sql_files);
        $stmt_files->bind_param("i", $todo_id);
        $stmt_files->execute();
        $result_files = $stmt_files->get_result();

        if ($result_todos->num_rows > 0) {
            $todo = $result_todos->fetch_assoc();
            ?>

            <div class="container mx-auto py-10 md:w-4/5 w-11/12 px-6 overflow-y-auto max-h-screen">
                <?php
                $action = "update_todo.php";
                $id = $todo['id'];
                $task = $todo['task'];
                $description = trim($todo['description']);
                $completed = $todo['completed'] ? 'checked' : '';
                include "form.php";
                ?>
            </div>

            <?php
        } else {
            echo "<p class='text-red-600 p-10 text-3xl'>Todo item not found</p>";
        }

        $stmt_todos->close();
        $stmt_files->close();
        $conn->close();
        ?>


    </div>

    <?php include "script.php" ?>

</body>

</html>
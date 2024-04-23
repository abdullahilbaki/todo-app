<!DOCTYPE html>
<html lang="en">
<?php
$title = "View Todo";
include "header.php";
?>

<body class="bg-gray-100">
    <div class="w-full h-full flex flex-no-wrap">
        <?php include "sidebar.php"; ?>
        <div style="min-height: 100vh;"
            class="container mx-auto py-10 h-64 md:w-4/5 w-11/12 px-6 overflow-y-auto max-h-screen">
            <div class="m-10 gap-x-6 gap-y-8 bg-white p-8 rounded shadow-md">
                <a href="/" class="text-red-600">
                    <h6 class="text-sm font-medium mb-8">Go home</h6>
                </a>
                <?php

                include "db_conn.php";

                $todo_id = $_GET['id'];
                $sql = "SELECT *, 
                        CASE WHEN updated_at IS NOT NULL THEN updated_at ELSE NULL END AS updated_at_display
                        FROM todos WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $todo_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $todo = $result->fetch_assoc();
                    $create_date = date("F j, Y, g:i:s a", strtotime($todo['created_at']));
                    $update_date = ($todo['updated_at_display'] !== NULL && $todo['created_at'] !== $todo['updated_at_display']) ? date("F j, Y, g:i:s a", strtotime($todo['updated_at_display'])) : NULL;
                    ?>
                    <div class="flex justify-between">
                        <p class='text-gray-700'>
                            <span class="font-semibold">Created:</span>
                            <span class="italic">
                                <?php echo $create_date; ?>
                            </span>
                        </p>
                        <?php if ($update_date !== NULL) { ?>
                            <p class='text-gray-700 text-right'>
                                <span class="font-semibold">Last updated:</span>
                                <span class="italic">
                                    <?php echo $update_date; ?>
                                </span>
                            </p>
                        <?php } ?>
                    </div>
                    <p class='py-3 text-2xl font-semibold mb-4'>
                        <?php echo $todo['task']; ?>
                    </p>
                    <p class='py-3 text-gray-700'>
                        <?php echo nl2br($todo["description"]); ?>
                    </p>
                    <?php
                    $folder = "uploads/files/$todo_id/";
                    if (is_dir($folder)) {
                        $sql = "SELECT * FROM files WHERE todo_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $todo_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="flex items-center">';
                                echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>';
                                echo '<a href="download.php?file=' . urlencode($folder . $row["uuid"] . "." . $row["mime_type"]) . '" class="text-blue-500 hover:underline">' . $row["name"] . '</a>';
                                echo '</div>';
                            }
                        }
                    }
                } else {
                    echo "<p class='text-red-600'>Todo item not found</p>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>
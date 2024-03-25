<!DOCTYPE html>
<html lang="en">

<?php
$title = "Edit Todo";
include "header.php";
?>

<body>
    <div class="w-full h-full flex flex-no-wrap">

        <?php include "sidebar.php";

        $conn = new mysqli('localhost', 'baki', 'user_baki_pass', 'todoapp');

        if ($conn->connect_error) {
            die ("Connection failed: " . $conn->connect_error);
        }

        $todo_id = $_GET['id'];

        $sql = "SELECT * FROM todos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $todo_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $todo = $result->fetch_assoc();
            ?>

            <div style="min-height: 100vh;"
                class="container mx-auto py-10 md:w-4/5 w-11/12 px-6 overflow-y-auto max-h-screen">
                <form method="post" action="update_todo.php" onsubmit="return validateForm()">
                    <div class="m-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                            <label for="task" class="block text-2xl font-medium leading-6 text-gray-900">Title</label>
                            <div class="mt-4">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="task" id="task"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        placeholder="Title" value="<?php echo $todo['task'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label for="description"
                                class="block text-2xl font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-4">
                                <textarea id="description" name="description" rows="3"
                                    class="block w-full md:w-1/2 rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?php echo trim($todo['description']) ?></textarea>

                            </div>
                        </div>
                        <div class="flex flex-col gap-5">
                            <p>
                                <input id="completed" name="completed" type="checkbox" <?php echo $todo['completed'] ? 'checked' : ''; ?>
                                    class="h-4 w-4 mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">Completed
                            </p>


                            <button type="submit" name="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                            <button type="button" onclick="window.location.href='/'"
                                class="rounded-md bg-gray-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-400">Cancel</button>
                        </div>
                    </div>
                </form>


            </div>


            <?php
        } else {
            echo "<p class='text-red-600 p-10 text-3xl'>Todo item not found</p>";
        }

        $stmt->close();
        $conn->close();
        ?>


    </div>

    <script>
        function validateForm() {
            var title = document.getElementById("task").value;
            var maxLength = 255;
            if (title.length > maxLength) {
                var excessChars = title.length - maxLength;
                alert("Error: Title is too long. Maximum " + maxLength + " characters allowed. You exceeded the limit by " + excessChars + " characters.");
                return false;
            }
            return true;
        }

        const textarea = document.getElementById('description');

        // Add an event listener for input changes
        textarea.addEventListener('input', function () {
            // Set the textarea's height to its scroll height
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Trigger the event initially to set the initial height
        textarea.dispatchEvent(new Event('input'));
    </script>
</body>

</html>
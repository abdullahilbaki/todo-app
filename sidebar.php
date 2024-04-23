<?php
include "header.php";
?>

<style>
    .active {
        background-color: #4a5568;
        /* Change this color to the desired highlight color */
        /* Add any additional styling for the active state */
    }
</style>


<div style="min-height: 100vh;"
    class="w-2/6 absolute sm:relative bg-gray-800 shadow md:h-full flex-col justify-between hidden sm:flex overflow-y-auto max-h-screen">
    <div class="px-8 ">
        <div class="h-16 w-full flex items-center justify-center">
            <a href="/" class="text-2xl text-blue-500 font-medium text-center pl-10">Todo App</a>
        </div>
        <ol class="mt-3">
            <?php

            include "db_conn.php";

            $sql = "ALTER TABLE todos AUTO_INCREMENT = 1";
            $conn->query($sql);
            $sql = "ALTER TABLE files AUTO_INCREMENT = 1";
            $conn->query($sql);

            $sql = "SELECT * FROM todos ORDER BY id DESC";
            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                ?>
                <div class="pb-4">
                    <input id="select-all-btn" type="checkbox" style="display: none;"
                        class="todo-checkbox h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                </div>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div
                        class="border-b border-gray-300 py-4  <?php echo isset($_GET['id']) && $_GET['id'] == $row['id'] ? "active" : ""; ?>">
                        <li class='text-white flex items-center justify-between'>
                            <div class="flex">
                                <input type="checkbox" style="display: none;" value="<?php echo $row['id']; ?>"
                                    class="todo-checkbox h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <a href="view_todo.php?id=<?php echo $row['id']; ?>" class="block ml-2 hover:text-blue-600"
                                    title="View item">

                                    <?php echo ($row['completed']) ? "<del>" . $row['task'] . "</del>" : $row['task'] ?>
                                </a>
                            </div>

                            <div class='flex'>
                                <a href="edit_form.php?id=<?php echo $row['id']; ?>" class='text-blue-500 mx-2'
                                    title='Edit item'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a> <!-- edit icon -->
                                <a href="delete_todo.php?id=<?php echo $row['id']; ?>" class='text-red-500 mx-2 delete-link'
                                    title='Delete item'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </a> <!-- delete icon -->



                            </div>
                        </li>
                        <span class="text-gray-500 text-sm">
                            <?php echo date("F j, Y, g:i:s a", strtotime($row['created_at'])); ?>
                        </span>
                    </div>
                    <?php
                }
            } else {
                echo "<li class='text-white'>No todos found</li>";
            }

            $conn->close();
            ?>

        </ol>

    </div>
    <?php if ($result->num_rows > 0): ?>
        <div class="flex justify-center mt-48 mb-4 w-full">
            <button id="select-items-btn"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded">Select Items</button>
            <button id="cancel-btn" style="display: none;"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mx-2 rounded">Cancel</button>
            <button id="delete-selected-btn" style="display: none;"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded">Delete Selected
                Items</button>
        </div>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.delete-link').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            const confirmation = confirm("Are you sure you want to delete this To Do?");
            if (confirmation) {
                window.location.href = item.getAttribute('href');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Hide checkboxes and buttons by default
        var checkboxes = document.querySelectorAll('.todo-checkbox');
        checkboxes.forEach(function (checkbox) {
            checkbox.style.display = 'none';
        });
        document.getElementById('select-items-btn').style.display = 'block';

        // Show checkboxes and appropriate buttons when "Select items to delete" button is clicked
        var selectItemsButton = document.getElementById('select-items-btn');
        selectItemsButton.addEventListener('click', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.style.display = 'inline-block';
            });
            selectItemsButton.style.display = 'none';
            document.getElementById('cancel-btn').style.display = 'block';
            document.getElementById('delete-selected-btn').style.display = 'block';
        });

        // Cancel selection
        document.getElementById('cancel-btn').addEventListener('click', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.style.display = 'none';
            });
            document.getElementById('cancel-btn').style.display = 'none';
            document.getElementById('delete-selected-btn').style.display = 'none';
            selectItemsButton.style.display = 'block';
        });

        document.getElementById('delete-selected-btn').addEventListener('click', function () {
            var checkboxes = document.querySelectorAll('.todo-checkbox:checked');
            if (checkboxes.length > 0) {
                var ids = [];
                checkboxes.forEach(function (checkbox) {
                    ids.push(checkbox.value);
                });
                var confirmation = confirm('Are you sure you want to delete selected items?');
                if (confirmation) {
                    // Redirect to delete_todo.php with selected todo ids
                    window.location.href = 'delete_todo.php?ids=' + ids.join(',');
                }
            } else {
                alert('Please select at least one todo item to delete.');
            }
        });

        // Select all checkboxes
        document.getElementById('select-all-btn').addEventListener('click', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = this.checked;
            }, this); // Pass "this" to maintain the correct context
        });

        // Add event listener to checkboxes to toggle "Select all" checkbox state
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var allChecked = true;
                checkboxes.forEach(function (cb) {
                    if (!cb.checked) {
                        allChecked = false;
                    }
                });
                document.getElementById('select-all-btn').checked = allChecked;
            });
        });
    });

</script>
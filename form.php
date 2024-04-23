<form method="post" action="<?php echo $action ?>" onsubmit="return validateForm()" enctype="multipart/form-data">
    <div class="m-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <?php if ($action == "update_todo.php"): ?>
                <input type="hidden" name="id" value="<?php echo $id ?>">
            <?php endif; ?>
            <label for="task" class="block text-2xl font-medium leading-6 text-gray-900">Title</label>
            <div class="mt-4">
                <div
                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input type="text" name="task" id="task"
                        class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                        placeholder="Title" value="<?php echo $task ?>" required>
                </div>
            </div>
        </div>
        <div class="col-span-full">
            <label for="description" class="block text-2xl font-medium leading-6 text-gray-900">Description</label>
            <div class="mt-4">
                <textarea id="description" name="description" rows="3"
                    class="block w-full md:w-1/2 rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?php echo $description ?></textarea>
            </div>
        </div>
        <div class="<?php if ($action == "update_todo.php") {
            echo "col-span-full";
        } ?>  flex flex-col gap-5">
            <p>
                <input class="h-4 w-4 mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" id="completed"
                    name="completed" type="checkbox" <?php echo $completed ?>>Completed
            </p>

            <?php if ($action == "add_todo.php"): ?>
                <div class="my-2">
                    <label for="files" class="my-2 block text-2xl font-medium leading-6 text-gray-900">Attachment</label>
                    <input type="file" name="files[]" id="files" multiple accept=".jpg,.jpeg,.png,.gif,.bmp,.epub,.pdf"
                        class="mt-2">
                </div>

                <button type="submit" name="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create</button>
            <?php elseif ($action == "update_todo.php"): ?>

                <div class="my-2">
                    <label for="attachment" class="block text-2xl font-medium leading-6 text-gray-900">Attachment</label>
                    <div class="my-2">
                        <?php
                        if ($result_files->num_rows > 0) {
                            while ($row = $result_files->fetch_assoc()) {
                                ?>
                                <div class="my-2 flex items-center">
                                    <span class="text-gray-900 mr-2">
                                        <?php echo $row['name']; ?>
                                    </span>
                                    <a href="delete_attachment.php?uuid=<?php echo $row['uuid'] ?>"
                                        class="text-red-600 hover:text-red-800 focus:outline-none">Remove</a>
                                </div>
                            <?php }
                        } ?>
                        <input type="file" name="files[]" id="files" multiple accept=".jpg,.jpeg,.png,.gif,.bmp,.epub,.pdf"
                            class="mt-2">
                    </div>
                </div>
                <div>
                    <button type="submit" name="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
                    <button type="button" onclick="window.location.href='/'"
                        class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>
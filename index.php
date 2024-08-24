<?php
include_once './actions/todolist_db.php';
include_once './actions/task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_task'])) {
        $task->task = $_POST['task'];
        if ($task->create()) {
            echo "Task was created.";
        } else {
            echo "Unable to create task.";
        }
    }

    if (isset($_POST['update_task'])) {
        $task->id = $_POST['id'];
        $task->task = $_POST['task'];
        $task->is_completed = isset($_POST['is_completed']) ? 1 : 0;
        if ($task->update()) {
            echo "Task was updated.";
        } else {
            echo "Unable to update task.";
        }
    }

    if (isset($_POST['delete_task'])) {
        $task->id = $_POST['id'];
        if ($task->delete()) {
            echo "Task was deleted.";
        } else {
            echo "Unable to delete task.";
        }
    }
}

$stmt = $task->read();
?>

<!DOCTYPE html>//
<html>
<head>
    <title>To-Do List</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.3.2-dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h1 class="mt-2">To-Do List</h1>
    <form method="POST" class="mb-2">
        <div class="input-group">
            <input type="text" name="task" class="form-control" placeholder="New task" required>
            <button type="submit" name="add_task" class="btn btn-primary m-2">Add Task</button>
        </div>
    </form>

    <h2>Tasks</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Task</th>
                <th>Completed</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['task']); ?></td>
                    <td>
                        <form method="POST" class="d-inline-block">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="checkbox" name="is_completed" <?php echo $row['is_completed'] ? 'checked' : ''; ?>>
                        </form>
                    </td>
                    <td>
                        <form method="POST" class="d-inline-block">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="task" value="<?php echo htmlspecialchars($row['task']); ?>" class="form-control d-inline-block w-50">
                            <button type="submit" name="update_task" class="btn btn-success btn-sm ms-2">Update</button>
                            <button type="submit" name="delete_task" class="btn btn-danger btn-sm ms-2">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <script src="./assets/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

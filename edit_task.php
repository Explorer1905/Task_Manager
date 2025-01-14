<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch task details
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_id', $task_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        echo "Task not found or access denied.";
        exit;
    }
}

// Update task
if (isset($_POST['update_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];

    try {
        $sql = "UPDATE tasks SET title = :title, description = :description, status = :status, deadline = :deadline WHERE id = :task_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);

        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
body {
  background-image: url('bg1.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}
</style>
<body> <!-- Navigation Bar -->
    <nav>
    <div class="nav-container">
        <div class="logo">TaskManager</div>
        <ul>
            <!-- <li><a href="home.php">Home</a></li> -->
            <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</nav>
    <h2>Edit Task</h2>
    <form action="" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        <br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
        <br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="To Do" <?php if ($task['status'] == 'To Do') echo 'selected'; ?>>To Do</option>
            <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
        </select>
        <br><br>

        <label for="deadline">Deadline:</label>
        <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($task['deadline']); ?>" required>
        <br><br>

        <button type="submit" name="update_task">Update Task</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
    <script src="js/scripts.js"></script>
</body>
</html>

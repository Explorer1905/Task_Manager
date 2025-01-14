<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if (isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $status = $_POST['status']; // Added status field
    $user_id = $_SESSION['user_id'];

    try {
        $sql = "INSERT INTO tasks (title, description, deadline, status, user_id) VALUES (:title, :description, :deadline, :status, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':status', $status); // Bind status field
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        header("Location: dashboard.php"); // Redirect back to the dashboard after adding the task
    } catch (PDOException $e) {
        echo "Error adding task: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
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
<body>
    <!-- Navigation Bar -->
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
    <h4><u>Add New Task</u></h4>
    <form action="add_task.php" method="POST" onsubmit="return validateTaskForm(event)">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br><br>

        <label for="deadline">Deadline:</label>
        <input type="date" id="deadline" name="deadline" required>
        <br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="To Do">To Do</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>
        <br><br>

        <button type="submit" name="add_task">Add Task</button>
    </form>
</body>
</html>

<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch tasks for the logged-in user
$user_id = $_SESSION['user_id'];

try {
    $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY deadline ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching tasks: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
            <li><a href="add_task.php">Add new Task</a></li>
        </ul>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</nav>


    <h4><u>Your Tasks</u></h4>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?php echo htmlspecialchars($task['title']); ?></td>
            <td><?php echo htmlspecialchars($task['description']); ?></td>
            <td><?php echo htmlspecialchars($task['status']); ?></td>
            <td><?php echo htmlspecialchars($task['deadline']); ?></td>
            <td>
                <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                <a href="delete_task.php?id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
 
    
    <script src="js/script.js"></script>
</body>
</html>

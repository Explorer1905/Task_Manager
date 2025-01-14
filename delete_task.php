<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Delete task
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    try {
        $sql = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);

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

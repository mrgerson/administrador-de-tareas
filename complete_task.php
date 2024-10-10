<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $task_id = $_POST['id'];
    $user_id = $_SESSION['user']['id'];
    $query = "UPDATE tasks SET status = 'completed' WHERE id = $task_id AND user_id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>

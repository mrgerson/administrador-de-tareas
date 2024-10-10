<?php
session_start();
include 'db.php';

// Verificar si el ID de la tarea fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $task_id = $_POST['id'];
    $user_id = $_SESSION['user']['id'];

    // Eliminar la tarea solo si pertenece al usuario logueado
    $query = "DELETE FROM tasks WHERE id = $task_id AND user_id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>

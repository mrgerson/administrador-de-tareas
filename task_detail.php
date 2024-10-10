<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'db.php'; // Conectar a la base de datos

// Obtener el ID de la tarea desde la URL
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    // Si no se proporciona un ID válido, redirigir al dashboard
    header('Location: dashboard.php');
    exit();
}

$user_id = $_SESSION['user']['id']; // ID del usuario logueado

// Consultar la tarea específica
$query = "SELECT * FROM tasks WHERE id = $task_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);
$task = mysqli_fetch_assoc($result);

// Si la tarea no existe o no pertenece al usuario logueado
if (!$task) {
    header('Location: dashboard.php');
    exit();
}

// Definir el título de la página
$pageTitle = 'Detalles de Tarea';

// Incluir el header
include 'templates/header.php'; 
?>

<div class="container mt-5">
    <h2 class="mb-4">Detalles de la Tarea</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $task['title']; ?></h5>
            <p class="card-text"><?php echo $task['description']; ?></p>
            <p><strong>Prioridad:</strong> <?php echo ucfirst($task['priority']); ?></p>
            <p><strong>Estado:</strong> <?php echo ucfirst($task['status']); ?></p>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</div>

<?php
// Incluir el footer
include 'templates/footer.php';
?>

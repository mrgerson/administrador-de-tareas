<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'db.php';
$user_id = $_SESSION['user']['id'];

$query = "
    SELECT *, 
    (SELECT COUNT(*) FROM tasks WHERE user_id = $user_id AND status = 'completed') AS completed_count 
    FROM tasks WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

$pageTitle = 'Dashboard';

include 'templates/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <h5 class="sidebar-heading">Menú</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_task.php">Agregar Tarea</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
            <h2 class="mt-5">Mis Tareas</h2>
            <div class="alert alert-info" role="alert">
                <i class="fas fa-check-circle"></i> <strong>Tareas completadas:</strong> <?php echo $tasks[0]['completed_count'] ?? 0; ?>
            </div>
            <a href="logout.php" class="btn btn-danger float-end">Cerrar Sesión</a>
            <a href="add_task.php" class="btn btn-success mb-3">Agregar Tarea</a>
            <div class="row">
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $task['title']; ?></h5>
                                    <p class="card-text"><?php echo $task['description']; ?></p>
                                    <p><strong>Prioridad:</strong> <?php echo ucfirst($task['priority']); ?></p>
                                    <p><strong>Estado:</strong> <?php echo ucfirst($task['status']); ?></p>
                                    <a href="task_detail.php?id=<?php echo $task['id']; ?>" class="btn btn-info mb-2">Ver Detalles</a>

                                    <div class="btn-container d-flex flex-column">
                                        <?php if ($task['status'] == 'pending'): ?>
                                            <button class="btn btn-primary complete-task mb-2" data-id="<?php echo $task['id']; ?>">Completada</button>
                                        <?php endif; ?>
                                        <button class="btn btn-danger delete-task" data-id="<?php echo $task['id']; ?>">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes tareas asignadas.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php include 'templates/footer.php'; ?>

<script>
    document.querySelectorAll('.complete-task').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-id');

            fetch('complete_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${taskId}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        alert('Tarea marcada como completada');
                        location.reload();
                    } else {
                        alert('Hubo un error al marcar la tarea como completada');
                    }
                });
        });
    });

    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-id');
            const confirmation = confirm('¿Estás seguro de que deseas eliminar esta tarea?');

            if (confirmation) {
                fetch('delete_task.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=${taskId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Tarea eliminada');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar la tarea');
                        }
                    });
            }
        });
    });
</script>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'db.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $user_id = $_SESSION['user']['id']; // Obtener el ID del usuario logueado

    if (empty($title) || empty($description) || empty($priority) || empty($status)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    if (empty($errors)) {
        $query = "INSERT INTO tasks (title, description, priority, status, user_id) VALUES ('$title', '$description', '$priority', '$status', '$user_id')";
        if (mysqli_query($conn, $query)) {
            $success = true;
        } else {
            $errors[] = "Hubo un problema al agregar la tarea: " . mysqli_error($conn);
        }
    }
}

$pageTitle = 'Agregar Tarea';

// Incluir el header
include 'templates/header.php'; 
?>

<div class="container mt-5">
    <h2 class="mb-4">Agregar Nueva Tarea</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            ¡Tarea agregada exitosamente!
        </div>
    <?php elseif (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group mb-3">
            <label for="title">Título de la Tarea:</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Descripción:</label>
            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES); ?></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="priority">Prioridad:</label>
            <select name="priority" class="form-control" required>
                <option value="low" <?php echo (($_POST['priority'] ?? '') == 'low') ? 'selected' : ''; ?>>Baja</option>
                <option value="medium" <?php echo (($_POST['priority'] ?? '') == 'medium') ? 'selected' : ''; ?>>Media</option>
                <option value="high" <?php echo (($_POST['priority'] ?? '') == 'high') ? 'selected' : ''; ?>>Alta</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="status">Estado:</label>
            <select name="status" class="form-control" required>
                <option value="pending" <?php echo (($_POST['status'] ?? '') == 'pending') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="completed" <?php echo (($_POST['status'] ?? '') == 'completed') ? 'selected' : ''; ?>>Completada</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Agregar Tarea</button>
    </form>

    <a href="dashboard.php" class="btn btn-secondary mt-3 w-100">Volver al Dashboard</a>
</div>

<?php
// Incluir el footer
include 'templates/footer.php';
?>

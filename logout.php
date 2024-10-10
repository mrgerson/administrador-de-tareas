<?php
session_start();

// Destruir todas las sesiones
session_unset(); 
session_destroy(); 

// Redirigir al formulario de login
header('Location: index.php');
exit();
?>

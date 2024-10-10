<?php
$host = 'localhost';
$port = '3306';
$dbname = 'task_manager'; 
$user = 'root'; 
$pass = ''; 

// Crear conexión
$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

// Verificar conexión
if (!$conn) {
    die('Error de conexión: ' . mysqli_connect_error());
}else

?>

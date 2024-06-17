<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "usuarios";

// Crear conexión
$conexion = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida". $conexion->connect_error);
}

// Habilitar reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
<?php
// Verificar si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "config.php";

// Genera un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica el token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Error: Token CSRF inválido");
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validar entrada de usuario
    if (empty($username) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $conexion = new mysqli($servername, $username_db, $password_db, $dbname);

        if ($conexion->connect_error) {
            die("Fallo al conectar con la base de datos: " . htmlspecialchars($conexion->connect_error, ENT_QUOTES, 'UTF-8'));
        }

        // Consultar la base de datos para verificar las credenciales
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($password, $usuario['password'])) { 
                // Verificar la contraseña con password_verify()
                // Inicio de sesión exitoso
                $_SESSION['username'] = $username;
                $_SESSION['usuario_id'] = $usuario['id'];
                header("Location: principal.php");
                exit(); // Termina el script después de la redirección
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }

        $stmt->close();
        $conexion->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de sesión - Mi Red Social</title>
    <link rel="stylesheet" href="css/sesion.css">
</head>

<body>
    <div class="container">
        <h1>Inicio de sesión</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required />
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required />
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>

</html>
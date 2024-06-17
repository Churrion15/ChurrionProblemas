<?php
// Verificar si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include"config.php";

// Generar un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valida el token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
        die("Error: Token CSRF inválido.");
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar la entrada del usuario
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Error: Correo electrónico no válido.";
    } elseif (strlen($password) < 8) {
        $error_msg = "Error: La contraseña debe tener al menos 8 caracteres.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña

        $conexion = new mysqli($servername, $username_db, $password_db, $dbname);   

        if ($conexion->connect_error) {
            die("Fallo al conectar a la base de datos: " . $conexion->connect_error);
        }

        // Verificar si el correo electrónico ya existe en la base de datos
        $stmt = $conexion->prepare("SELECT email FROM usuario WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El correo electrónico ya está registrado
            $error_msg = "Error: Este correo electrónico ya está en uso.";
        } else {
            // Insertar datos en la base de datos
            $stmt = $conexion->prepare("INSERT INTO usuario (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password_hashed); // Usar la contraseña encriptada

            if ($stmt->execute()) {
                header("Location: login.php");
                exit(); // Termina el script después de la redirección
            } else {
                $error_msg = "Error al registrar usuario: " . $stmt->error;
            }
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
    <title>Registro - Mi Red Social</title>
    <link rel="stylesheet" href="css/sesion.css">
</head>

<body>
    <div class="container">
    <h1>Registro</h1>
        <?php if (!empty($error_msg)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_msg, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form action="registro.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required />
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required />
            </div>
            <?php if (!empty($error_msg)): ?>
                <p class='error'><?php echo htmlspecialchars($error_msg); ?></p>
            <?php endif; ?>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>

</html>
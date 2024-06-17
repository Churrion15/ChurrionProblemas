<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, tamnién destruir las cokkies de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
);
}

// Finalmente, detruir la sesión.
session_destroy();

// Rederigir al usuario a la pagina principal.
header("Location: principal.php");
exit;
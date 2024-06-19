<?php
// Verificar si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include"config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/principlacues.css" />
  <meta name="google" content="notranslate" />
  <link rel="shorcut icon" href="img/nigga.jpeg">
  <title>Cuestionarios</title>
</head>

<body>

<header id="header">
    <nav>
        <ul>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="logout.php" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?');">Cerrar sesión</a></li>
                <li><a href="#">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar sesión</a></li>
                <li><a href="registro.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

  <h1 id="titulo">Cuestionarios</h1>

  <div class="galeria">
    <div class="imagen-container">
      <a href="cuesAnsi.html">
        <img src="https://ayudapsicologicamx.com/wp-content/uploads/2019/03/ansiedad-1024x576.jpg" alt="Imagen sobre la ansiedad" />
        <div class="texto">Cuestionario sobre la ansiedad</div>
      </a>
    </div>
    <div class="imagen-container">
      <a href="cuesDepr.html">
        <img src="https://th.bing.com/th/id/R.29447af12c1042d1535772a1f5c9bd54?rik=vXDGWrfp9NBKWg&pid=ImgRaw&r=0" alt="Imagen sobre la depresión" />
        <div class="texto">Cuestionario sobre la depresión</div>
      </a>
    </div>
    <div class="imagen-container">
      <a href="cuesTAlim.html">
        <img src="https://saludyremedios.es/wp-content/uploads/2020/10/Trastorno-alimentarios-1000x667.jpg" alt="Imagen sobre el trastorno alimentario" />
        <div class="texto">Cuestionario sobre el trastorno de la alimentación</div>
      </a>
    </div>
    <div class="imagen-container">
      <a href="cuesTDAH.html">
        <img src="https://maternidadfacil.com/wp-content/uploads/2015/03/tdah_7.jpg.jpg" alt="Imagen sobre el TDAH" />
        <div class="texto">Cuestionario sobre el TDAH</div>
      </a>
    </div>
    <div class="imagen-container">
      <a href="cuesTSuen.html">
        <img src="https://th.bing.com/th/id/OIP._L81up-wUYoAVAPnRZJ4OgHaFT?rs=1&pid=ImgDetMain" alt="Imagen sobre el sueño" />
        <div class="texto">Cuestionario sobre el sueño</div>
      </a>
    </div>
  </div>

  <button class="volver" onclick="window.location.href='index.php'">Atrás</button>

  <footer>
    <p>
      Los cuestionarios funcionan de la siguiente manera:
      Cada cuestionario tiene 10 preguntas. Cuando hayas contestado todas las preguntas y le des al botón de enviar, te dará el porcentaje del trastorno en cuestión. Queda aclarar que estos cuestionarios calculan un porcentaje que puede indicar la presencia de un problema. Recuerda que es solo una herramienta de autoevaluación y no sustituye un diagnóstico profesional.
    </p>
  </footer>
  <script src="js/principal.js"></script>
</body>

</html>

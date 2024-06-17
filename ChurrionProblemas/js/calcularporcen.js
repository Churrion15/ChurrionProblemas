document.addEventListener("DOMContentLoaded", function() {
  const cuestionarios = document.querySelectorAll(".cuestionario");
  const resultadoDiv = document.getElementById("resultado");
  const resultadoTexto = document.getElementById("resultado-texto");
  const volverBtn = document.getElementById("volver");

  cuestionarios.forEach(cuestionario => {
    const preguntas = cuestionario.querySelectorAll(".pregunta");
    const siguienteBtn = cuestionario.querySelector(".siguiente");
    const anteriorBtn = cuestionario.querySelector(".anterior");
    const enviarBtn = cuestionario.querySelector(".enviar");
    let preguntaActual = 0;

    // Mostrar la pregunta actual
    function mostrarPregunta() {
      preguntas.forEach((pregunta, index) => {
        pregunta.style.display = index === preguntaActual ? "block" : "none";
      });

      if (siguienteBtn) siguienteBtn.style.display = preguntaActual < preguntas.length - 1 ? "block" : "none";
      if (anteriorBtn) anteriorBtn.style.display = preguntaActual > 0 ? "block" : "none";
      if (enviarBtn) enviarBtn.style.display = preguntaActual === preguntas.length - 1 ? "block" : "none";
    }

    // Manejador de clic para el botón "Siguiente"
    if (siguienteBtn) {
      siguienteBtn.addEventListener("click", function() {
        preguntaActual++;
        mostrarPregunta();
      });
    }

    // Manejador de clic para el botón "Anterior"
    if (anteriorBtn) {
      anteriorBtn.addEventListener("click", function() {
        preguntaActual--;
        mostrarPregunta();
      });
    }

    // Manejador de clic para el botón "Enviar"
    if (enviarBtn) {
      enviarBtn.addEventListener("click", function(event) {
        event.preventDefault();
        const respuestas = cuestionario.querySelectorAll(".respuestas input[type='radio']:checked");
        let total = 0;
        respuestas.forEach(respuesta => {
          total += parseInt(respuesta.value, 10);
        });

        const porcentaje = (total / (preguntas.length * 4)) * 100;
        cuestionario.style.display = "none";
        resultadoTexto.textContent = `Tu resultado es: ${porcentaje.toFixed(2)}%`;
        resultadoDiv.style.display = "block";
      });
    }

    // Manejador de clic para el botón "Volver"
    volverBtn.addEventListener("click", function() {
      window.location.href = "principal.php";
    });

    // Mostrar la primera pregunta al cargar la página
    mostrarPregunta();
  });
});
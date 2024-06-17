window.addEventListener('scroll', function() {
  var scroll = window.pageYOffset || document.documentElement.scrollTop;
  var opacity = 1 - (scroll / 500); /* Ajusta el valor para cambiar la velocidad del efecto */
  if (opacity >= 0) {
    document.querySelector('.fading-effect').style.opacity = opacity;
    document.querySelector('.title').style.opacity = opacity;
  }
});

document.addEventListener('DOMContentLoaded', (event) => {
  // Función para alternar la visibilidad de las subsecciones
  function toggleSubsection(id) {
    const subsection = document.getElementById(id);
    const indicator = subsection.previousElementSibling.previousElementSibling;

    if (subsection.style.display === 'block') {
      subsection.style.display = 'none';
      indicator.textContent = '▶'; // Cambia el signo a ">"
    } else {
      subsection.style.display = 'block';
      indicator.textContent = '▼'; // Cambia el signo a "v"
    }
  }

// Función para alternar la visibilidad del menú
  function toggleToc() {
  const toc = document.getElementById('toc_container');
  const toggle = document.getElementById('toc_toggle');
  const body = document.body;

  if (toc.style.transform === 'translateX(0%)') {
    toc.style.transform = 'translateX(-100%)';
    body.style.paddingLeft = '50px';
    toggle.style.left = '0px';
    toggle.textContent = '...';
  } else {
      toc.style.transform = 'translateX(0%)';
      body.style.paddingLeft = '265px';
    toggle.style.left = '210px';
    toggle.textContent = '≡';
    }
  }

  // Agregar controladores de eventos para el botón de alternancia
  document.getElementById('toc_toggle').addEventListener('click', toggleToc);

  // Inicializar todas las subsecciones como ocultas
  document.querySelectorAll('.toc_sub_list').forEach(subList => {
    subList.style.display = 'none';
  });

  // Agregar controladores de eventos para los indicadores y el botón de alternancia
  document.querySelectorAll('.toc_indicator').forEach(indicator => {
    indicator.addEventListener('click', () => {
      const id = indicator.getAttribute('data-subsection');
      toggleSubsection(id);
    });
  });
});
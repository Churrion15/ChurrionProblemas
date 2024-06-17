let lastScrollTop = 0;
const header = document.getElementById('header');

window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        // Desplazamiento hacia abajo
        header.style.top = '-60px'; // Ajusta este valor según la altura del header
    } else {
        // Desplazamiento hacia arriba
        header.style.top = '0';
    }
    lastScrollTop = scrollTop;
});

volverBtn.addEventListener("click", function() {
    window.location.href = "principal.php";
  });
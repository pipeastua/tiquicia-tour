// Carrusel de hoteles con navegación por flechas
document.querySelectorAll('.hotel-grid').forEach(carousel => {
    // Crear contenedor de flechas
    const container = carousel.parentElement;
    const arrowsContainer = document.createElement('div');
    arrowsContainer.className = 'carousel-controls';
    
    // Crear botón anterior
    const prevBtn = document.createElement('button');
    prevBtn.className = 'carousel-btn carousel-btn--prev';
    prevBtn.innerHTML = '&#8249;';
    prevBtn.setAttribute('aria-label', 'Anterior');
    
    // Crear botón siguiente
    const nextBtn = document.createElement('button');
    nextBtn.className = 'carousel-btn carousel-btn--next';
    nextBtn.innerHTML = '&#8250;';
    nextBtn.setAttribute('aria-label', 'Siguiente');
    
    arrowsContainer.appendChild(prevBtn);
    arrowsContainer.appendChild(nextBtn);
    container.insertBefore(arrowsContainer, carousel.nextSibling);
    
    // Funcionalidad de scroll
    const scrollAmount = 300;
    
    prevBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
    
    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
    
    // Deshabilitar botones al llegar a los extremos
    const updateButtons = () => {
        prevBtn.disabled = carousel.scrollLeft === 0;
        nextBtn.disabled = carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth;
    };
    
    carousel.addEventListener('scroll', updateButtons);
    updateButtons();
});

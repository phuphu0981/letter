document.addEventListener('DOMContentLoaded', function () {
    const filmWrapper = document.querySelector('.film-wrapper');

    let scrollPosition = 0;
    const scrollSpeed = 0.5; // Adjust speed as needed

    function animateFilm() {
        scrollPosition -= scrollSpeed;
        filmWrapper.style.transform = `translateX(${scrollPosition}px)`;

        // Reset position to create a seamless loop
        if (Math.abs(scrollPosition) >= filmWrapper.scrollWidth / 2) {
            scrollPosition = 0;
        }

        requestAnimationFrame(animateFilm);
    }

    animateFilm();
});

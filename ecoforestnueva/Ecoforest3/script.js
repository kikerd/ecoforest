let index = 0;
function showNextImage() {
    const slides = document.querySelector('.carousel-slide');
    index = (index + 1) % slides.children.length;
    slides.style.transform = `translateX(${-index * 100}%)`;
}
setInterval(showNextImage, 3000);
document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("info-popup");
    const closeBtn = document.querySelector(".close-btn");

    // Mostrar la ventana emergente al cargar la página
    popup.style.display = "flex";

    
    closeBtn.addEventListener("click", function () {
        popup.style.display = "none";
    });

 
    popup.addEventListener("click", function (event) {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });
});

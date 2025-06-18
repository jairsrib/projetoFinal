let currentIndex = 0;
const slides = document.getElementById("slides");
const thumbnails = document.querySelectorAll("#thumbnails li");
const totalSlides = thumbnails.length;

function showSlide(index) {
    currentIndex = index;
    slides.style.marginLeft = `-${index * 100}%`;
    thumbnails.forEach((thumb, i) => {
        thumb.classList.toggle("active", i === index);
    });
}

thumbnails.forEach((thumb, index) => {
    thumb.addEventListener("click", () => {
        showSlide(index);
    });
});

setInterval(() => {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}, 5000);

showSlide(0);
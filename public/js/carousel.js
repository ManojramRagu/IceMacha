document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".carousel-slide");
    let currentIndex = 0;

    if (slides.length > 0) {
        setInterval(() => {
            // Hide current slide
            slides[currentIndex].classList.add("hidden");

            // Calculate next index
            currentIndex = (currentIndex + 1) % slides.length;

            // Show next slide
            slides[currentIndex].classList.remove("hidden");
        }, 5000); // 5 seconds
    }
});
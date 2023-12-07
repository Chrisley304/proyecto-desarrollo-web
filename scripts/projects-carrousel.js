document.addEventListener("DOMContentLoaded", function () {
    var slider = document.querySelector(".slider");
    var slides = document.querySelectorAll(".slide");
    var currentIndex = 0;

    function showSlide(index) {
        if (index < 0) {
            index = slides.length - 1;
        } else if (index >= slides.length) {
            index = 0;
        }

        currentIndex = index;

        // Move the slides in the DOM
        for (var i = 0; i < slides.length; i++) {
            slides[i].style.order = (i - index + slides.length) % slides.length;
        }
    }

    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    function prevSlide() {
        showSlide(currentIndex - 1);
    }

    // Use setInterval to automatically slide to the next card
    setInterval(nextSlide, 3000); // Adjust the interval as needed
});

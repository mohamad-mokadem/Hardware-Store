//By Mohammad Daoud

//On click alert message
const cartButtons = document.querySelectorAll(".product button");
const alertBox = document.getElementById("custom-alert");
const alertMessage = document.getElementById("alert-message");

cartButtons.forEach(button => {
    button.addEventListener("click", () => {
        const productName = button.parentElement.querySelector("h3").textContent;
        alertMessage.textContent = `${productName} has been added to your cart successfully!`;
        alertBox.classList.add("show");
        setTimeout(() => {
            alertBox.classList.remove("show");
        }, 3000);
    });
});

//cart incrementing
let cartCount = 0; 
const cartCountDisplay = document.getElementById("cart-count");

cartButtons.forEach(button => {
    button.addEventListener("click", () => {
        const productName = button.parentElement.querySelector("h3").textContent;
        alertMessage.textContent = `${productName} has been added to your cart successfully!`;
        alertBox.classList.add("show");
        cartCount++;
        cartCountDisplay.textContent = cartCount;
        setTimeout(() => {
            alertBox.classList.remove("show");
        }, 3000);
    });
});

//Image slider
let currentSlide = 0;
const slides = document.querySelectorAll(".slide");

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.display = (i === index) ? "block" : "none";
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}

setInterval(nextSlide, 3000);
showSlide(currentSlide);



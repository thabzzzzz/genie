// JavaScript
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');

    cards.forEach((card, index) => {
        if (index === cards.length - 1) {
            // Last card
            card.classList.add('no-right-border');
        } else {
            // Not the last card
            card.classList.remove('no-right-border');
        }
    });
});


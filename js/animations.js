const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const fadeObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-show');
            observer.unobserve(entry.target); // Stop observing once animation is triggered
        }
    });
}, observerOptions);

// Function to initialize fade animations
function initFadeAnimations() {
    const fadeElements = document.querySelectorAll('.fade-hidden');
    fadeElements.forEach(element => {
        fadeObserver.observe(element);
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initFadeAnimations);

const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const gradientObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
            gradientObserver.unobserve(entry.target);
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', () => {
    const contactSection = document.querySelector('.pain-point-con');
    if (contactSection) {
        gradientObserver.observe(contactSection);
    }
});

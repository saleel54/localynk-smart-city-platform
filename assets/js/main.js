// Smart Taluk Main JS

document.addEventListener('DOMContentLoaded', function () {

    // Sticky Navbar with Glass Effect
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 10) {
            navbar.classList.add('shadow-sm');
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.padding = '0.75rem 0'; // Slight shrink
        } else {
            navbar.classList.remove('shadow-sm');
            navbar.style.background = 'rgba(255, 255, 255, 0.85)';
            navbar.style.padding = '1rem 0';
        }
    });

    // Intersection Observer for Scroll Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Elements to animate
    const animateElements = document.querySelectorAll('.card, .hero h1, .hero p, .form-container');

    animateElements.forEach((el, index) => {
        el.style.opacity = '0'; // Initial state

        // Add staggered delay classes based on index if siblings
        // This is a simple auto-stagger logic
        if (el.classList.contains('category-card') || el.classList.contains('worker-card')) {
            // We can add inline styles for delays if needed, or rely on CSS classes
            el.style.animationDelay = `${(index % 4) * 0.1}s`;
        }

        observer.observe(el);
    });

    // Smooth Scroll for Anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});

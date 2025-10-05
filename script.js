document.addEventListener('DOMContentLoaded', function() {
    const internationalBtn = document.getElementById('international');
    const domesticBtn = document.getElementById('domestic');
    
    internationalBtn.addEventListener('click', function() {
        window.location.href = 'packages.html?filter=international';
    });
    
    domesticBtn.addEventListener('click', function() {
        window.location.href = 'packages.html?filter=domestic';
    });
    
    // Animate feature cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.feature-card, .about-content, .package-card, .trusted-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
    
    // Book now button functionality
    document.querySelectorAll('.book-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Booking functionality coming soon!');
        });
    });
    
    // Contact form submission
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your inquiry! We will contact you soon.');
        });
    }
    
    // Smooth scroll for navigation links
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    const corporateForm = document.querySelector('.corporate-form');
    
    corporateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('.submit-btn');
        const originalText = submitBtn.textContent;
        
        // Show loading state
        submitBtn.textContent = 'Sending...';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            
            alert('Thank you for your interest!\n\nOur corporate travel team will contact you within 24 hours to discuss your requirements.');
            
            // Reset form
            corporateForm.reset();
        }, 2000);
    });
    
    // Animate cards on scroll
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
    
    // Observe all animated elements
    document.querySelectorAll('.service-card, .benefit-item, .destination-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
    
    // Add hover effects for destination cards
    document.querySelectorAll('.destination-card').forEach(card => {
        card.addEventListener('click', function() {
            const destination = this.querySelector('h3').textContent;
            alert(`Interested in ${destination}?\n\nPlease fill out the form below and our team will create a customized corporate package for you.`);
        });
    });
    
    // Form validation
    const inputs = corporateForm.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                this.style.borderColor = '#4CAF50';
            } else if (this.hasAttribute('required')) {
                this.style.borderColor = '#f44336';
            }
        });
        
        input.addEventListener('focus', function() {
            this.style.borderColor = '#2196F3';
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Category filter functionality
    const categoryBtns = document.querySelectorAll('.category-btn');
    const blogCards = document.querySelectorAll('.blog-card');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            
            blogCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                
                if (category === 'all' || cardCategory === category) {
                    card.classList.remove('hidden');
                    card.classList.add('visible');
                    card.style.display = 'block';
                } else {
                    card.classList.add('hidden');
                    card.classList.remove('visible');
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Read more functionality
    document.querySelectorAll('.read-more').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const blogCard = this.closest('.blog-card');
            const blogTitle = blogCard.querySelector('h3').textContent;
            const blogCategory = blogCard.querySelector('.blog-badge').textContent;
            const blogDate = blogCard.querySelector('.blog-date').textContent.replace('📅 ', '');
            const blogImage = blogCard.querySelector('.blog-image img').src;
            
            // Redirect to blog post page with details
            window.location.href = `blog-post.html?title=${encodeURIComponent(blogTitle)}&category=${encodeURIComponent(blogCategory)}&date=${encodeURIComponent(blogDate)}&image=${encodeURIComponent(blogImage)}`;
        });
    });
    
    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const emailInput = this.querySelector('input[type="email"]');
        const submitBtn = this.querySelector('button');
        const originalText = submitBtn.textContent;
        
        // Show loading state
        submitBtn.textContent = 'Subscribing...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            
            alert('Thank you for subscribing!\n\nYou will receive our latest travel tips and exclusive deals in your inbox.');
            
            emailInput.value = '';
        }, 2000);
    });
    
    // Scroll animation for blog cards
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
    
    blogCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
    
    // Add click animation to category buttons
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // Smooth scroll to top when category changes
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            window.scrollTo({
                top: document.querySelector('.blog-content').offsetTop - 150,
                behavior: 'smooth'
            });
        });
    });
});
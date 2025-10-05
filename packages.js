document.addEventListener('DOMContentLoaded', function() {
    // Check URL for filter parameter
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');
    
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const packageItems = document.querySelectorAll('.package-item');
    
    // Auto-filter if URL parameter exists
    if (filterParam) {
        const targetBtn = document.querySelector(`[data-filter="${filterParam}"]`);
        if (targetBtn) {
            setTimeout(() => targetBtn.click(), 100);
        }
    }
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            packageItems.forEach(item => {
                if (filterValue === 'all') {
                    item.classList.remove('hidden');
                    setTimeout(() => {
                        item.style.display = 'block';
                    }, 100);
                } else {
                    const categories = item.getAttribute('data-category').split(' ');
                    if (categories.includes(filterValue)) {
                        item.classList.remove('hidden');
                        setTimeout(() => {
                            item.style.display = 'block';
                        }, 100);
                    } else {
                        item.classList.add('hidden');
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 500);
                    }
                }
            });
        });
    });
    
    // Book now button functionality
    document.querySelectorAll('.book-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const packageName = this.closest('.package-card').querySelector('h3').textContent;
            const packagePrice = this.closest('.package-card').querySelector('.package-price').textContent;
            const packageImage = this.closest('.package-card').querySelector('.package-image img').src;
            
            // Redirect to booking page with package details
            window.location.href = `booking.html?package=${encodeURIComponent(packageName)}&price=${encodeURIComponent(packagePrice)}&image=${encodeURIComponent(packageImage)}`;
        });
    });
    
    // Smooth scroll animation for package cards
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
    
    // Observe all package items
    packageItems.forEach(item => {
        observer.observe(item);
    });
    
    // Add hover effects for package cards
    document.querySelectorAll('.package-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Search functionality (if needed)
    function searchPackages(searchTerm) {
        packageItems.forEach(item => {
            const packageName = item.querySelector('h3').textContent.toLowerCase();
            const packageLocation = item.querySelector('.package-location').textContent.toLowerCase();
            const packageDescription = item.querySelector('p').textContent.toLowerCase();
            
            if (packageName.includes(searchTerm.toLowerCase()) || 
                packageLocation.includes(searchTerm.toLowerCase()) || 
                packageDescription.includes(searchTerm.toLowerCase())) {
                item.style.display = 'block';
                item.classList.remove('hidden');
            } else {
                item.style.display = 'none';
                item.classList.add('hidden');
            }
        });
    }
    
    // Price range filter (if needed)
    function filterByPrice(minPrice, maxPrice) {
        packageItems.forEach(item => {
            const priceText = item.querySelector('.package-price').textContent;
            const price = parseInt(priceText.replace(/[₹,]/g, ''));
            
            if (price >= minPrice && price <= maxPrice) {
                item.style.display = 'block';
                item.classList.remove('hidden');
            } else {
                item.style.display = 'none';
                item.classList.add('hidden');
            }
        });
    }
    
    // Add click animation to filter buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // Initialize page
    console.log('Packages page loaded successfully!');
});
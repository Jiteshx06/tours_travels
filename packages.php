<?php
require_once 'config/database.php';

// Fetch all packages from database
$packages = [];
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM packages ORDER BY id");
    $stmt->execute();
    $packages = $stmt->fetchAll();
} catch(PDOException $e) {
    // Handle error silently
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages - Sahyog Tours</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="packages.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="assets/logo.png" alt="Sahyog Tours">
                <span>Sahyog Tours</span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php">HOME</a></li>
                <li><a href="about.html">ABOUT US</a></li>
                <li><a href="packages.php" class="active">PACKAGES</a></li>
                <li><a href="corporate.html">CORPORATE</a></li>
                <li><a href="blog.html">BLOG</a></li>
                <li><a href="contact.html">CONTACT US</a></li>
            </ul>
            <div class="phone">
                <span>📞 9988776655</span>
                <?php if(isset($_SESSION['logged_in'])): ?>
                    <a href="dashboard.php" style="margin-left: 20px; color: #fff; text-decoration: none;">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="logout.php" style="margin-left: 10px; color: #fff; text-decoration: none;">Logout</a>
                <?php else: ?>
                    <a href="login.php" style="margin-left: 20px; color: #fff; text-decoration: none;">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section class="packages-hero">
        <div class="packages-hero-content">
            <h1>TRAVEL PACKAGES</h1>
            <p>Discover amazing destinations with our carefully crafted travel packages</p>
        </div>
    </section>

    <section class="package-filters">
        <div class="filter-container">
            <button class="filter-btn active" data-filter="all">All Packages</button>
            <button class="filter-btn" data-filter="international">International</button>
            <button class="filter-btn" data-filter="domestic">Domestic</button>
            <button class="filter-btn" data-filter="honeymoon">Honeymoon</button>
            <button class="filter-btn" data-filter="family">Family</button>
        </div>
    </section>

    <section class="packages-grid-section">
        <div class="packages-container">
            <?php foreach($packages as $package): 
                $categories = str_replace(',', ' ', $package['category']);
            ?>
            <div class="package-item" data-category="<?php echo htmlspecialchars($categories); ?>">
                <div class="package-card">
                    <div class="package-image">
                        <img src="<?php echo htmlspecialchars($package['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($package['package_name']); ?>">
                        <div class="package-overlay">
                            <span class="package-price">₹<?php echo number_format($package['price'], 0); ?></span>
                        </div>
                    </div>
                    <div class="package-content">
                        <h3><?php echo htmlspecialchars($package['package_name']); ?></h3>
                        <p class="package-location">📍 <?php echo htmlspecialchars($package['destination']); ?></p>
                        <p><?php echo htmlspecialchars($package['description']); ?></p>
                        <div class="package-features">
                            <span>🕐 <?php echo htmlspecialchars($package['duration']); ?></span>
                            <?php if($package['max_group_size']): ?>
                                <span>👥 Max. Group Size: <?php echo $package['max_group_size']; ?></span>
                            <?php endif; ?>
                            <?php if($package['includes_flights']): ?>
                                <span>✈️ Flights Included</span>
                            <?php endif; ?>
                            <?php if($package['hotel_rating']): ?>
                                <span>🏨 <?php echo $package['hotel_rating']; ?>-Star Hotels</span>
                            <?php endif; ?>
                        </div>
                        <a href="booking.php?package_id=<?php echo $package['id']; ?>" class="book-btn">Book Now</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="why-choose">
        <h2>Why Choose Sahyog Tours?</h2>
        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon">🏆</div>
                <h3>Best Price Guarantee</h3>
                <p>Get the best value for your money with our competitive pricing</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🛡️</div>
                <h3>Safe & Secure</h3>
                <p>Your safety is our priority with comprehensive travel insurance</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🌟</div>
                <h3>Expert Guidance</h3>
                <p>Professional tour guides to enhance your travel experience</p>
            </div>
            <div class="feature">
                <div class="feature-icon">💯</div>
                <h3>Customer Satisfaction</h3>
                <p>Over 10,000 happy customers and counting</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Sahyog Tours. All rights reserved.</p>
        </div>
    </footer>

    <script src="packages.js"></script>
</body>
</html>
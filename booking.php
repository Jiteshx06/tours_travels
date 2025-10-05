<?php
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['redirect_after_login'] = 'booking.php' . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
    header("Location: login.php");
    exit;
}

// Get package details if package_id is provided
$package = null;
if (isset($_GET['package_id'])) {
    $package_id = intval($_GET['package_id']);
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
        $stmt->execute([$package_id]);
        $package = $stmt->fetch();
    } catch(PDOException $e) {
        // Handle error silently
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Trip - Sahyog Tours</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="booking.css">
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
                <li><a href="packages.php">PACKAGES</a></li>
                <li><a href="corporate.html">CORPORATE</a></li>
                <li><a href="blog.html">BLOG</a></li>
                <li><a href="contact.html">CONTACT US</a></li>
            </ul>
            <div class="phone">
                <span>📞 9988776655</span>
                <?php if(isset($_SESSION['logged_in'])): ?>
                    <a href="dashboard.php" style="margin-left: 20px; color: #fff; text-decoration: none;">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="logout.php" style="margin-left: 10px; color: #fff; text-decoration: none;">Logout</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section class="booking-hero">
        <div class="booking-hero-content">
            <a href="packages.php" class="back-btn">
                <span class="back-arrow">←</span> Back to Packages
            </a>
            <h1>BOOK YOUR DREAM TRIP</h1>
            <p>Fill in your details and we'll get back to you shortly</p>
        </div>
    </section>

    <section class="booking-container">
        <div class="booking-wrapper">
            <div class="package-summary">
                <h2>Package Details</h2>
                <div class="package-info">
                    <?php if($package): ?>
                        <img id="packageImage" src="<?php echo htmlspecialchars($package['image_url']); ?>" alt="Package">
                        <h3 id="packageName"><?php echo htmlspecialchars($package['package_name']); ?></h3>
                        <p class="package-price" id="packagePrice">₹<?php echo number_format($package['price'], 0); ?></p>
                        <div class="package-highlights">
                            <h4>Package Highlights:</h4>
                            <ul>
                                <?php 
                                $highlights = explode('|', $package['highlights']);
                                foreach($highlights as $highlight): 
                                ?>
                                    <li><?php echo htmlspecialchars($highlight); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <img id="packageImage" src="assets/pexels-tobiasbjorkli-2104152.jpg" alt="Package">
                        <h3 id="packageName">Select a Package</h3>
                        <p class="package-price" id="packagePrice">₹XX,XXX</p>
                        <div class="package-highlights">
                            <h4>Package Highlights:</h4>
                            <ul>
                                <li>✈️ Round-trip flights included</li>
                                <li>🏨 Accommodation in premium hotels</li>
                                <li>🍽️ Daily breakfast & select meals</li>
                                <li>🚗 Airport transfers & sightseeing</li>
                                <li>📸 Guided tours with expert guides</li>
                                <li>🎫 Entry tickets to major attractions</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="booking-form-section">
                <h2>Traveler Information</h2>
                <form class="booking-form" id="bookingForm" action="process_booking.php" method="POST">
                    <?php if($package): ?>
                        <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                        <input type="hidden" name="package_price" value="<?php echo $package['price']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullName">Full Name <span class="required">*</span></label>
                            <input type="text" id="fullName" name="fullName" 
                                   value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" 
                                   placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($_SESSION['email']); ?>" 
                                   placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" 
                                   placeholder="+91 9876543210" required>
                        </div>
                        <div class="form-group">
                            <label for="travelers">Number of Travelers <span class="required">*</span></label>
                            <select id="travelers" name="travelers" required onchange="updatePrice()">
                                <option value="">Select</option>
                                <option value="1">1 Person</option>
                                <option value="2">2 People</option>
                                <option value="3">3 People</option>
                                <option value="4">4 People</option>
                                <option value="5">5 People</option>
                                <option value="6">6+ People</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="travelDate">Preferred Travel Date <span class="required">*</span></label>
                            <input type="date" id="travelDate" name="travelDate" 
                                   min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration <span class="required">*</span></label>
                            <select id="duration" name="duration" required>
                                <option value="">Select Duration</option>
                                <option value="3-5">3-5 Days</option>
                                <option value="5-7">5-7 Days</option>
                                <option value="7-10">7-10 Days</option>
                                <option value="10+">10+ Days</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" 
                               placeholder="123 Main Street, City">
                    </div>

                    <div class="form-group">
                        <label for="specialRequests">Special Requests / Notes</label>
                        <textarea id="specialRequests" name="specialRequests" rows="4" 
                                  placeholder="Any special requirements, dietary restrictions, or preferences..."></textarea>
                    </div>

                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="terms" required>
                            I agree to the <a href="#">Terms & Conditions</a> and
                            <a href="#">Privacy Policy</a>
                        </label>
                    </div>

                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="newsletter">
                            Subscribe to newsletter for exclusive deals and offers
                        </label>
                    </div>

                    <div class="price-summary">
                        <div class="price-row">
                            <span>Base Price:</span>
                            <span id="basePrice">₹<?php echo $package ? number_format($package['price'], 0) : 'XX,XXX'; ?></span>
                        </div>
                        <div class="price-row">
                            <span>Taxes & Fees (18%):</span>
                            <span id="taxes">₹<?php echo $package ? number_format($package['price'] * 0.18, 0) : 'X,XXX'; ?></span>
                        </div>
                        <div class="price-row total">
                            <span>Total Amount:</span>
                            <span id="totalPrice">₹<?php echo $package ? number_format($package['price'] * 1.18, 0) : 'XX,XXX'; ?></span>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Confirm Booking</span>
                        <span class="btn-icon">→</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Sahyog Tours. All rights reserved.</p>
        </div>
    </footer>

    <script>
        <?php if($package): ?>
        const basePrice = <?php echo $package['price']; ?>;
        
        function updatePrice() {
            const travelers = document.getElementById('travelers').value;
            if (travelers) {
                const numTravelers = travelers === '6' ? 6 : parseInt(travelers);
                const totalBase = basePrice * numTravelers;
                const taxes = totalBase * 0.18;
                const total = totalBase + taxes;
                
                document.getElementById('basePrice').textContent = '₹' + totalBase.toLocaleString('en-IN');
                document.getElementById('taxes').textContent = '₹' + Math.round(taxes).toLocaleString('en-IN');
                document.getElementById('totalPrice').textContent = '₹' + Math.round(total).toLocaleString('en-IN');
            }
        }
        <?php endif; ?>
    </script>
    <script src="booking-v2.js?v=<?php echo time(); ?>"></script>
</body>
</html>
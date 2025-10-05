<?php
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Fetch user's bookings
$bookings = [];
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT b.*, p.package_name, p.destination, p.image_url, p.duration 
        FROM bookings b 
        JOIN packages p ON b.package_id = p.id 
        WHERE b.user_id = ? 
        ORDER BY b.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $bookings = $stmt->fetchAll();
} catch(PDOException $e) {
    // Handle error silently
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Sahyog Tours</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 80px 20px 40px;
        }
        
        .dashboard-header {
            max-width: 1200px;
            margin: 0 auto 40px;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .dashboard-header h1 {
            margin: 0 0 10px;
            color: #333;
        }
        
        .dashboard-header p {
            color: #666;
            margin: 0;
        }
        
        .bookings-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .booking-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
        }
        
        .booking-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .booking-content {
            padding: 20px;
        }
        
        .booking-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .booking-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0 0 10px;
        }
        
        .booking-details {
            color: #666;
            line-height: 1.8;
        }
        
        .booking-details span {
            display: block;
            margin: 5px 0;
        }
        
        .booking-price {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-top: 15px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .empty-state h2 {
            color: #666;
            margin-bottom: 20px;
        }
        
        .empty-state a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: bold;
        }
    </style>
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
                <a href="logout.php" style="margin-left: 20px; color: #fff; text-decoration: none;">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['full_name'], 0, 1)); ?>
                </div>
                <div>
                    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
                    <p>Here are your travel bookings with Sahyog Tours</p>
                </div>
            </div>
        </div>

        <?php if(count($bookings) > 0): ?>
            <div class="bookings-grid">
                <?php foreach($bookings as $booking): ?>
                    <div class="booking-card">
                        <img src="<?php echo htmlspecialchars($booking['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($booking['package_name']); ?>" 
                             class="booking-image">
                        <div class="booking-content">
                            <span class="booking-status status-<?php echo $booking['status']; ?>">
                                <?php echo $booking['status']; ?>
                            </span>
                            <h3 class="booking-title"><?php echo htmlspecialchars($booking['package_name']); ?></h3>
                            <div class="booking-details">
                                <span>📍 <?php echo htmlspecialchars($booking['destination']); ?></span>
                                <span>📅 Travel Date: <?php echo date('F j, Y', strtotime($booking['travel_date'])); ?></span>
                                <span>⏱️ Duration: <?php echo htmlspecialchars($booking['duration']); ?></span>
                                <span>👥 Travelers: <?php echo $booking['number_of_travelers']; ?></span>
                                <span>🎫 Booking ID: #<?php echo $booking['id']; ?></span>
                                <span>📆 Booked on: <?php echo date('F j, Y', strtotime($booking['booking_date'])); ?></span>
                            </div>
                            <div class="booking-price">
                                ₹<?php echo number_format($booking['total_price'], 2); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>No bookings yet!</h2>
                <p>Start exploring our amazing travel packages and book your dream vacation today.</p>
                <a href="packages.php">Browse Packages</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Sahyog Tours. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
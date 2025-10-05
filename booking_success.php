<?php
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Check if booking was successful
if (!isset($_SESSION['booking_success']) || !isset($_SESSION['booking_id'])) {
    header("Location: packages.php");
    exit;
}

$booking_id = $_SESSION['booking_id'];
unset($_SESSION['booking_success']);
unset($_SESSION['booking_id']);

// Fetch booking details
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT b.*, p.package_name, p.destination, p.duration, p.image_url,
               u.full_name, u.email 
        FROM bookings b 
        JOIN packages p ON b.package_id = p.id 
        JOIN users u ON b.user_id = u.id
        WHERE b.id = ? AND b.user_id = ?
    ");
    $stmt->execute([$booking_id, $_SESSION['user_id']]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        header("Location: dashboard.php");
        exit;
    }
} catch(PDOException $e) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful - Sahyog Tours</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <style>
        .success-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .success-card {
            background: white;
            border-radius: 20px;
            max-width: 800px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.6s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success-header {
            background: linear-gradient(135deg, #48c774 0%, #3ec46d 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }
        
        .success-header h1 {
            margin: 0 0 10px;
            font-size: 32px;
        }
        
        .success-header p {
            margin: 0;
            opacity: 0.95;
            font-size: 18px;
        }
        
        .success-body {
            padding: 40px;
        }
        
        .booking-ref {
            background: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        
        .booking-ref h2 {
            margin: 0 0 10px;
            color: #667eea;
            font-size: 20px;
        }
        
        .booking-ref p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }
        
        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        
        .detail-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .detail-content h3 {
            margin: 0 0 5px;
            color: #666;
            font-size: 14px;
            font-weight: normal;
        }
        
        .detail-content p {
            margin: 0;
            color: #333;
            font-weight: bold;
            font-size: 16px;
        }
        
        .price-box {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
        }
        
        .price-box h3 {
            margin: 0 0 10px;
            color: #e67e22;
        }
        
        .price-box .amount {
            font-size: 36px;
            font-weight: bold;
            color: #e67e22;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #f1f1f1;
            color: #333;
        }
        
        .info-message {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        
        .info-message p {
            margin: 0;
            color: #2e7d32;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">✓</div>
                <h1>Booking Successful!</h1>
                <p>Your adventure with Sahyog Tours is confirmed</p>
            </div>
            
            <div class="success-body">
                <div class="booking-ref">
                    <h2>Booking Reference</h2>
                    <p>#<?php echo str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?></p>
                </div>
                
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-icon">📦</div>
                        <div class="detail-content">
                            <h3>Package</h3>
                            <p><?php echo htmlspecialchars($booking['package_name']); ?></p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">📍</div>
                        <div class="detail-content">
                            <h3>Destination</h3>
                            <p><?php echo htmlspecialchars($booking['destination']); ?></p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">📅</div>
                        <div class="detail-content">
                            <h3>Travel Date</h3>
                            <p><?php echo date('F j, Y', strtotime($booking['travel_date'])); ?></p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">⏱️</div>
                        <div class="detail-content">
                            <h3>Duration</h3>
                            <p><?php echo htmlspecialchars($booking['duration']); ?></p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">👥</div>
                        <div class="detail-content">
                            <h3>Number of Travelers</h3>
                            <p><?php echo $booking['number_of_travelers']; ?> <?php echo $booking['number_of_travelers'] == 1 ? 'Person' : 'People'; ?></p>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">✉️</div>
                        <div class="detail-content">
                            <h3>Confirmation Email</h3>
                            <p><?php echo htmlspecialchars($booking['email']); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="price-box">
                    <h3>Total Amount</h3>
                    <div class="amount">₹<?php echo number_format($booking['total_price'], 2); ?></div>
                    <p style="color: #666; margin-top: 10px;">Including all taxes and fees</p>
                </div>
                
                <div class="info-message">
                    <p>
                        <strong>What happens next?</strong><br>
                        • A confirmation email has been sent to your registered email address<br>
                        • Our travel expert will contact you within 24 hours<br>
                        • You'll receive a detailed itinerary 7 days before your travel date<br>
                        • Payment instructions will be shared separately
                    </p>
                </div>
                
                <div class="action-buttons">
                    <a href="dashboard.php" class="btn btn-primary">View My Bookings</a>
                    <a href="packages.php" class="btn btn-secondary">Browse More Packages</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
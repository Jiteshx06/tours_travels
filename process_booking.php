<?php
require_once 'config/database.php';
require_once 'includes/email_helper.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: packages.php");
    exit;
}

// Get form data
$package_id = intval($_POST['package_id'] ?? 0);
$fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$travelers = intval($_POST['travelers'] ?? 1);
$travelDate = $_POST['travelDate'] ?? '';
$duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$specialRequests = filter_input(INPUT_POST, 'specialRequests', FILTER_SANITIZE_STRING);

// Validate required fields
if (empty($package_id) || empty($fullName) || empty($email) || empty($phone) || empty($travelDate)) {
    $_SESSION['booking_error'] = "Please fill in all required fields.";
    header("Location: booking.php?package_id=" . $package_id);
    exit;
}

try {
    $conn = getDBConnection();
    
    // Get package details
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->execute([$package_id]);
    $package = $stmt->fetch();
    
    if (!$package) {
        throw new Exception("Package not found.");
    }
    
    // Calculate total price
    $base_price = $package['price'] * $travelers;
    $taxes = $base_price * 0.18; // 18% tax
    $total_price = $base_price + $taxes;
    
    // Insert booking into database
    $stmt = $conn->prepare("
        INSERT INTO bookings (
            user_id, package_id, travel_date, number_of_travelers, 
            total_price, special_requests, status, payment_status
        ) VALUES (?, ?, ?, ?, ?, ?, 'confirmed', 'pending')
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $package_id,
        $travelDate,
        $travelers,
        $total_price,
        $specialRequests
    ]);
    
    $booking_id = $conn->lastInsertId();
    
    // Prepare email data
    $emailData = [
        'booking_id' => $booking_id,
        'customer_name' => $fullName,
        'customer_email' => $email,
        'package_name' => $package['package_name'],
        'destination' => $package['destination'],
        'travel_date' => $travelDate,
        'duration' => $package['duration'],
        'travelers' => $travelers,
        'base_price' => $base_price,
        'taxes' => $taxes,
        'total_price' => $total_price,
        'special_requests' => $specialRequests
    ];
    
    // Send confirmation email
    $emailSent = sendBookingConfirmationEmail($emailData);
    
    // Redirect to success page
    $_SESSION['booking_success'] = true;
    $_SESSION['booking_id'] = $booking_id;
    header("Location: booking_success.php");
    exit;
    
} catch(Exception $e) {
    $_SESSION['booking_error'] = "Booking failed: " . $e->getMessage();
    header("Location: booking.php?package_id=" . $package_id);
    exit;
}
?>
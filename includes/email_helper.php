<?php
// Email configuration and helper functions

// Autoload and class imports must be at file scope (not inside a function)
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendBookingConfirmationEmail($data) {
    $to = $data['customer_email'];
    $subject = "Booking Confirmation - Sahyog Tours #" . $data['booking_id'];
    
    // Create beautiful HTML email
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
            .email-wrapper { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; text-align: center; }
            .header h1 { margin: 0; font-size: 32px; }
            .header p { margin: 10px 0 0; opacity: 0.9; }
            .content { padding: 40px; }
            .booking-details { background-color: #f9f9f9; padding: 25px; border-radius: 10px; margin: 20px 0; }
            .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e0e0e0; }
            .detail-row:last-child { border-bottom: none; }
            .detail-label { font-weight: bold; color: #555; }
            .detail-value { color: #333; }
            .price-summary { background-color: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; }
            .total-price { font-size: 24px; font-weight: bold; color: #e67e22; }
            .cta-button { display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { background-color: #333; color: white; padding: 30px; text-align: center; }
            .footer p { margin: 5px 0; }
            .social-links { margin: 20px 0; }
            .social-links a { color: white; text-decoration: none; margin: 0 10px; }
            .highlight-box { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: center; }
        </style>
    </head>
    <body>
        <div class="email-wrapper">
            <div class="header">
                <h1>🎉 Booking Confirmed!</h1>
                <p>Your adventure with Sahyog Tours begins here</p>
            </div>
            
            <div class="content">
                <p style="font-size: 18px; color: #333;">Dear <strong>' . htmlspecialchars($data['customer_name']) . '</strong>,</p>
                
                <p style="color: #666; line-height: 1.6;">
                    Thank you for choosing Sahyog Tours! We\'re thrilled to confirm your booking for an unforgettable journey. 
                    Your adventure is all set, and we can\'t wait to make your travel dreams come true!
                </p>
                
                <div class="highlight-box">
                    <h2 style="margin: 0 0 10px;">Booking ID: #' . $data['booking_id'] . '</h2>
                    <p style="margin: 0;">Please keep this for your records</p>
                </div>
                
                <div class="booking-details">
                    <h3 style="color: #667eea; margin-top: 0;">📋 Booking Details</h3>
                    <div class="detail-row">
                        <span class="detail-label">Package:</span>
                        <span class="detail-value">' . htmlspecialchars($data['package_name']) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Destination:</span>
                        <span class="detail-value">📍 ' . htmlspecialchars($data['destination']) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Travel Date:</span>
                        <span class="detail-value">📅 ' . date('F j, Y', strtotime($data['travel_date'])) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Duration:</span>
                        <span class="detail-value">⏱️ ' . htmlspecialchars($data['duration']) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Number of Travelers:</span>
                        <span class="detail-value">👥 ' . $data['travelers'] . ' ' . ($data['travelers'] == 1 ? 'Person' : 'People') . '</span>
                    </div>
                    ' . (!empty($data['special_requests']) ? '
                    <div class="detail-row">
                        <span class="detail-label">Special Requests:</span>
                        <span class="detail-value">' . htmlspecialchars($data['special_requests']) . '</span>
                    </div>' : '') . '
                </div>
                
                <div class="price-summary">
                    <h3 style="color: #e67e22; margin-top: 0;">💰 Payment Summary</h3>
                    <div class="detail-row">
                        <span class="detail-label">Base Price:</span>
                        <span class="detail-value">₹' . number_format($data['base_price'], 2) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Taxes & Fees (18%):</span>
                        <span class="detail-value">₹' . number_format($data['taxes'], 2) . '</span>
                    </div>
                    <div class="detail-row" style="margin-top: 10px; padding-top: 10px; border-top: 2px solid #e67e22;">
                        <span class="detail-label total-price">Total Amount:</span>
                        <span class="detail-value total-price">₹' . number_format($data['total_price'], 2) . '</span>
                    </div>
                </div>
                
                <div style="background-color: #e8f5e9; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #4caf50; margin-top: 0;">✅ What\'s Next?</h3>
                    <ol style="color: #666; line-height: 1.8;">
                        <li>Our travel expert will contact you within 24 hours to finalize the details</li>
                        <li>You\'ll receive a detailed itinerary 7 days before your travel date</li>
                        <li>Complete payment must be made 48 hours before departure</li>
                        <li>Pack your bags and get ready for an amazing journey!</li>
                    </ol>
                </div>
                
                <center>
                    <a href="http://localhost/tours/dashboard.php" class="cta-button">View Your Booking</a>
                </center>
                
                <div style="margin-top: 30px; padding: 20px; background-color: #fff9c4; border-radius: 10px;">
                    <h3 style="color: #f57c00; margin-top: 0;">📞 Need Help?</h3>
                    <p style="color: #666;">Our customer support team is here to assist you:</p>
                    <p style="color: #333;">
                        <strong>Phone:</strong> +91 99887 76655<br>
                        <strong>Email:</strong> support@sahyogtours.com<br>
                        <strong>Office Hours:</strong> Mon-Sat, 9:00 AM - 6:00 PM IST
                    </p>
                </div>
            </div>
            
            <div class="footer">
                <h3 style="margin-top: 0;">Follow Us</h3>
                <div class="social-links">
                    <a href="#">Facebook</a> |
                    <a href="#">Instagram</a> |
                    <a href="#">Twitter</a> |
                    <a href="#">YouTube</a>
                </div>
                <p>© 2024 Sahyog Tours. All rights reserved.</p>
                <p style="font-size: 12px; opacity: 0.8;">
                    This email was sent to ' . htmlspecialchars($data['customer_email']) . '<br>
                    You received this email because you made a booking with Sahyog Tours.
                </p>
            </div>
        </div>
    </body>
    </html>';
    
    // Email headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: Sahyog Tours <bookings@sahyogtours.com>" . "\r\n";
    $headers .= "Reply-To: support@sahyogtours.com" . "\r\n";
    
    // Send email using PHP's mail() (kept as original)
    $success = @mail($to, $subject, $message, $headers);
    
    // Alternative: Using PHPMailer (recommended for production)
    // Uncomment below if you have PHPMailer installed via Composer
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Or your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jiteshp277@gmail.com';
        $mail->Password   = 'lvtljzeaotbtyvqd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom('bookings@sahyogtours.com', 'Sahyog Tours');
        $mail->addAddress($to, $data['customer_name']);
        $mail->addReplyTo('support@sahyogtours.com', 'Support');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
        return false;
    }
    
    
    return $success;
}

// Function to send password reset email
function sendPasswordResetEmail($email, $token) {
    $resetLink = "http://localhost/tours/reset-password.php?token=" . $token;
    $subject = "Password Reset Request - Sahyog Tours";
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .email-wrapper { max-width: 600px; margin: 0 auto; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
            .content { padding: 30px; background: #f9f9f9; }
            .button { display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class="email-wrapper">
            <div class="header">
                <h2>Password Reset Request</h2>
            </div>
            <div class="content">
                <p>You have requested to reset your password for your Sahyog Tours account.</p>
                <p>Click the link below to reset your password:</p>
                <p><a href="' . $resetLink . '" class="button">Reset Password</a></p>
                <p>If you did not request this, please ignore this email.</p>
                <p>This link will expire in 1 hour.</p>
            </div>
        </div>
    </body>
    </html>';
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: Sahyog Tours <noreply@sahyogtours.com>" . "\r\n";
    
    return @mail($email, $subject, $message, $headers);
}
?>

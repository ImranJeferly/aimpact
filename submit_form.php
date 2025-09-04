<?php
require 'vendor/autoload.php';
require_once 'config/firebase.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $tasks = isset($_POST['tasks']) ? implode(", ", $_POST['tasks']) : '';
    $ai_experience = $_POST['q2'] ?? '';
    $timeline = $_POST['q3'] ?? '';
    $budget = $_POST['q4'] ?? '';
    $business_name = $_POST['business_name'] ?? '';
    $contact_name = $_POST['contact_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    try {
        // Firebase submission
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $submissionData = [
                'tasks' => $tasks,
                'ai_experience' => $ai_experience,
                'timeline' => $timeline,
                'budget' => $budget,
                'business_name' => $business_name,
                'contact_name' => $contact_name,
                'email' => $email,
                'phone' => $phone
            ];
            
            $submissionId = $firebaseHelper->addSubmission($submissionData);
            if (!$submissionId) {
                throw new Exception("Failed to save submission to database");
            }
        } else {
            throw new Exception("Database connection failed");
        }

        // Send email to admins
        $mail = new PHPMailer(true);
        
        // Email server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'imranjeferly@gmail.com';
        $mail->Password = 'eywb befs uxsm gwsq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Admin notification email
        $mail->setFrom('noreply@aimpact.com', 'AImpact Form');
        $mail->addAddress('imranjeferly@gmail.com', 'Imran');
        $mail->addAddress('Kazimlihuseyn13@gmail.com', 'Huseyn');
        $mail->addReplyTo($email, $contact_name);

        $mail->isHTML(true);
        $mail->Subject = 'New AImpact Form Submission';
        
        // Create HTML email content for admins
        $adminEmailContent = "
            <h2>New Form Submission</h2>
            <p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>
            
            <h3>Selected Tasks:</h3>
            <ul>" . 
                implode('', array_map(function($task) {
                    return "<li>" . htmlspecialchars($task) . "</li>";
                }, explode(", ", $tasks))) . 
            "</ul>
            
            <h3>AI Experience:</h3>
            <p>" . htmlspecialchars($ai_experience) . "</p>
            
            <h3>Timeline:</h3>
            <p>" . htmlspecialchars($timeline) . "</p>
            
            <h3>Budget:</h3>
            <p>" . htmlspecialchars($budget) . "</p>
            
            <h3>Business Information:</h3>
            <p><strong>Business Name:</strong> " . htmlspecialchars($business_name) . "</p>
            <p><strong>Contact Name:</strong> " . htmlspecialchars($contact_name) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>
        ";

        $mail->Body = $adminEmailContent;
        $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $adminEmailContent));

        $mail->send();

        // Send thank you email to the user
        $userMail = new PHPMailer(true);
        
        // Reuse the same SMTP settings
        $userMail->isSMTP();
        $userMail->Host = 'smtp.gmail.com';
        $userMail->SMTPAuth = true;
        $userMail->Username = 'imranjeferly@gmail.com';
        $userMail->Password = 'eywb befs uxsm gwsq';
        $userMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $userMail->Port = 587;

        $userMail->setFrom('noreply@aimpact.com', 'AImpact');
        $userMail->addAddress($email, $contact_name);
        
        $userMail->isHTML(true);
        $userMail->Subject = 'Welcome to AImpact - We\'ve Received Your Request';

        // Create HTML email content for user
        $userEmailContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap' rel='stylesheet'>
            <style>
                /* Base Styles */
                body {
                    margin: 0;
                    padding: 0;
                    background-color: #000000;
                    font-family: 'Montserrat', Arial, sans-serif;
                    color: #ffffff;
                    line-height: 1.6;
                    width: 100% !important;
                    max-width: 100% !important;
                }

                /* Container */
                .email-container {
                    width: 100% !important;
                    max-width: 100% !important;
                    margin: 0 auto;
                    background: linear-gradient(141.11deg, #202020 -8.6%, #000000 108.43%);
                    background-image: url('https://aimpact.web.app/assets/bg-effect.svg'), linear-gradient(141.11deg, #202020 -8.6%, #000000 108.43%);
                    background-repeat: no-repeat;
                    background-position: top right;
                    background-size: contain;
                }

                /* Header Section */
                .header {
                    padding: 40px 20px;
                    text-align: center;
                    background: linear-gradient(141.11deg, rgba(255, 255, 255, 0.05) -8.6%, rgba(153, 153, 153, 0.05) 108.43%);
                    border-bottom: 1px solid #464646;
                }

                .header img {
                    max-width: 180px;
                    height: auto;
                    margin-bottom: 30px;
                }

                .welcome-text {
                    font-size: 32px;
                    font-weight: 500;
                    color: #FFFFFF !important;
                    margin-bottom: 20px;
                }

                /* Content Sections */
                .section {
                    padding: 40px 30px;
                    border-bottom: 1px solid #464646;
                }

                .section h2 {
                    font-size: 24px;
                    font-weight: 500;
                    color: #E85823 !important;
                    margin-bottom: 20px;
                }

                .section p {
                    color: #848484 !important;
                    font-size: 16px;
                    margin-bottom: 20px;
                    line-height: 1.8;
                }

                /* Steps Section */
                .steps {
                    display: block;
                    margin: 30px 0;
                }

                .step {
                    background: linear-gradient(141.11deg, rgba(255, 255, 255, 0.05) -8.6%, rgba(153, 153, 153, 0.05) 108.43%);
                    border: 1px solid #464646;
                    border-radius: 15px;
                    padding: 20px;
                    margin-bottom: 15px;
                }

                .step h3 {
                    color: #ffffff !important;
                    font-size: 18px;
                    margin: 0 0 10px 0;
                }

                .step p {
                    color: #848484 !important;
                    font-size: 14px;
                    margin: 0;
                }

                /* Stats Section */
                .stats {
                    display: block;
                    text-align: center;
                    padding: 30px;
                    background: linear-gradient(141.11deg, rgba(232, 88, 35, 0.1) -8.6%, rgba(232, 88, 35, 0.05) 108.43%);
                    border-radius: 15px;
                    margin: 20px 0;
                }

                .stat-item {
                    margin: 20px 0;
                }

                .stat-number {
                    font-size: 36px;
                    font-weight: 600;
                    color: #E85823;
                }

                .stat-label {
                    color: #848484;
                    font-size: 14px;
                }

                /* Contact Section */
                .contact-section {
                    text-align: center;
                    padding: 40px 20px;
                }

                .social-links {
                    margin: 30px 0;
                }

                .social-btn {
                    display: inline-block;
                    padding: 12px 30px;
                    margin: 10px;
                    border-radius: 25px;
                    text-decoration: none;
                    font-size: 16px;
                    transition: all 0.3s ease;
                    background: linear-gradient(141.11deg, rgba(255, 255, 255, 0.05) -8.6%, rgba(153, 153, 153, 0.05) 108.43%);
                    border: 1px solid #464646;
                }

                .whatsapp { color: #25D366 !important; }
                .telegram { color: #0088cc !important; }
                .messenger { color: #A855F7 !important; }

                /* Footer */
                .footer {
                    padding: 30px 20px;
                    text-align: center;
                    font-size: 12px;
                    color: #848484;
                    background: linear-gradient(141.11deg, #202020 -8.6%, #000000 108.43%);
                }

                /* Call to Action Button */
                .cta-btn {
                    display: inline-block;
                    padding: 15px 40px;
                    background: #E85823;
                    color: white !important;
                    text-decoration: none;
                    border-radius: 30px;
                    font-size: 16px;
                    margin: 20px 0;
                }

                /* Fix for Outlook */
                table {
                    border-collapse: collapse;
                    border-spacing: 0;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                }

                /* Force full width */
                .force-full-width {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            </style>
        </head>
        <body style='margin: 0; padding: 0; width: 100% !important; max-width: 100% !important;'>
            <table class='force-full-width' cellspacing='0' cellpadding='0' border='0' width='100%'>
                <tr>
                    <td>
                        <div class='email-container force-full-width'>
                            <div class='header'>
                                <img src='https://aimpact.web.app/assets/logo.svg' alt='AImpact Logo'>
                                <div class='welcome-text'>Welcome to AImpact, " . htmlspecialchars($contact_name) . "!</div>
                                <p style='color: #848484; font-size: 16px;'>Your journey towards AI-powered business transformation begins now.</p>
                            </div>

                            <div class='section'>
                                <h2>Your Request Has Been Received</h2>
                                <p>We're thrilled to have you on board and can't wait to help transform your business with cutting-edge AI solutions. Our team of experts is already reviewing your requirements to prepare a tailored solution that perfectly matches your needs.</p>
                                
                                <div class='stats'>
                                    <div class='stat-item'>
                                        <div class='stat-number'>70%</div>
                                        <div class='stat-label'>Average Reduction in Manual Tasks</div>
                                    </div>
                                    <div class='stat-item'>
                                        <div class='stat-number'>85%</div>
                                        <div class='stat-label'>Faster Workflow Completion</div>
                                    </div>
                                    <div class='stat-item'>
                                        <div class='stat-number'>3x</div>
                                        <div class='stat-label'>Increase in Team Productivity</div>
                                    </div>
                                </div>
                            </div>

                            <div class='section'>
                                <h2>What Happens Next?</h2>
                                <div class='steps'>
                                    <div class='step'>
                                        <h3>1. Expert Review</h3>
                                        <p>Our AI specialists are analyzing your business requirements to identify the best automation opportunities.</p>
                                    </div>
                                    <div class='step'>
                                        <h3>2. Solution Design</h3>
                                        <p>We'll create a customized AI implementation plan tailored specifically to your business needs.</p>
                                    </div>
                                    <div class='step'>
                                        <h3>3. Personal Consultation</h3>
                                        <p>Within 24 hours, our team will reach out to schedule a detailed discussion about your AI transformation journey.</p>
                                    </div>
                                </div>
                            </div>

                            <div class='section'>
                                <h2>Why Choose AImpact?</h2>
                                <div class='step'>
                                    <h3>✓ Proven Expertise</h3>
                                    <p>Trusted by 200+ businesses worldwide with a 98% satisfaction rate.</p>
                                </div>
                                <div class='step'>
                                    <h3>✓ Customized Solutions</h3>
                                    <p>Tailored AI implementation strategies designed specifically for your business needs.</p>
                                </div>
                                <div class='step'>
                                    <h3>✓ Ongoing Support</h3>
                                    <p>Dedicated support team to ensure smooth integration and optimal performance.</p>
                                </div>
                            </div>

                            <div class='contact-section'>
                                <h2>Ready to Get Started?</h2>
                                <p style='color: #848484;'>Connect with us through your preferred platform:</p>
                                
                                <div class='social-links'>
                                    <a href='https://wa.me/YOUR_WHATSAPP_NUMBER' class='social-btn whatsapp'>WhatsApp</a>
                                    <a href='https://t.me/YOUR_TELEGRAM' class='social-btn telegram'>Telegram</a>
                                    <a href='http://m.me/YOUR_FACEBOOK_PAGE' class='social-btn messenger'>Messenger</a>
                                </div>

                                <p style='color: #848484; font-size: 14px;'>Want to learn more about our AI solutions?</p>
                                <a href='https://aimpact.web.app' class='cta-btn'>Explore Our Services</a>
                            </div>

                            <div class='footer'>
                                <p>This is an automated message. Please don't reply to this email.</p>
                                <p>&copy; 2024 AImpact. All rights reserved.</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";

        $userMail->Body = $userEmailContent;
        $userMail->AltBody = "Thank you " . $contact_name . "!\n\nWe've received your request and we're excited to help transform your business with AI solutions.\n\nOur team will review your requirements and contact you within 24 hours.\n\nBest regards,\nAImpact Team";

        $userMail->send();
        
        // Redirect to thank you page
        header('Location: thank_you');
        exit();

    } catch(Exception $e) {
        error_log("Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error occurred']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

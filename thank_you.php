<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - AImpact</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="assets/icon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="js/animations.js"></script>
    <style>
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px !important;
            margin-top: 30px;
            align-items: center;
            width: 100%;
            max-width: 400px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            width: 100%;
            border-radius: 15px;
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            justify-content: center;
        }

        .social-btn i {
            font-size: 1.8rem;
        }

        .social-btn.whatsapp i {
            color: #25D366;
        }

        .social-btn.telegram i {
            color: #0088cc;
        }

        .social-btn.messenger i {
            color: #A855F7;
        }

        .social-btn.whatsapp:hover {
            border-color: #25D366;
            box-shadow: 0 0 30px rgba(37, 211, 102, 0.3);
            transform: translateY(-2px);
            background: rgba(37, 211, 102, 0.1);
        }

        .social-btn.telegram:hover {
            border-color: #0088cc;
            box-shadow: 0 0 30px rgba(0, 136, 204, 0.3);
            transform: translateY(-2px);
            background: rgba(0, 136, 204, 0.1);
        }

        .social-btn.messenger:hover {
            border-color: #A855F7;
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.3);
            transform: translateY(-2px);
            background: rgba(168, 85, 247, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <img src="assets/bg-effect.svg" alt="" class="bg-effect">
        <div class="header-content" style="height: auto;">
            <p class="promo fade-hidden fade-from-bottom delay-short">
                <img src="assets/stars.svg" alt=""> Thank you!
            </p>
            <h1 class="fade-hidden fade-from-bottom" style="font-size: 3rem;">Information Received</h1>
            <p class="fade-hidden fade-from-bottom delay-medium" style="width: 100%; max-width: 400px; margin-bottom: 0;">
                Choose how you'd like to continue:
            </p>
            <div class="social-buttons fade-hidden fade-from-bottom delay-long">
                <a href="https://wa.me/YOUR_PHONE_NUMBER" class="social-btn whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </a>
                <a href="https://t.me/YOUR_TELEGRAM" class="social-btn telegram">
                    <i class="fab fa-telegram"></i>
                    Telegram
                </a>
                <a href="http://m.me/YOUR_FACEBOOK_PAGE" class="social-btn messenger">
                    <i class="fab fa-facebook-messenger"></i>
                    Messenger
                </a>
            </div>
        </div>
    </header>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.fade-hidden').forEach(element => {
                element.classList.add('fade-show');
            });
        });
    </script>
</body>
</html>
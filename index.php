<?php
require_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AImpact</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="assets/icon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="js/animations.js"></script>
</head>
<body>
    <nav class="nav">
        <img src="assets/logo.svg" alt="">
        <ul>
            <li><a href="#home" class="white-btn">Home</a></li>
            <li><a href="#whatweoffer" class="white-btn">What we offer</a></li>
            <li><a href="#howitworks" class="white-btn">How it works</a></li>
            <li><a href="#contact" class="white-btn">Contact</a></li>
            <li><a href="#pricing" class="white-btn">Pricing</a></li>
            <li><a href="blogs" class="white-btn">Blog</a></li>
            <li><a href="#faq" class="white-btn">FAQ</a></li>
        </ul>
        <a href="contact" class="orange-btn">Get started</a>
    </nav>
    <div class="snap-scroll"> 
        <header id="home">
            <img src="assets/bg-effect.svg" alt="" class="bg-effect">
            <div class="header-content">
                <p class="promo fade-hidden fade-from-bottom delay-short"><img src="assets/stars.svg" alt="">Trusted by 200 businesses worldwide</p>
                <h1 class="fade-hidden fade-from-bottom">Efficiency at the edge</h1>
                <p class="fade-hidden fade-from-bottom delay-short">Enhance your business workflow with the help of top tier AI Software on the market. Automate more than half of your tasks</p>
                <div>
                    <a href="contact" class="orange-btn fade-hidden fade-from-left delay-medium" style="border-radius: 40px;">Get Started</a>
                    <a href="#explore" class="white-btn fade-hidden fade-from-right delay-medium">Explore</a>
                </div>
            </div>
            <div class="header-image">
                <?php echo file_get_contents('assets/hero-bg.svg'); ?>
            </div>
        </header>
        <section id="explore" class="white-section ">
            <?php echo file_get_contents('assets/white-bg.svg'); ?>
            <div class="white-section-con">
                <h2 class="fade-hidden fade-from-bottom">Use AI efficiently and more <br> productively to help your business!</h2>
                <div class="white-section-content">
                    <div class="white-section-content-image">
                        <img src="assets/bg.jpg" alt="Background" style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                    </div>
                    <div class="white-section-content-main fade-hidden fade-from-right delay-short">
                        <div class="white-section-content-text">
                            <h3>Transform Your Business<br>with AI-Powered<br>Solutions</h3>
                            <p>Experience seamless automation and enhanced<br>efficiency with our cutting-edge AI tools</p>
                        </div>
                        <div class="white-section-content-icon">
                            <img src="assets/apps.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="white-section">
            <div class="pain-point-con">
                <?php echo file_get_contents('assets/red.svg'); ?>
                <h2 class="fade-hidden fade-from-bottom">Are You Facing These  <br> Business Challenges? </h2>
                <div class="parent">
                    <div class="div1 pain-point fade-hidden fade-from-bottom delay-short">
                        <h3>Slow & Unresponsive<br>Customer Support</h3>
                        <p>Customers are reaching out at all hours, and we just can't keep up.</p>
                    </div>
                    <div class="div2 pain-point fade-hidden fade-from-bottom delay-short">
                        <h3>Messy Finances &<br>Cash Flow Worries</h3>
                        <p>We're making sales, but at the end of the month, I'm still struggling to keep track of cash flow.</p>
                    </div>
                    <div class="div4 pain-point fade-hidden fade-from-bottom delay-short">
                        <h3>Overwhelming<br>Workload & Burnout</h3>
                        <p>I feel like I never have time to focus on growing my business because I'm always stuck handling the day-to-day chaos.</p>
                    </div>
                    <div class="div3 pain-point fade-hidden fade-from-bottom delay-short">
                        <h3>Too Many Tools,<br>Not Enough Integration</h3>
                        <p>I waste so much time switching between tools and manually updating data—it's exhausting.</p>
                    </div>
                    <div class="div5 pain-point fade-hidden fade-from-bottom delay-short">
                        <h3>Inconsistent Sales &<br>Struggling Lead Generation</h3>
                        <p>Some months, sales are great—other times, it's dead. I don't have a reliable system to bring in leads consistently, and I'm tired of guessing what works.<br><br>I've tried different strategies, but follow-ups take too much time, and I know we're losing potential customers because of it.<br><br>If I can't fix this, growth will always feel like a gamble.</p>
                    </div>
                    <div class="div6 pain-point fade-hidden fade-from-bottom delay-short">
                        <h3>Marketing That Feels<br>Like a Money Pit</h3>
                        <p>We're spending money on ads and content, but I have no idea what's actually working. I've tried boosting posts, hiring freelancers, and running campaigns, but tracking results is confusing.<br><br>Creating content is exhausting, and I can't afford a full-time team.<br><br>Other businesses seem to get leads effortlessly why does it feel so hard for us?</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="whatweoffer" class="white-section" style="height: calc(400vh + 350px);">
            <div class="offer-section-con pain-point-con">
                <?php echo file_get_contents('assets/offer-bg.svg'); ?>
                <div class="header-offer">
                    <h2 class="fade-hidden fade-from-bottom">What we offer </h2>
                    <p class="fade-hidden fade-from-bottom delay-short">Meet the ultimate tools and best had-picked <br> solutions to suit your business</p>

                </div>
                <div class="offer-con" id="offer-1">
                    <div class="offer-con-text">
                        <h3 class="fade-hidden fade-from-bottom">AI Chatbots & Virtual Assistants</h3>
                        <p class="fade-hidden fade-from-bottom delay-short">Never Lose a Customer to Slow Support Again!<br><br>
                        AI chatbots and virtual assistants work 24/7 to handle inquiries, schedule appointments, and provide instant responses—so your business never sleeps.<br><br>
                        • Automate up to 90% of customer interactions<br>
                        • Provide instant support, anytime, anywhere<br>
                        • Reduce customer service costs by up to 60%<br>
                        • Improve customer satisfaction with personalized AI responses</p>
                        <div class="offer-icon-con fade-hidden fade-from-bottom delay-long"> 
                            <div class="offer-icon">
                                <img src="assets/emoji-1(1).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-1(2).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-1(3).png" alt="">
                            </div> 
                            <a href="#offer-2" class="white-btn offer-btn">Next</a>
                        </div>    
                    </div>
                    <div class="offer-con-image fade-hidden fade-from-right delay-medium">
                        <canvas class="video-poster" data-video-src="assets/video-1-edited.mp4"></canvas>
                        <div class="video-wrapper" data-video-src="assets/video-1-edited.mp4">
                            <!-- Video will be inserted here via JavaScript -->
                        </div>
                        <div class="video-overlay" data-video="video-1">
                            <div class="video-control">
                                <i class="fas fa-play play-icon"></i>
                                <i class="fas fa-pause pause-icon"></i>
                                <i class="fas fa-redo replay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offer-con" style="flex-direction: row-reverse;"  id="offer-2">
                    <div class="offer-con-text" >
                        <h3 class="fade-hidden fade-from-bottom">AI-Powered Sales & Lead Generation</h3>
                        <p class="fade-hidden fade-from-bottom delay-short">Turn More Leads into Customers—Automatically!<br><br>
                        Stop wasting time on dead leads. AI finds, qualifies, and engages prospects for you—so your sales team focuses only on closing deals.<br><br>
                        • AI scores and qualifies leads in real-time<br>
                        • Automate personalized outreach and follow-ups<br>
                        • Boost conversion rates with AI-driven sales strategies<br>
                        • Close more deals with less effort</p>
                        <div class="offer-icon-con fade-hidden fade-from-bottom delay-long"> 
                            <div class="offer-icon">
                                <img src="assets/emoji-2(1).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-2(2).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-2(3).png" alt="">
                            </div> 
                            <a href="#offer-3" class="white-btn offer-btn">Next</a>
                        </div>  
                    </div>
                    <div class="offer-con-image fade-hidden fade-from-left delay-medium">
                        <canvas class="video-poster" data-video-src="assets/video-2-edited.mp4"></canvas>
                        <div class="video-wrapper" data-video-src="assets/video-2-edited.mp4">
                            <!-- Video will be inserted here via JavaScript -->
                        </div>
                        <div class="video-overlay" data-video="video-2">
                            <div class="video-control">
                                <i class="fas fa-play play-icon"></i>
                                <i class="fas fa-pause pause-icon"></i>
                                <i class="fas fa-redo replay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offer-con"  id="offer-3">
                    <div class="offer-con-text ">
                    <h3 class="fade-hidden fade-from-bottom">AI for Marketing & Content Creation</h3>
                    <p class="fade-hidden fade-from-bottom delay-short">Create High-Performing Content in Seconds!<br><br>
                    Say goodbye to writer's block. AI-powered marketing tools generate engaging content, social media posts, and ad copies—all tailored to your audience.<br><br>
                    • Generate blog posts, social media content & emails instantly<br>
                    • Personalized ads that increase engagement<br>
                    • Boost SEO & conversions with AI-driven insights<br>
                    • Save hours of manual work every week</p>
                    <div class="offer-icon-con fade-hidden fade-from-bottom delay-long"> 
                            <div class="offer-icon">
                                <img src="assets/emoji-3(1).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-3(2).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-3(3).png" alt="">
                            </div> 
                            <a href="#offer-4" class="white-btn offer-btn">Next</a>
                        </div>  
                    </div>
                    <div class="offer-con-image fade-hidden fade-from-right delay-medium">
                        <canvas class="video-poster" data-video-src="assets/video-3-edited.mp4"></canvas>
                        <div class="video-wrapper" data-video-src="assets/video-3-edited.mp4">
                            <!-- Video will be inserted here via JavaScript -->
                        </div>
                        <div class="video-overlay" data-video="video-3">
                            <div class="video-control">
                                <i class="fas fa-play play-icon"></i>
                                <i class="fas fa-pause pause-icon"></i>
                                <i class="fas fa-redo replay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offer-con" style="flex-direction: row-reverse;"  id="offer-4">
                    <div class="offer-con-text">
                    <h3 class="fade-hidden fade-from-bottom">AI Analytics & Business Insights</h3>
                    <p class="fade-hidden fade-from-bottom delay-short">Turn Data into Profits—Effortlessly!<br><br>
                    Make smarter business decisions with AI-powered analytics that detect trends, predict sales, and uncover hidden opportunities.<br><br>
                    • Get real-time insights with AI-driven reports<br>
                    • Identify growth opportunities before competitors do<br>
                    • Automate performance tracking and forecasting<br>
                    • Reduce risks and maximize profits</p>
                    <div class="offer-icon-con fade-hidden fade-from-bottom delay-long"> 
                            <div class="offer-icon">
                                <img src="assets/emoji-4(1).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-4(2).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-4(3).png" alt="">
                            </div> 
                            <a href="#offer-5" class="white-btn offer-btn">Next</a>
                        </div>   
                    </div>
                    <div class="offer-con-image fade-hidden fade-from-left delay-medium">
                        <canvas class="video-poster" data-video-src="assets/video-4-edited.mp4"></canvas>
                        <div class="video-wrapper" data-video-src="assets/video-4-edited.mp4">
                            <!-- Video will be inserted here via JavaScript -->
                        </div>
                        <div class="video-overlay" data-video="video-4">
                            <div class="video-control">
                                <i class="fas fa-play play-icon"></i>
                                <i class="fas fa-pause pause-icon"></i>
                                <i class="fas fa-redo replay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offer-con"  id="offer-5">
                    <div class="offer-con-text">
                    <h3 class="fade-hidden fade-from-bottom">AI-Powered Email & Phone Automation</h3>
                    <p class="fade-hidden fade-from-bottom delay-short">Never Miss a Lead or Follow-Up Again!<br><br>
                    AI handles emails, follow-ups, and even customer calls—so your team can focus on closing deals, not chasing them.<br><br>
                    • Automate personalized email responses<br>
                    • AI-powered phone assistants handle inquiries & sales calls<br>
                    • Increase email open rates & engagement<br>
                    • Free up your team's time for high-value tasks</p>
                    <div class="offer-icon-con fade-hidden fade-from-bottom delay-long"> 
                            <div class="offer-icon">
                                <img src="assets/emoji-5(1).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-5(2).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-5(3).png" alt="">
                            </div> 
                            <a href="#offer-6" class="white-btn offer-btn">Next</a>
                        </div>    
                    </div>
                    <div class="offer-con-image fade-hidden fade-from-right delay-medium">
                        <canvas class="video-poster" data-video-src="assets/video-5-edited.mp4"></canvas>
                        <div class="video-wrapper" data-video-src="assets/video-5-edited.mp4">
                            <!-- Video will be inserted here via JavaScript -->
                        </div>
                        <div class="video-overlay" data-video="video-5">
                            <div class="video-control">
                                <i class="fas fa-play play-icon"></i>
                                <i class="fas fa-pause pause-icon"></i>
                                <i class="fas fa-redo replay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offer-con" style="flex-direction: row-reverse;"  id="offer-6">
                    <div class="offer-con-text">
                    <h3 class="fade-hidden fade-from-bottom">AI for Finance & Accounting</h3>
                    <p class="fade-hidden fade-from-bottom delay-short">Automate Your Finances & Maximize Profits!<br><br>
                    No more manual bookkeeping or financial stress. AI-powered accounting tools automate invoices, expenses, and reports—eliminating errors and saving time.<br><br>
                    • Automate invoicing & expense tracking<br>
                    • Detect fraud & prevent financial leaks<br>
                    • Get real-time financial insights & reports<br>
                    • Stay compliant & stress-free</p>
                    <div class="offer-icon-con fade-hidden fade-from-bottom delay-long"> 
                            <div class="offer-icon">
                                <img src="assets/emoji-6(1).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-6(2).png" alt="">
                            </div> 
                            <div class="offer-icon">
                                <img src="assets/emoji-6(3).png" alt="">
                            </div> 
                            <a href="#contact" class="white-btn offer-btn">Get started</a>
                        </div>  
                    </div>
                    <div class="offer-con-image fade-hidden fade-from-left delay-medium">
                        <canvas class="video-poster" data-video-src="assets/video-6-edited.mp4"></canvas>
                        <div class="video-wrapper" data-video-src="assets/video-6-edited.mp4">
                            <!-- Video will be inserted here via JavaScript -->
                        </div>
                        <div class="video-overlay" data-video="video-6">
                            <div class="video-control">
                                <i class="fas fa-play play-icon"></i>
                                <i class="fas fa-pause pause-icon"></i>
                                <i class="fas fa-redo replay-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <section id="howitworks" class="white-section">
            <?php echo file_get_contents('assets/white-bg.svg'); ?>
            <div class="white-section-con">
                <h2 class="fade-hidden fade-from-bottom">How it works</h2>
                <div class="white-section-content">
                    <div class="white-section-content-image how-it-works fade-hidden fade-from-left delay-medium">
                        <div class="how-it-works-image">
                            <img src="assets/step (1).jpg" alt="Research Phase">
                        </div>
                        <div class="how-it-works-text">
                            <h3>Step 1 - Research</h3>
                            <p>Get to know you and your busness better. <br> Undesrtanding every spact that can be improved</p>
                        </div>
                    </div>
                    <div class="white-section-content-image how-it-works fade-hidden fade-from-bottom delay-medium">
                        <div class="how-it-works-image">
                            <img src="assets/step (2).jpg" alt="Planning Phase">
                        </div>
                        <div class="how-it-works-text">
                            <h3>Step 2 - Planning</h3>
                            <p>Building a plan for future implementations, <br> and presenting the ideas. </p>
                        </div>
                    </div>
                    <div class="white-section-content-image how-it-works fade-hidden fade-from-right delay-medium">
                        <div class="how-it-works-image">
                            <img src="assets/step (3).jpg" alt="Execution Phase">
                        </div>
                        <div class="how-it-works-text">
                            <h3>Step 3 - Execution</h3>
                            <p>Implementing AI to see results <br> and present the final product</p>
                        </div>
                    </div>
                </div>
                <a href="contact" class="orange-btn how-it-works-btn fade-hidden fade-from-bottom delay-long">Get Started</a>
            </div>
        </section>
        <section class="white-section testimonials-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">What Our Clients Say</h2>
                </div>
                <div class="testimonials-wrapper">
                    <div class="testimonials-container">
                        <?php
                        // Fetch approved and featured testimonials
                        $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE status = 'approved' ORDER BY featured DESC, created_at DESC");
                        $stmt->execute();
                        $testimonials = $stmt->fetchAll();

                        foreach ($testimonials as $testimonial):
                        ?>
                        <div class="testimonial-card fade-hidden fade-from-bottom delay-short">
                            <div class="testimonial-rating">
                                <?php echo str_repeat('<img src="assets/star.svg" alt="star">', $testimonial['rating']); ?>
                            </div>
                            <p class="testimonial-content"><?php echo htmlspecialchars($testimonial['content']); ?></p>
                            <div class="testimonial-author">
                                <?php if ($testimonial['image_url']): ?>
                                    <img src="<?php echo htmlspecialchars($testimonial['image_url']); ?>" alt="<?php echo htmlspecialchars($testimonial['client_name']); ?>" class="testimonial-avatar">
                                <?php endif; ?>
                                <div class="testimonial-info">
                                    <h4><?php echo htmlspecialchars($testimonial['client_name']); ?></h4>
                                    <?php if ($testimonial['company_name']): ?>
                                        <p><?php echo htmlspecialchars($testimonial['position'] . ', ' . $testimonial['company_name']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="testimonial-nav fade-hidden fade-from-bottom delay-medium">
                        <button class="white-btn testimonial-prev">←</button>
                        <button class="white-btn testimonial-next">→</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="white-section">
            <div class="chart-con">
                <?php echo file_get_contents('assets/chart.svg'); ?>
                <div class="chart-content fade-hidden fade-from-right">
                    <h2>Effect in real time: <br> Task Automation Efficiency</h2>
                    <p>Our AI solutions deliver measurable results:<br><br>
                    • Up to 70% reduction in manual tasks<br>
                    • 85% faster workflow completion<br>
                    • 3x increase in team productivity<br>
                    • 60% lower operational costs</p>
                </div>
            </div>
        </section>
        <section id="contact" class="white-section">
            <div class="pain-point-con">
                <?php echo file_get_contents('assets/contact-bg.svg'); ?>
                <p class="promo fade-hidden fade-from-bottom delay-short"><img src="assets/stars.svg" alt="">Tailored Services</p>
                <h2 class="contact-header fade-hidden fade-from-bottom delay-short">AI is the Future of Business<br>Are You Ready?</h2>
                <p class="contact-text fade-hidden fade-from-bottom delay-medium">
                Automate repetitive tasks</p>
                <a href="contact" class="orange-btn how-it-works-btn contact-btn">Get Started</a>
                
            </div>
        </section>
        <section id="pricing" class="white-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">Invest In Your Future</h2>
                </div>
                <div class="white-section-content ">
                    <div class="white-section-content-image how-it-works pricing-con fade-hidden fade-from-left delay-short">
                            <h3>Basic</h3>
                            <p>$1,000</p>
                    </div>
                    <div class="white-section-content-image how-it-works pricing-con-premium">
                        <img src="assets/glow.svg" alt="" class="glow-img-top">
                        <img src="assets/glow.svg" alt="" class="glow-img-bottom">
                            <h3>Premium</h3>
                            <p>$1,500</p>

                    </div>
                    <div class="white-section-content-image how-it-works pricing-con fade-hidden fade-from-right delay-short">
                            <h3>Ultimate</h3>
                            <p>$3,000</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="faq" class="white-section" style="height: 180vh;">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">FAQ</h2>
                </div>
                <div class="question-con">
                    <div class="question">
                        <h3>What is AI business automation, and how can it help my company?</h3>
                        <p class="answer">AI business automation refers to the use of artificial intelligence to streamline and optimize repetitive tasks, improve efficiency, and reduce human error. It can help your company by automating customer support, marketing, data analysis, and operational workflows, allowing your team to focus on higher-value tasks.</p>
                    </div>

                    <div class="question">
                        <h3>How much does AI integration cost for a business?</h3>
                        <p class="answer">The cost of AI integration varies depending on the complexity of your business needs and the tools required. Some AI solutions are affordable, starting at a few hundred dollars, while more advanced custom implementations can range into thousands. We offer tailored solutions to fit different budgets.</p>
                    </div>

                    <div class="question">
                        <h3>Can AI improve customer service in my business?</h3>
                        <p class="answer">Yes, AI-powered chatbots and virtual assistants can handle customer inquiries 24/7, provide instant responses, and assist with common issues. This reduces response time, improves customer satisfaction, and allows human agents to focus on more complex cases.</p>
                    </div>

                    <div class="question">
                        <h3>What industries can benefit from AI automation?</h3>
                        <p class="answer">AI can enhance businesses in various industries, including e-commerce, healthcare, finance, real estate, marketing, and customer service. Any industry that relies on data, communication, or repetitive tasks can significantly benefit from AI automation.</p>
                    </div>

                    <div class="question">
                        <h3>Do I need technical knowledge to implement AI in my business?</h3>
                        <p class="answer">No, you do not need technical expertise. Our team provides seamless AI integration, handling everything from setup to deployment. We ensure the tools work effortlessly within your existing business operations.</p>
                    </div>

                    <div class="question">
                        <h3>How long does it take to implement AI solutions?</h3>
                        <p class="answer">Implementation time depends on the complexity of the AI solution. Basic automation tools can be integrated within days, while more advanced AI systems may take a few weeks. We ensure a smooth and efficient setup to minimize disruption.</p>
                    </div>

                    <div class="question">
                        <h3>Can AI help increase sales and lead generation?</h3>
                        <p class="answer">Yes, AI can analyze customer data, personalize marketing campaigns, and automate lead nurturing, increasing conversion rates. AI-driven chatbots and email marketing automation also help businesses engage with leads more effectively.</p>
                    </div>

                    <div class="question">
                        <h3>What AI tools do you use for business automation?</h3>
                        <p class="answer">We utilize industry-leading AI tools such as chatbots, automated email marketing, AI-driven analytics, virtual assistants, and workflow automation platforms. The selection depends on your business needs and goals.</p>
                    </div>

                    <div class="question">
                        <h3>Is AI safe for business operations?</h3>
                        <p class="answer">Yes, AI is designed to improve efficiency while maintaining security and compliance. We ensure that all AI tools we implement follow strict data protection and privacy regulations to keep your business safe.</p>
                    </div>

                    <div class="question">
                        <h3>Can AI help with marketing and content creation?</h3>
                        <p class="answer">Yes, AI can generate high-quality marketing content, optimize ad targeting, automate social media posts, and analyze audience engagement. This allows businesses to enhance their marketing efforts with minimal effort.</p>
                    </div>

                    <div class="question">
                        <h3>Will AI replace human employees in my business?</h3>
                        <p class="answer">AI is designed to assist and enhance human productivity, not replace employees. By automating repetitive tasks, AI allows employees to focus on strategic and creative work that adds greater value to the business.</p>
                    </div>

                    <div class="question">
                        <h3>What is the return on investment (ROI) of AI implementation?</h3>
                        <p class="answer">The ROI of AI implementation depends on the use case, but businesses typically see improved efficiency, increased revenue, and cost savings within months. AI reduces manual workload, enhances customer engagement, and improves decision-making.</p>
                    </div>

                    <div class="question">
                        <h3>Can small businesses afford AI automation?</h3>
                        <p class="answer">Yes, AI solutions are available for businesses of all sizes. Many affordable AI tools can automate key processes without requiring a large investment. We offer scalable AI solutions tailored to small and medium-sized businesses.</p>
                    </div>

                    <div class="question">
                        <h3>How do I get started with AI for my business?</h3>
                        <p class="answer">Getting started is simple! Fill out our quick AI assessment form, and we’ll analyze your business needs to recommend the best AI solutions. From consultation to implementation, we handle everything for you.</p>
                    </div>

                    <div class="question">
                        <h3>Do you provide support after AI implementation?</h3>
                        <p class="answer">Yes, we offer ongoing support and training to ensure AI tools function optimally. Our team is available to assist with any questions, updates, or adjustments needed for continuous improvement.</p>
                    </div>
                </div>
            </div>
            <script>
                // Add FAQ functionality
                document.querySelectorAll('.question h3').forEach(question => {
                    question.addEventListener('click', () => {
                        const answer = question.parentElement.querySelector('.answer');
                        
                        // Close all other answers
                        document.querySelectorAll('.answer').forEach(otherAnswer => {
                            if (otherAnswer !== answer) {
                                otherAnswer.classList.remove('active');
                            }
                        });

                        // Toggle current answer
                        answer.classList.toggle('active');
                    });
                });
            </script>
            <img src="assets/bg-effect.svg" alt="" class="bg-effect bottom-bg">
        </section>
        <footer class="white-section">
            <div class="footer-content">
                <img src="assets/logo.svg" alt="AImpact Logo" class="footer-logo">
                <div class="footer-links">
                    <a href="#about">About</a>
                    <a href="#services">Services</a>
                    <a href="#contact">Contact</a>
                    <a href="#privacy">Privacy Policy</a>
                    <a href="#terms">Terms of Service</a>
                </div>
                <p class="footer-text">&copy; 2024 AImpact. All rights reserved.</p>
            </div>
        </footer>
    </div>
    <script>
        const snapScroll = document.querySelector('.snap-scroll');
        snapScroll.addEventListener('scroll', function() {
            const nav = document.querySelector('.nav');
            if (this.scrollTop > 500) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Testimonials slider
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.testimonials-container');
            const prevBtn = document.querySelector('.testimonial-prev');
            const nextBtn = document.querySelector('.testimonial-next');
            let scrollAmount = 0;
            const cardWidth = container.querySelector('.testimonial-card').offsetWidth;

            prevBtn.addEventListener('click', () => {
                scrollAmount = Math.max(scrollAmount - cardWidth, 0);
                container.scroll({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            nextBtn.addEventListener('click', () => {
                scrollAmount = Math.min(scrollAmount + cardWidth, container.scrollWidth - container.clientWidth);
                container.scroll({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            // Create temporary video elements to generate thumbnails
            document.querySelectorAll('.video-poster').forEach(canvas => {
                const tempVideo = document.createElement('video');
                tempVideo.src = canvas.dataset.videoSrc;
                tempVideo.addEventListener('loadeddata', function() {
                    // Set canvas dimensions to match video aspect ratio
                    canvas.width = tempVideo.videoWidth;
                    canvas.height = tempVideo.videoHeight;
                    
                    // Draw the first frame
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(tempVideo, 0, 0, canvas.width, canvas.height);
                    
                    // Clean up
                    tempVideo.remove();
                });
                // Load just enough to get the first frame
                tempVideo.preload = 'metadata';
                tempVideo.currentTime = 0.1;
            });

            // Video controls functionality
            document.querySelectorAll('.video-overlay').forEach(overlay => {
                const wrapper = overlay.previousElementSibling;
                const poster = wrapper.previousElementSibling;
                const control = overlay.querySelector('.video-control');
                let video = null;

                overlay.addEventListener('click', () => {
                    if (!video) {
                        // First click - initialize video
                        video = document.createElement('video');
                        video.id = overlay.dataset.video;
                        video.playsinline = true;
                        video.setAttribute('disablePictureInPicture', '');
                        video.setAttribute('controlsList', 'nodownload');
                        
                        const source = document.createElement('source');
                        source.src = wrapper.dataset.videoSrc;
                        source.type = 'video/mp4';
                        
                        video.appendChild(source);
                        wrapper.appendChild(video);
                        poster.style.display = 'none';
                        
                        video.load();
                        video.play();
                        control.setAttribute('data-state', 'playing');

                        // Add event listeners
                        video.addEventListener('play', () => {
                            control.setAttribute('data-state', 'playing');
                        });

                        video.addEventListener('ended', () => {
                            control.setAttribute('data-state', 'ended');
                        });

                        video.addEventListener('pause', () => {
                            if (!video.ended) {
                                control.removeAttribute('data-state');
                            }
                        });
                    } else {
                        // Video exists - handle play/pause
                        if (video.ended) {
                            video.currentTime = 0;
                            video.play();
                            control.setAttribute('data-state', 'playing');
                        } else if (video.paused) {
                            video.play();
                            control.setAttribute('data-state', 'playing');
                        } else {
                            video.pause();
                            control.removeAttribute('data-state');
                        }
                    }
                });
            });
        });
        
    </script>
</body>
</html>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2025 at 04:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aimpact`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(4, 'admin', '$2y$10$VIDbc9Mh9KgYS2AWRJRWbO7dmiE3y5aqv0G9Ac3x41Xicl8h81bZi', '2025-02-01 23:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `content`, `image_url`, `excerpt`, `author`, `status`, `views`, `created_at`, `updated_at`) VALUES
(3, 'Blog Number 1 - Start', 'blog-number-1---start', '<h2> Headline 1 </h2>\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque euismod dignissim egestas. Nulla egestas diam eget urna laoreet vestibulum. Vestibulum nunc purus, semper et ornare ac, feugiat eu felis. Etiam nibh neque, vestibulum eget elit a, maximus elementum metus. Donec efficitur vulputate leo, sit amet pretium leo laoreet a. Sed maximus semper risus. Pellentesque non ex dolor. Suspendisse interdum nunc est, at posuere velit viverra non. Curabitur mattis dolor quis mi tempor, eu rhoncus odio vestibulum. Nam varius metus lorem, et pretium magna convallis in. Nullam consequat ut velit vel auctor.\r\n\r\n<h2> Headline 2 </h2>\r\n\r\n<h3> Subsection 1 </h3>\r\n\r\nPraesent ac hendrerit dolor, id tristique ipsum. Aliquam erat volutpat. Etiam pulvinar quam quis neque cursus, id molestie dui porttitor. Sed cursus, orci vitae bibendum consequat, enim dolor pellentesque risus, eu congue urna risus eu eros. Suspendisse at orci interdum nisl tincidunt tincidunt sit amet in augue. \r\n\r\n<h3> Subsection 1 </h3>\r\n\r\nIn eu felis in dui mattis gravida quis vel ante. Pellentesque fermentum elit in nisl pellentesque mollis. Nunc arcu nisl, luctus eu porta sed, pretium ut lacus. Sed nec feugiat nulla. Fusce commodo luctus congue.\r\n\r\n<h2> Headline 3 </h2>\r\n\r\nCras at leo quis ex consequat facilisis in eu sem. Mauris faucibus urna sapien, ac porta sapien efficitur at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eu ultricies quam. Nunc vel sodales est, nec commodo eros. In ultricies, lacus quis interdum fermentum, neque nunc laoreet eros, iaculis tincidunt purus erat quis ante. Nulla facilisi. Aenean consectetur, nibh ut tincidunt iaculis, ante enim scelerisque nisi, ut commodo nisi magna vel felis.\r\n\r\n<CTA>\r\n\r\n<h2> Headline 4 </h2>\r\n\r\nSed vel ex eu enim consequat ultrices a ut orci. Nam at vulputate arcu. Maecenas convallis semper mi a fringilla. In consectetur dolor tristique sem vestibulum, id lacinia sapien fermentum. Pellentesque tincidunt elit at sapien tempus, quis molestie ex placerat. Etiam imperdiet tempus nibh vel ornare. Quisque et luctus nibh. Phasellus fringilla facilisis quam quis semper. Donec rhoncus libero tristique auctor lobortis. Praesent odio massa, lobortis eget aliquam dignissim, gravida vel elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', 'uploads/blogs/67a3e1e8d84a9-Group 25.png', NULL, 'Imran', 'published', 106, '2025-02-05 22:10:48', '2025-03-09 14:38:29'),
(4, 'qwoidqwoidjqwoidjqwoidjowidjqw', 'qwoidqwoidjqwoidjqwoidjowidjqw', 'qwodijqwoidjqwoidqwdijqwoid', 'uploads/blogs/67a4071c1952b-Group 43.png', NULL, 'Huseyn', 'published', 10, '2025-02-06 00:49:32', '2025-03-09 11:47:16'),
(5, 'How AI Automation is Revolutionizing Business Operations', 'how-ai-automation-is-revolutionizing-business-operations', '<h2> Why AI Automation is Essential for Modern Businesses </h2>\r\nAI automation is no longer just a competitive advantage—it is a necessity for businesses aiming to improve efficiency, reduce costs, and enhance productivity. Companies across industries are leveraging AI-powered tools to streamline workflows, minimize human error, and accelerate decision-making processes.\r\n\r\nBy integrating AI, businesses can automate repetitive tasks, analyze vast amounts of data in real-time, and optimize operations in ways that were previously impossible. In this blog, we will explore the key areas where AI automation is transforming businesses and how you can implement it in your operations.\r\n\r\n<h2> Key Areas Where AI is Transforming Business Workflows </h2> <h3> Automating Customer Support with AI Chatbots </h3>\r\nCustomer service is a crucial aspect of any business, and AI-powered chatbots are revolutionizing how businesses interact with their customers. These chatbots provide instant responses, handle multiple inquiries at once, and offer a seamless user experience. AI chatbots can operate 24/7, ensuring that customers receive support anytime. They reduce operational costs by minimizing the need for large customer support teams. AI chatbots can also be trained to provide personalized recommendations, enhancing customer satisfaction.\r\n\r\n<h3> AI-Powered Data Analysis for Smarter Decision-Making </h3>\r\nAI-driven data analytics enable businesses to make data-backed decisions faster and more accurately. These tools process large datasets, identify patterns, and generate insights that help businesses optimize their strategies. AI can predict market trends and customer behaviors, allowing businesses to adjust their approach accordingly. Companies can also leverage AI analytics for sales forecasting and demand planning. Automated report generation reduces manual effort and improves accuracy, ensuring that teams have real-time insights available.\r\n\r\n<h3> AI-Driven Marketing and Customer Personalization </h3>\r\nMarketing has evolved significantly with AI automation. Businesses can now create hyper-personalized campaigns that target specific customer segments based on their behavior and preferences. AI analyzes customer interactions to optimize ad placements, ensuring maximum reach and engagement. AI-generated content enhances social media and email marketing efforts, making campaigns more effective. Automated customer segmentation allows businesses to tailor marketing strategies for different audiences, leading to higher conversion rates and better customer retention.\r\n\r\n<h2> AI-Powered Task Automation and Productivity Boosters </h2> <h3> Automating Administrative and Repetitive Tasks </h3>\r\nAI-driven automation tools can handle time-consuming tasks, allowing employees to focus on high-value work. AI-powered scheduling tools automate meeting coordination, reducing the back-and-forth of manual scheduling. Smart email filtering and automated responses improve communication efficiency. AI-powered document processing extracts key data, reducing manual entry errors and increasing accuracy.\r\n\r\n<h3> AI in Finance: Fraud Detection and Financial Automation </h3>\r\nThe finance sector benefits greatly from AI automation, especially in fraud detection and transaction processing. AI detects fraudulent transactions in real time, protecting businesses and customers from financial loss. Automated bookkeeping simplifies financial management by categorizing transactions and generating reports instantly. AI-powered payroll systems ensure timely and accurate salary processing, eliminating human errors and delays.\r\n\r\n<h3> AI for HR and Talent Acquisition </h3>\r\nRecruitment and HR management have been transformed by AI, making the hiring process more efficient and data-driven. AI scans resumes and shortlists top candidates based on job descriptions, saving HR teams hours of manual work. AI-driven chatbots conduct initial screening interviews, assessing candidates before they reach the hiring manager. AI-powered performance tracking tools provide insights into employee productivity, helping companies manage and retain top talent.\r\n\r\n<h2> The Future of AI in Business: What to Expect </h2>\r\nAs AI technology continues to advance, businesses that adopt AI automation will stay ahead of the competition. Future trends include AI-powered voice assistants, fully automated supply chains, and AI-driven business intelligence systems. Companies that embrace AI today will benefit from increased efficiency, reduced costs, and improved customer satisfaction.\r\n\r\n<CTA> \r\n\r\n<h2> How to Get Started with AI Automation </h2>\r\nIntegrating AI into your business doesn’t have to be complex. Start by identifying areas where automation can provide the most value. Implement AI-powered tools for customer service, data analysis, marketing, and finance. By taking a strategic approach, businesses can maximize the benefits of AI while staying competitive in a rapidly evolving market.', 'uploads/blogs/67a41c03e35c4-MacBook Air - 5.png', NULL, 'Imran', 'published', 28, '2025-02-06 02:18:43', '2025-03-14 16:15:09'),
(6, 'How AI-Powered Predictive Analytics is Transforming Business Strategy', 'how-ai-powered-predictive-analytics-is-transforming-business-strategy', '<h2> Understanding AI-Powered Predictive Analytics </h2>\r\nPredictive analytics, powered by artificial intelligence, is changing how businesses forecast trends, make decisions, and optimize operations. By analyzing historical data, AI algorithms can predict future outcomes with high accuracy, helping businesses stay ahead of market changes. Unlike traditional data analysis, AI-driven predictive analytics continuously improves its accuracy over time, making it an essential tool for long-term business growth.\r\n\r\nIndustries such as finance, healthcare, marketing, and supply chain management are leveraging predictive analytics to reduce risks and improve efficiency. But how does this technology work, and how can businesses implement it effectively?\r\n\r\n<h2> How AI Predicts Future Trends with Data </h2> <h3> Machine Learning Algorithms for Pattern Recognition </h3>\r\nAI predictive analytics relies on machine learning algorithms to detect patterns in large datasets. These algorithms process vast amounts of structured and unstructured data, learning from past trends to predict future outcomes.\r\n\r\nMachine learning models use regression analysis, decision trees, and neural networks to identify correlations between variables. These insights help businesses anticipate customer behavior, market fluctuations, and operational inefficiencies.\r\n\r\n<h3> Real-Time Data Processing for Instant Insights </h3>\r\nUnlike traditional forecasting methods that rely on static data, AI-powered predictive analytics continuously updates its predictions based on real-time data. This capability is crucial for industries like finance and e-commerce, where market conditions change rapidly.\r\n\r\nBusinesses can use AI to adjust pricing strategies, optimize inventory levels, and detect potential risks before they escalate. Real-time insights enable proactive decision-making, reducing costs and increasing profitability.\r\n\r\n<h3> Sentiment Analysis for Customer Behavior Prediction </h3>\r\nAI-powered sentiment analysis analyzes customer feedback, social media conversations, and online reviews to predict consumer trends. This technology allows businesses to adjust their marketing strategies, improve customer experience, and develop products that align with market demands.\r\n\r\nBy understanding customer sentiment, companies can prevent negative publicity, enhance brand reputation, and tailor their messaging to resonate with their target audience.\r\n\r\n<h2> Key Business Applications of AI-Powered Predictive Analytics </h2> <h3> Fraud Detection in Finance and Banking </h3>\r\nFinancial institutions use AI predictive analytics to detect fraudulent activities in real time. AI models analyze transaction patterns and flag anomalies that may indicate fraud. This proactive approach reduces financial losses and enhances security measures.\r\n\r\nBy continuously learning from new fraud patterns, AI-powered systems adapt to evolving threats, ensuring stronger protection against cybercriminals.\r\n\r\n<h3> AI-Driven Sales Forecasting and Revenue Growth </h3>\r\nBusinesses use predictive analytics to forecast sales trends and customer demand accurately. AI models analyze historical sales data, market conditions, and external factors such as economic shifts to generate precise revenue predictions.\r\n\r\nAccurate sales forecasting allows businesses to allocate resources efficiently, set realistic goals, and optimize marketing campaigns for maximum ROI. AI-driven insights also help companies identify new revenue opportunities and expand into emerging markets.\r\n\r\n<h3> Inventory Management and Supply Chain Optimization </h3>\r\nPredictive analytics helps businesses optimize inventory levels and streamline supply chain operations. AI models analyze past demand patterns, supplier performance, and logistics data to prevent overstocking or stock shortages.\r\n\r\nRetailers and manufacturers use AI-driven demand forecasting to improve production schedules, reduce waste, and enhance customer satisfaction by ensuring products are available when needed.\r\n\r\n<h2> The Competitive Advantage of AI-Powered Predictive Analytics </h2> <h3> Increased Efficiency and Cost Savings </h3>\r\nAI predictive analytics reduces operational costs by automating data analysis and eliminating manual forecasting errors. Businesses can optimize processes, allocate resources more effectively, and minimize financial risks.\r\n\r\n<h3> Enhanced Decision-Making with Data-Driven Insights </h3>\r\nAI provides executives and managers with accurate, real-time insights that support strategic decision-making. This technology eliminates guesswork, allowing businesses to make informed choices that drive growth.\r\n\r\n<h3> Competitive Edge in a Data-Driven Market </h3>\r\nCompanies that implement AI-powered predictive analytics gain a significant advantage over competitors. By anticipating market trends and customer needs, businesses can innovate faster, improve customer engagement, and increase profitability.\r\n\r\n<CTA> <h2> How to Implement AI-Powered Predictive Analytics in Your Business </h2>\r\nTo leverage AI predictive analytics effectively, businesses should start by defining their key objectives and selecting the right AI tools. Data quality is crucial—clean, structured data leads to more accurate predictions. Companies should also invest in AI training for their teams to maximize the technology’s benefits.\r\n\r\nAs AI continues to evolve, predictive analytics will become even more powerful, making it a critical component of any successful business strategy. The sooner businesses adopt this technology, the stronger their position will be in an increasingly data-driven world.', 'uploads/blogs/67a41d475a9af-Screenshot 2025-01-20 190952.png', NULL, 'Imran', 'published', 27, '2025-02-06 02:24:07', '2025-05-10 11:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_relations`
--

CREATE TABLE `blog_category_relations` (
  `blog_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `tasks` text DEFAULT NULL,
  `ai_experience` varchar(255) DEFAULT NULL,
  `timeline` varchar(255) DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `submission_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `tasks`, `ai_experience`, `timeline`, `budget`, `business_name`, `contact_name`, `email`, `phone`, `submission_date`, `created_at`) VALUES
(9, 'Lead Generation & Follow-ups, Marketing & Content Creation', 'No, but interested', '3-6 months', '$2,000 - $5,000', 'Huseyn Co', 'Huseyn', 'imranjefelry@gmail.com', '5099999999', '2025-03-09 07:48:38', '2025-03-09 11:48:38'),
(10, 'Lead Generation & Follow-ups', 'Tried but not implemented fully', 'ASAP (Within 1 month)', '<$500', 'Huseyn co', 'huseyn', 'huseyn@gmail.com', '0509929993', '2025-03-09 07:49:49', '2025-03-09 11:49:49'),
(11, 'Customer Support & Response, Lead Generation & Follow-ups, Marketing & Content Creation, Data Analysis & Reporting, Appointment Scheduling', 'Tried but not implemented fully', '1-3 months', '$2,000 - $5,000', 'Business', 'Imran', 'imranjeferrrefefely@gmail.com', '+994509929993', '2025-03-09 10:29:25', '2025-03-09 14:29:25'),
(12, 'Marketing & Content Creation, Data Analysis & Reporting', 'Yes, actively', 'ASAP (Within 1 month)', '$5,000+', 'bakdbwuhdhoq', 'qiwjoqjwdoiqjwdo', 'imran@gmial.com', '12931293', '2025-03-11 14:48:13', '2025-03-11 18:48:13'),
(13, 'dassax', 'No, and unsure about AI', 'ASAP (Within 1 month)', '$500 - $2,000', 'Imran', 'Yeke got', 'bussunesIbudthisshitbrickbybrick@mail.ru', '3169', '2025-03-27 12:01:33', '2025-03-27 08:01:33'),
(14, 'Lead Generation & Follow-ups, Marketing & Content Creation', 'Tried but not implemented fully', '3-6 months', '$5,000+', 'Imran', 'Imran', 'imranjefdqwdqwy@gmail.com', '0509929993', '2025-04-17 21:56:26', '2025-04-17 17:56:26'),
(15, 'Lead Generation & Follow-ups', 'Yes, actively', '1-3 months', '$500 - $2,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '12930129381209', '2025-04-17 22:40:15', '2025-04-17 18:40:15'),
(16, 'Marketing & Content Creation', 'Tried but not implemented fully', '1-3 months', '$500 - $2,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '12930129381209', '2025-04-17 23:02:08', '2025-04-17 19:02:08'),
(17, 'Marketing & Content Creation, Appointment Scheduling', 'Tried but not implemented fully', '1-3 months', '$500 - $2,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '12930129381203', '2025-04-17 23:07:32', '2025-04-17 19:07:32'),
(18, 'Marketing & Content Creation, Data Analysis & Reporting, Appointment Scheduling', 'No, but interested', '3-6 months', '$2,000 - $5,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '1293012938120', '2025-04-17 23:13:29', '2025-04-17 19:13:29'),
(19, 'Lead Generation & Follow-ups, Marketing & Content Creation, Data Analysis & Reporting, Appointment Scheduling', 'Tried but not implemented fully', '1-3 months', '$500 - $2,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '129301293812', '2025-04-17 23:14:05', '2025-04-17 19:14:05'),
(20, 'Lead Generation & Follow-ups, Appointment Scheduling', 'No, but interested', '3-6 months', '$2,000 - $5,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '12930129384324', '2025-04-17 23:19:05', '2025-04-17 19:19:05'),
(21, 'Lead Generation & Follow-ups, Data Analysis & Reporting, Appointment Scheduling', 'No, and unsure about AI', '1-3 months', '$500 - $2,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '129301293843324', '2025-04-17 23:19:46', '2025-04-17 19:19:46'),
(22, 'Lead Generation & Follow-ups, Appointment Scheduling', 'Tried but not implemented fully', '3-6 months', '$2,000 - $5,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '1293012938433', '2025-04-17 23:22:28', '2025-04-17 19:22:28'),
(23, 'Lead Generation & Follow-ups, Data Analysis & Reporting, Appointment Scheduling', 'No, but interested', '1-3 months', '$500 - $2,000', 'askjdahjkhd', 'lajsjhjdlkasdlkaslkd', 'imran.jeferli@gmail.com', '12930129384', '2025-04-17 23:23:17', '2025-04-17 19:23:17'),
(24, 'Lead Generation & Follow-ups', 'Tried but not implemented fully', '1-3 months', '$2,000 - $5,000', 'DetoMedia', 'Tamerlan Mammadov', 'imran.jeferli@gmail.com', '01298302193890', '2025-04-17 23:25:24', '2025-04-17 19:25:24'),
(25, 'Lead Generation & Follow-ups, Data Analysis & Reporting', 'No, but interested', '3-6 months', '$5,000+', 'DetoMedia', 'Tamerlan Mammadov', 'imran.jeferli@gmail.com', '0129830219389', '2025-04-17 23:26:24', '2025-04-17 19:26:24'),
(26, 'Lead Generation & Follow-ups, Data Analysis & Reporting, Appointment Scheduling', 'Tried but not implemented fully', '1-3 months', '$2,000 - $5,000', 'DetoMedia', 'Tamerlan Mammadov', 'imran.jeferli@gmail.com', '012983021938932', '2025-04-17 23:29:56', '2025-04-17 19:29:56'),
(27, 'Lead Generation & Follow-ups, Appointment Scheduling', 'No, but interested', '3-6 months', '$5,000+', 'DetoMedia', 'Tamerlan Mammadov', 'imran.jeferli@gmail.com', '01298302193893234', '2025-04-17 23:35:42', '2025-04-17 19:35:42'),
(28, 'Lead Generation & Follow-ups, Data Analysis & Reporting, Appointment Scheduling', 'No, and unsure about AI', '1-3 months', '$2,000 - $5,000', 'DetoMedia', 'Tamerlan Mammadov', 'kazimlihuseyn13@gmail.com', '01298302193893234', '2025-04-17 23:46:17', '2025-04-17 19:46:17'),
(29, 'Marketing & Content Creation', 'Yes, actively', '1-3 months', '$5,000+', 'Mature ', 'NAZLI', 'nazuabdullayeva@gmail.com', '0552388899', '2025-04-22 17:51:01', '2025-04-22 13:51:01'),
(30, 'Appointment Scheduling', 'Tried but not implemented fully', '1-3 months', '$2,000 - $5,000', 'beauty app', 'IMRAN', 'imranwiqijdo@gmail.com', '+994509929993', '2025-09-03 18:05:58', '2025-09-03 14:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `company_name`, `position`, `content`, `rating`, `image_url`, `status`, `featured`, `created_at`, `approved_at`) VALUES
(5, 'doqwpodkqw', 'wqpdokqwpod', 'qwpodkqwp', 'qpwokdpqwokdpqowkdpoqw qw9  qwpokqwpo  kqwpo kqpoqkqw', 3, NULL, 'approved', 0, '2025-03-09 14:36:28', '2025-03-09 14:36:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_status_date` (`status`,`created_at`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_category_relations`
--
ALTER TABLE `blog_category_relations`
  ADD PRIMARY KEY (`blog_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status_featured` (`status`,`featured`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_category_relations`
--
ALTER TABLE `blog_category_relations`
  ADD CONSTRAINT `blog_category_relations_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_category_relations_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

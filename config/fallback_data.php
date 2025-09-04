<?php
// Fallback data when Firebase is not available
// This ensures your site works immediately without 500 errors

class FallbackData {
    public static function getSampleBlogs() {
        return [
            [
                'id' => 'sample-1',
                'title' => 'Getting Started with AI in Business',
                'slug' => 'getting-started-ai-business',
                'content' => 'Artificial Intelligence is transforming how businesses operate. From automating routine tasks to providing deeper insights into customer behavior, AI offers unprecedented opportunities for growth and efficiency. In this comprehensive guide, we explore the fundamental steps businesses can take to successfully integrate AI solutions into their operations.',
                'status' => 'published',
                'author' => 'Imran',
                'image_url' => 'assets/blog-placeholder.jpg',
                'created_at' => '2024-12-15 10:00:00',
                'views' => 152
            ],
            [
                'id' => 'sample-2', 
                'title' => 'The Future of Automation in Small Business',
                'slug' => 'future-automation-small-business',
                'content' => 'Small businesses are discovering the power of automation to compete with larger enterprises. From customer service chatbots to automated inventory management, the right automation tools can free up valuable time and resources. This article examines the most impactful automation strategies specifically tailored for small business success.',
                'status' => 'published',
                'author' => 'Huseyn',
                'image_url' => 'assets/blog-placeholder.jpg', 
                'created_at' => '2024-12-10 14:30:00',
                'views' => 89
            ],
            [
                'id' => 'sample-3',
                'title' => 'ROI of AI Implementation: What to Expect',
                'slug' => 'roi-ai-implementation-what-expect',
                'content' => 'Understanding the return on investment for AI projects is crucial for business decision-making. While the initial costs can be significant, the long-term benefits often exceed expectations. We break down real-world case studies and provide a framework for calculating AI ROI in your specific industry and use case.',
                'status' => 'published',
                'author' => 'Kamran', 
                'image_url' => 'assets/blog-placeholder.jpg',
                'created_at' => '2024-12-05 09:15:00',
                'views' => 234
            ]
        ];
    }
    
    public static function getSampleTestimonials() {
        return [
            [
                'id' => 'testimonial-1',
                'client_name' => 'Sarah Johnson',
                'company_name' => 'TechStart Inc',
                'position' => 'CEO',
                'content' => 'AImpact transformed our business operations completely. Their AI solutions reduced our processing time by 70% and increased customer satisfaction significantly.',
                'rating' => 5,
                'featured' => 1,
                'status' => 'approved',
                'image_url' => 'assets/testimonial-placeholder.jpg',
                'created_at' => '2024-11-20 15:00:00'
            ],
            [
                'id' => 'testimonial-2',
                'client_name' => 'Michael Chen',
                'company_name' => 'RetailPro Solutions',
                'position' => 'Operations Director',
                'content' => 'The automation tools provided by AImpact have been game-changing for our inventory management. We\'ve seen a 40% reduction in costs and virtually eliminated stock-outs.',
                'rating' => 5,
                'featured' => 1, 
                'status' => 'approved',
                'image_url' => 'assets/testimonial-placeholder.jpg',
                'created_at' => '2024-11-15 11:30:00'
            ],
            [
                'id' => 'testimonial-3',
                'client_name' => 'Emma Rodriguez',
                'company_name' => 'CustomerFirst Services',
                'position' => 'Customer Success Manager',
                'content' => 'Working with AImpact was seamless. Their team understood our needs and delivered a custom AI solution that exceeded our expectations. Highly recommended!',
                'rating' => 5,
                'featured' => 0,
                'status' => 'approved', 
                'image_url' => 'assets/testimonial-placeholder.jpg',
                'created_at' => '2024-11-10 16:45:00'
            ]
        ];
    }
}
?>
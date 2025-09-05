// Firebase Admin API Helper Functions
// This file provides Firebase-authenticated versions of all admin API calls

// Helper function to make authenticated requests
async function makeAuthenticatedRequest(url, options = {}) {
    // Get Firebase auth token
    let token = null;
    if (window.adminAuth && window.adminAuth.getStoredToken) {
        token = window.adminAuth.getStoredToken();
    }
    
    if (!token && window.adminAuth && window.adminAuth.getIdToken) {
        try {
            token = await window.adminAuth.getIdToken();
        } catch (error) {
            console.error('Failed to get Firebase token:', error);
            window.location.href = 'login.php';
            return;
        }
    }
    
    if (!token) {
        alert('Authentication required. Please login again.');
        window.location.href = 'login.php';
        return;
    }
    
    // Add token to request
    if (options.body && typeof options.body === 'string') {
        options.body += `&token=${encodeURIComponent(token)}`;
    } else if (options.body instanceof FormData) {
        options.body.append('token', token);
    }
    
    return fetch(url, options);
}

// Override existing admin functions with Firebase-authenticated versions

// Blog Management
window.editBlog = async function(id) {
    try {
        const response = await makeAuthenticatedRequest('handlers/blog_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=get&id=${id}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            const blog = data.data;
            document.getElementById('blogForm').style.display = 'block';
            document.getElementById('blog_id').value = blog.id;
            document.getElementById('title').value = blog.title;
            document.getElementById('content').value = blog.content;
            
            if (document.querySelector('select[name="status"]')) {
                document.querySelector('select[name="status"]').value = blog.status;
            }
            if (document.querySelector('select[name="author"]')) {
                document.querySelector('select[name="author"]').value = blog.author;
            }
            
            const imagePreview = document.getElementById('image-preview');
            const uploadPlaceholder = document.querySelector('.adm-upload-placeholder');
            
            if (blog.image_url && imagePreview) {
                imagePreview.src = '../' + blog.image_url;
                imagePreview.style.display = 'block';
                if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
            } else if (imagePreview) {
                imagePreview.style.display = 'none';
                if (uploadPlaceholder) uploadPlaceholder.style.display = 'block';
            }
        } else {
            console.error('Error fetching blog:', data.message);
            alert('Error fetching blog data');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error fetching blog data');
    }
};

window.deleteBlog = async function(id) {
    if (confirm('Are you sure you want to delete this blog post?')) {
        try {
            const response = await makeAuthenticatedRequest('handlers/blog_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete&id=${id}`
            });
            
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting blog: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error deleting blog');
        }
    }
};

// Testimonial Management
window.editTestimonial = async function(id) {
    try {
        const response = await makeAuthenticatedRequest('handlers/testimonial_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=get&id=${id}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            const testimonial = data.data;
            document.getElementById('testimonialForm').style.display = 'block';
            document.getElementById('testimonial_id').value = testimonial.id;
            document.getElementById('client_name').value = testimonial.client_name;
            document.getElementById('company_name').value = testimonial.company_name;
            document.getElementById('position').value = testimonial.position;
            document.getElementById('testimonial_content').value = testimonial.content;
            document.getElementById('rating').value = testimonial.rating;
            document.getElementById('featured').checked = testimonial.featured;
        } else {
            console.error('Error fetching testimonial:', data.message);
            alert('Error fetching testimonial data');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error fetching testimonial data');
    }
};

window.deleteTestimonial = async function(id) {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        try {
            const response = await makeAuthenticatedRequest('handlers/testimonial_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete&id=${id}`
            });
            
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting testimonial: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error deleting testimonial');
        }
    }
};

window.approveTestimonial = async function(id) {
    try {
        const response = await makeAuthenticatedRequest('handlers/testimonial_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=approve&id=${id}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            location.reload();
        } else {
            alert('Error approving testimonial: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error approving testimonial');
    }
};

// Form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    // Blog form submission
    const blogForm = document.getElementById('saveBlogForm');
    if (blogForm) {
        blogForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const blogId = document.getElementById('blog_id').value;
            
            if (blogId) {
                formData.append('action', 'edit');
            } else {
                formData.append('action', 'add');
            }
            
            try {
                const response = await makeAuthenticatedRequest('handlers/blog_handler.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(blogId ? 'Blog updated successfully!' : 'Blog created successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error submitting blog');
            }
        });
    }
    
    // Testimonial form submission
    const testimonialForm = document.getElementById('saveTestimonialForm');
    if (testimonialForm) {
        testimonialForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const testimonialId = document.getElementById('testimonial_id').value;
            
            if (testimonialId) {
                formData.append('action', 'edit');
            } else {
                formData.append('action', 'add');
            }
            
            try {
                const response = await makeAuthenticatedRequest('handlers/testimonial_handler.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(testimonialId ? 'Testimonial updated successfully!' : 'Testimonial created successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error submitting testimonial');
            }
        });
    }
});
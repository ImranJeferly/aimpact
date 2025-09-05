// Firebase Auth Helper for API Requests
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
    
    // Add token to request
    if (options.body && typeof options.body === 'string') {
        options.body += `&token=${encodeURIComponent(token)}`;
    } else if (options.body instanceof FormData) {
        options.body.append('token', token);
    }
    
    return fetch(url, options);
}

// Blog Management Functions
function showAddForm() {
    const blogForm = document.getElementById('blogForm');
    const testimonialForm = document.getElementById('testimonialForm');
    
    if (blogForm) {
        blogForm.style.display = 'block';
        if (document.getElementById('blog_id')) {
            document.getElementById('blog_id').value = '';
        }
        document.getElementById('saveBlogForm').reset();
        document.getElementById('image-preview').style.display = 'none';
    }
    
    if (testimonialForm) {
        testimonialForm.style.display = 'block';
        if (document.getElementById('testimonial_id')) {
            document.getElementById('testimonial_id').value = '';
        }
        document.getElementById('saveTestimonialForm').reset();
    }
}

function hideForm() {
    const blogForm = document.getElementById('blogForm');
    const testimonialForm = document.getElementById('testimonialForm');
    
    if (blogForm) blogForm.style.display = 'none';
    if (testimonialForm) blogForm.style.display = 'none';
}

async function editBlog(id) {
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
            document.querySelector('select[name="status"]').value = blog.status;
            document.querySelector('select[name="author"]').value = blog.author;
            
            if (blog.image_url) {
                document.getElementById('image-preview').src = '../' + blog.image_url;
                document.getElementById('image-preview').style.display = 'block';
                document.querySelector('.adm-upload-placeholder').style.display = 'none';
            } else {
                document.getElementById('image-preview').style.display = 'none';
                document.querySelector('.adm-upload-placeholder').style.display = 'block';
            }
        } else {
            console.error('Error fetching blog:', data.message);
            alert('Error fetching blog data');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error fetching blog data');
    }
}

function deleteBlog(id) {
    if (confirm('Are you sure you want to delete this blog post?')) {
        fetch('handlers/blog_handler.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'delete',
                id: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting blog post');
            }
        });
    }
}

// Testimonial Management Functions
function editTestimonial(id) {
    fetch('handlers/testimonial_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=get&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const testimonial = data.data;
            document.getElementById('testimonial_id').value = testimonial.id;
            document.querySelector('input[name="client_name"]').value = testimonial.client_name;
            document.querySelector('input[name="company_name"]').value = testimonial.company_name;
            document.querySelector('input[name="position"]').value = testimonial.position;
            document.querySelector('textarea[name="content"]').value = testimonial.content;
            document.querySelector('select[name="rating"]').value = testimonial.rating;
            document.querySelector('input[name="featured"]').checked = testimonial.featured == 1;
            
            document.getElementById('testimonialForm').style.display = 'block';
        }
    });
}

function deleteTestimonial(id) {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        fetch('handlers/testimonial_handler.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=delete&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function approveTestimonial(id) {
    fetch('handlers/testimonial_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=approve&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Add form submit handlers
document.addEventListener('DOMContentLoaded', function() {
    const blogForm = document.getElementById('saveBlogForm');
    if (blogForm) {
        blogForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', formData.get('id') ? 'edit' : 'add');
            formData.append('content', tinymce.get('content').getContent());
            
            fetch('handlers/blog_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    }

    const testimonialForm = document.getElementById('saveTestimonialForm');
    if (testimonialForm) {
        testimonialForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', formData.get('id') ? 'edit' : 'add');
            
            fetch('handlers/testimonial_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    }
});

function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const placeholder = document.querySelector('.adm-upload-placeholder');
    
    if (input.files && input.files[0]) {
        // Check file size
        if (input.files[0].size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Update blog form submit handler
document.addEventListener('DOMContentLoaded', function() {
    const blogForm = document.getElementById('saveBlogForm');
    if (blogForm) {
        blogForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', formData.get('id') ? 'edit' : 'add');

            fetch('handlers/blog_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error saving blog');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving blog');
            });
        });
    }
});

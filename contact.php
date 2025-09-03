<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AImpact</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="assets/icon.svg">
    <script src="js/animations.js"></script>
</head>
<body>
    <div class="horizontal-scroll"> 
        <div class="blog-glow"></div>
        <section id="section1" class="white-section horizontal-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">What are the most time-consuming tasks in your business?</h2>
                </div>
                <div class="white-section-content form-section-content">
                    <form class="question-form">
                        <div class="options-container">
                            <label class="option-label checkbox-label fade-hidden fade-from-bottom delay-short">
                                <input type="checkbox" name="tasks[]" value="Customer Support & Response">
                                <span>Customer Support & Response</span>
                            </label>
                            <label class="option-label checkbox-label fade-hidden fade-from-bottom delay-medium">
                                <input type="checkbox" name="tasks[]" value="Lead Generation & Follow-ups">
                                <span>Lead Generation & Follow-ups</span>
                            </label>
                            <label class="option-label checkbox-label fade-hidden fade-from-bottom delay-medium">
                                <input type="checkbox" name="tasks[]" value="Marketing & Content Creation">
                                <span>Marketing & Content Creation</span>
                            </label>
                            <label class="option-label checkbox-label fade-hidden fade-from-bottom delay-long">
                                <input type="checkbox" name="tasks[]" value="Data Analysis & Reporting">
                                <span>Data Analysis & Reporting</span>
                            </label>
                            <label class="option-label checkbox-label fade-hidden fade-from-bottom delay-long">
                                <input type="checkbox" name="tasks[]" value="Appointment Scheduling">
                                <span>Appointment Scheduling</span>
                            </label>
                            <label class="option-label checkbox-label fade-hidden fade-from-bottom delay-long">
                                <input type="checkbox" name="tasks[]" value="other">
                                <span>Other:</span>
                                <input type="text" class="other-input" placeholder="Please specify">
                            </label>
                        </div>
                        <div class="scroll-nav">
                            <button class="scroll-btn next-btn" type="button" disabled>Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="section2" class="white-section horizontal-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">Have you used AI tools before in your business?</h2>
                </div>
                <div class="white-section-content form-section-content">
                    <form class="question-form">
                        <div class="options-container">
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q2" value="Yes, actively">
                                <span>Yes, actively</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q2" value="Tried but not implemented fully">
                                <span>Tried but not implemented fully</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q2" value="No, but interested">
                                <span>No, but interested</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q2" value="No, and unsure about AI">
                                <span>No, and unsure about AI</span>
                            </label>
                        </div>
                        <div class="scroll-nav">
                            <button class="scroll-btn back-btn prev-btn" type="button">Back</button>
                            <button class="scroll-btn next-btn" type="button" disabled>Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="section3" class="white-section horizontal-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">How soon are you looking to implement AI?</h2>
                </div>
                <div class="white-section-content form-section-content">
                    <form class="question-form">
                        <div class="options-container">
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q3" value="ASAP (Within 1 month)">
                                <span>ASAP (Within 1 month)</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q3" value="1-3 months">
                                <span>1-3 months</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q3" value="3-6 months">
                                <span>3-6 months</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q3" value="Just exploring options">
                                <span>Just exploring options</span>
                            </label>
                        </div>
                        <div class="scroll-nav">
                            <button class="scroll-btn back-btn prev-btn" type="button">Back</button>
                            <button class="scroll-btn next-btn" type="button" disabled>Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="section4" class="white-section horizontal-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">Do you have a budget in mind for AI integration?</h2>
                </div>
                <div class="white-section-content form-section-content">
                    <form class="question-form">
                        <div class="options-container">
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q4" value="<$500">
                                <span>&lt;$500</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q4" value="$500 - $2,000">
                                <span>$500 - $2,000</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q4" value="$2,000 - $5,000">
                                <span>$2,000 - $5,000</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q4" value="$5,000+">
                                <span>$5,000+</span>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <input type="radio" name="q4" value="Not sure yet">
                                <span>Not sure yet</span>
                            </label>
                        </div>
                        <div class="scroll-nav">
                            <button class="scroll-btn back-btn prev-btn" type="button">Back</button>
                            <button class="scroll-btn next-btn" type="button" disabled>Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="section5" class="white-section horizontal-section">
            <div class="white-section-con">
                <div class="chart-content">
                    <h2 class="fade-hidden fade-from-bottom">Basic Business Information</h2>
                </div>
                <div class="white-section-content form-section-content">
                    <form class="question-form">
                        <div class="options-container">
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <span>Business Name:</span>
                                <input type="text" name="business_name" class="other-input" required>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <span>Your Name:</span>
                                <input type="text" name="contact_name" class="other-input" required>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <span>Email:</span>
                                <input type="email" name="email" class="other-input" required>
                            </label>
                            <label class="option-label fade-hidden fade-from-bottom delay-short">
                                <span>Phone Number:</span>
                                <input type="tel" name="phone" class="other-input" required>
                            </label>
                        </div>
                        <div class="scroll-nav">
                            <button class="scroll-btn back-btn prev-btn" type="button">Back</button>
                            <button class="scroll-btn next-btn" type="button" disabled>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        const container = document.querySelector('.horizontal-scroll');
        const sections = document.querySelectorAll('.horizontal-section');
        const prevButtons = document.querySelectorAll('.prev-btn');
        const nextButtons = document.querySelectorAll('.next-btn');
        let currentSection = 0;

        // Initialize all next buttons as disabled
        nextButtons.forEach(btn => {
            btn.disabled = true;
        });

        function updateButtons() {
            prevButtons.forEach((btn, index) => {
                btn.disabled = currentSection === 0;
            });
        }

        function scrollToSection(index) {
            sections[index].scrollIntoView({ behavior: 'smooth' });
            currentSection = index;
            updateButtons();
        }

        // Handle form validation for each section
        document.querySelectorAll('.question-form').forEach((form, index) => {
            const nextBtn = form.querySelector('.next-btn');
            const otherInput = form.querySelector('.other-input');

            if (index === 0) { // First form with checkboxes
                const checkboxes = form.querySelectorAll('input[type="checkbox"]');
                
                function validateCheckboxes() {
                    const isAnyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    const otherChecked = form.querySelector('input[value="other"]')?.checked;
                    nextBtn.disabled = !isAnyChecked || (otherChecked && !otherInput?.value.trim());
                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        if (checkbox.value === 'other') {
                            otherInput.disabled = !checkbox.checked;
                            if (!checkbox.checked) otherInput.value = '';
                        }
                        validateCheckboxes();
                    });
                });

                if (otherInput) {
                    otherInput.addEventListener('input', validateCheckboxes);
                }
            } else if (index === 4) { // Business Information form
                const requiredInputs = form.querySelectorAll('input[required]');
                
                function validateBusinessForm() {
                    const allFilled = Array.from(requiredInputs).every(input => input.value.trim() !== '');
                    nextBtn.disabled = !allFilled;
                }

                requiredInputs.forEach(input => {
                    input.addEventListener('input', validateBusinessForm);
                });

                // Initial validation
                validateBusinessForm();
            } else {
                // ...existing radio button validation for other forms...
                const radioButtons = form.querySelectorAll('input[type="radio"]');

                // Check if any radio is checked on load
                const isChecked = Array.from(radioButtons).some(radio => radio.checked);
                nextBtn.disabled = !isChecked;

                radioButtons.forEach(radio => {
                    radio.addEventListener('change', () => {
                        const selectedRadio = form.querySelector('input[type="radio"]:checked');
                        
                        if (selectedRadio && selectedRadio.value === 'other') {
                            nextBtn.disabled = !otherInput.value.trim();
                            
                            otherInput.addEventListener('input', () => {
                                nextBtn.disabled = !otherInput.value.trim();
                            });
                        } else if (selectedRadio) {
                            nextBtn.disabled = false;
                        }
                    });
                });

                // Disable other input when non-other options are selected
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', () => {
                        if (radio.value !== 'other') {
                            otherInput.disabled = true;
                            otherInput.value = '';
                        } else {
                            otherInput.disabled = false;
                            nextBtn.disabled = true; // Disable next until other input has value
                        }
                    });
                });
            }

            // Modify the submit button handler for the last section
            if (index === 4) {
                const submitBtn = form.querySelector('.next-btn');
                
                submitBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    
                    const formData = new FormData();
                    
                    // Get tasks from first form
                    const checkedBoxes = document.querySelectorAll('#section1 input[type="checkbox"]:checked');
                    checkedBoxes.forEach(cb => {
                        if (cb.value === 'other') {
                            formData.append('tasks[]', cb.closest('label').querySelector('.other-input').value);
                        } else {
                            formData.append('tasks[]', cb.value);
                        }
                    });

                    // Get radio button values
                    formData.append('q2', document.querySelector('input[name="q2"]:checked')?.value || '');
                    formData.append('q3', document.querySelector('input[name="q3"]:checked')?.value || '');
                    formData.append('q4', document.querySelector('input[name="q4"]:checked')?.value || '');
                    
                    // Get business info
                    const businessInfoInputs = form.querySelectorAll('input[required]');
                    businessInfoInputs.forEach(input => {
                        formData.append(input.getAttribute('name'), input.value);
                    });

                    try {
                        // First submit to submit_form.php
                        const response = await fetch('submit_form.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (response.ok) {
                            // Then redirect to thank_you.php with the same data
                            const hiddenForm = document.createElement('form');
                            hiddenForm.method = 'POST';
                            hiddenForm.action = 'thank_you.php';
                            
                            for (const [key, value] of formData.entries()) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                hiddenForm.appendChild(input);
                            }
                            
                            document.body.appendChild(hiddenForm);
                            hiddenForm.submit();
                        } else {
                            throw new Error('Submission failed');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('There was an error submitting the form. Please try again.');
                    }
                });
            }
        });

        // Add form submission handler
        document.querySelectorAll('.question-form').forEach((form, index) => {
            // ...existing validation code...

            // Modify the form submission handler for the last form
            if (index === 4) {
                const submitBtn = form.querySelector('.next-btn');
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    
                    const formData = new FormData();
                    
                    // Get tasks from first form - Modified to handle multiple values
                    const checkedBoxes = document.querySelectorAll('#section1 input[type="checkbox"]:checked');
                    checkedBoxes.forEach(cb => {
                        if (cb.value === 'other') {
                            formData.append('tasks[]', cb.closest('label').querySelector('.other-input').value);
                        } else {
                            formData.append('tasks[]', cb.value);
                        }
                    });

                    // Rest of form data collection
                    formData.append('q2', document.querySelector('input[name="q2"]:checked')?.value || '');
                    formData.append('q3', document.querySelector('input[name="q3"]:checked')?.value || '');
                    formData.append('q4', document.querySelector('input[name="q4"]:checked')?.value || '');
                    
                    // Get business info
                    const businessInfoInputs = form.querySelectorAll('.other-input');
                    businessInfoInputs.forEach(input => {
                        formData.append(input.getAttribute('name'), input.value);
                    });

                    // Create and submit hidden form
                    const hiddenForm = document.createElement('form');
                    hiddenForm.method = 'POST';
                    hiddenForm.action = 'thank_you.php';
                    
                    // Add all form data as hidden inputs
                    for (const [key, value] of formData.entries()) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        hiddenForm.appendChild(input);
                    }
                    
                    document.body.appendChild(hiddenForm);
                    hiddenForm.submit();
                });

                submitBtn.addEventListener('click', () => {
                    form.dispatchEvent(new Event('submit'));
                });
            }
        });

        prevButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentSection > 0) {
                    scrollToSection(currentSection - 1);
                }
            });
        });

        nextButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentSection < sections.length - 1) {
                    scrollToSection(currentSection + 1);
                }
            });
        });

        // Prevent manual scrolling
        container.addEventListener('wheel', (e) => {
            e.preventDefault();
        }, { passive: false });

        container.addEventListener('touchmove', (e) => {
            e.preventDefault();
        }, { passive: false });
    </script>
</body>
</html>
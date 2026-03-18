/**
 * University Procurement Portal
 * Authentication Page JavaScript
 */

(function() {
    'use strict';

    // Password Toggle Functionality
    const initPasswordToggle = function() {
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');

        if (passwordToggle && passwordInput) {
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                const icon = passwordToggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            });
        }
    };

    // Form Validation and Submission
    const initFormValidation = function() {
        const form = document.querySelector('.auth-form');
        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Clear previous errors
                const errorAlert = document.querySelector('.alert-error');
                if (errorAlert) {
                    errorAlert.remove();
                }

                // Validate fields
                const username = document.getElementById('username');
                const password = document.getElementById('password');

                if (!username || !password) return;

                let hasError = false;

                // Validate username
                if (!username.value.trim()) {
                    showFieldError(username, 'Username is required');
                    hasError = true;
                }

                // Validate password
                if (!password.value.trim()) {
                    showFieldError(password, 'Password is required');
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                    return;
                }

                // Add loading state
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });
        }
    };

    // Show Field Error
    const showFieldError = function(field, message) {
        const wrapper = field.closest('.form-group');
        if (!wrapper) return;

        // Remove existing error
        const existingError = wrapper.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Create error element
        const error = document.createElement('div');
        error.className = 'field-error';
        error.style.cssText = 'color: var(--danger-color); font-size: 0.8rem; margin-top: 0.4rem;';
        error.textContent = message;

        wrapper.appendChild(error);

        // Shake animation
        field.classList.add('shake');
        setTimeout(() => field.classList.remove('shake'), 400);

        // Focus on the field
        field.focus();
    };

    // Clear field errors on input
    const initClearErrors = function() {
        const inputs = document.querySelectorAll('.auth-form input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const wrapper = this.closest('.form-group');
                if (wrapper) {
                    const error = wrapper.querySelector('.field-error');
                    if (error) {
                        error.remove();
                    }
                }
            });
        });
    };

    // Demo Credential Quick Fill
    const initDemoCredentials = function() {
        const demoAccounts = document.querySelectorAll('.demo-account');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const form = document.querySelector('.auth-form');

        if (demoAccounts.length && usernameInput && passwordInput && form) {
            demoAccounts.forEach(account => {
                account.style.cursor = 'pointer';
                account.addEventListener('click', function() {
                    const codeElements = this.querySelectorAll('code');
                    if (codeElements.length >= 2) {
                        const username = codeElements[0].textContent.trim();
                        const password = codeElements[1].textContent.trim();

                        // Fill inputs with animation
                        typeInput(usernameInput, username, () => {
                            typeInput(passwordInput, password, () => {
                                // Focus on submit button
                                const submitBtn = form.querySelector('button[type="submit"]');
                                if (submitBtn) {
                                    submitBtn.focus();
                                }
                            });
                        });

                        // Visual feedback
                        account.style.background = '#dbeafe';
                        account.style.borderColor = 'var(--primary-color)';
                        setTimeout(() => {
                            account.style.background = '';
                            account.style.borderColor = '';
                        }, 500);
                    }
                });
            });
        }
    };

    // Type input with animation effect
    const typeInput = function(input, value, callback) {
        input.value = '';
        input.focus();
        let i = 0;
        const speed = 50;

        function type() {
            if (i < value.length) {
                input.value += value.charAt(i);
                i++;
                setTimeout(type, speed);
            } else {
                if (callback) callback();
            }
        }
        type();
    };

    // Initialize all functionality
    const init = function() {
        initPasswordToggle();
        initFormValidation();
        initClearErrors();
        initDemoCredentials();
    };

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.Auth = {
        init: init,
        showFieldError: showFieldError
    };

})();
/**
 * University Procurement Portal
 * Landing Page JavaScript
 * Handles navigation, smooth scroll, mobile menu, and animations
 */

// DOM Elements
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navMenu = document.querySelector('.nav-menu');
const navLinks = document.querySelectorAll('.nav-link');
const landingNav = document.querySelector('.landing-nav');
const heroCards = document.querySelectorAll('.hero-card');

/**
 * Initialize landing page functionality
 */
function initLandingPage() {
    setupMobileMenu();
    setupSmoothScroll();
    setupScrollEffects();
    setupHeroCardAnimations();
    setupIntersectionObserver();
}

/**
 * Setup mobile menu toggle
 */
function setupMobileMenu() {
    if (!mobileMenuBtn || !navMenu) return;

    mobileMenuBtn.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        const icon = mobileMenuBtn.querySelector('i');
        if (navMenu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Close mobile menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            const icon = mobileMenuBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
            navMenu.classList.remove('active');
            const icon = mobileMenuBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    });
}

/**
 * Setup smooth scroll for anchor links
 */
function setupSmoothScroll() {
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('#') && href.length > 1) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const navHeight = landingNav ? landingNav.offsetHeight : 0;
                    const targetPosition = targetElement.offsetTop - navHeight - 20;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}

/**
 * Setup scroll effects (navbar shadow, etc.)
 */
function setupScrollEffects() {
    if (!landingNav) return;

    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        // Add scrolled class when scrolled down
        if (currentScroll > 50) {
            landingNav.classList.add('scrolled');
        } else {
            landingNav.classList.remove('scrolled');
        }

        lastScroll = currentScroll;
    });
}

/**
 * Setup hero card hover effects with additional animations
 */
function setupHeroCardAnimations() {
    heroCards.forEach((card, index) => {
        card.addEventListener('mouseenter', () => {
            // Add subtle scale effect
            card.style.transform = 'translateY(-12px) scale(1.02)';
        });

        card.addEventListener('mouseleave', () => {
            // Reset to floating animation
            card.style.transform = '';
        });

        // Add staggered initial animation
        card.style.animationDelay = `${index * 0.15}s`;
    });
}

/**
 * Setup Intersection Observer for scroll animations
 */
function setupIntersectionObserver() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe feature cards
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Observe step cards
    const steps = document.querySelectorAll('.step');
    steps.forEach((step, index) => {
        step.style.opacity = '0';
        step.style.transform = 'translateY(30px)';
        step.style.transition = `opacity 0.6s ease, transform 0.6s ease ${index * 0.15}s`;
        observer.observe(step);
    });

    // Observe role cards
    const roleCards = document.querySelectorAll('.role-card');
    roleCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease, transform 0.6s ease ${index * 0.15}s`;
        observer.observe(card);
    });

    // Add animate-in styles
    const style = document.createElement('style');
    style.textContent = `
        .animate-in {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    `;
    document.head.appendChild(style);
}

/**
 * Add parallax effect to hero section
 */
function setupParallaxEffect() {
    const hero = document.querySelector('.hero');
    if (!hero) return;

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = hero.querySelectorAll('.hero-card');

        parallaxElements.forEach((card, index) => {
            const speed = 0.05 + (index * 0.02);
            card.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
}

/**
 * Update active navigation link based on scroll position
 */
function updateActiveNavLink() {
    const sections = document.querySelectorAll('section[id]');
    const scrollPosition = window.pageYOffset + 100;

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute('id');

        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}

// Listen for scroll to update active link
window.addEventListener('scroll', updateActiveNavLink);

/**
 * Typing effect for hero badge (optional enhancement)
 */
function typeEffect(element, text, speed = 50) {
    if (!element) return;
    element.textContent = '';
    let i = 0;

    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type();
}

/**
 * Add ripple effect to buttons
 */
function setupRippleEffect() {
    const buttons = document.querySelectorAll('.btn');

    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;

            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add ripple animation keyframes if not exists
    if (!document.getElementById('ripple-styles')) {
        const style = document.createElement('style');
        style.id = 'ripple-styles';
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

/**
 * Initialize when DOM is ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initLandingPage();
        setupParallaxEffect();
        setupRippleEffect();
    });
} else {
    initLandingPage();
    setupParallaxEffect();
    setupRippleEffect();
}

// Export functions for external use
window.LandingPage = {
    initLandingPage,
    setupMobileMenu,
    setupSmoothScroll,
    setupScrollEffects,
    setupIntersectionObserver
};
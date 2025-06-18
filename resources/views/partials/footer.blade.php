<style>
    .app-footer {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #ffffff;
        padding: 3rem 0 1.5rem 0;
        margin-top: auto;
        position: relative;
        overflow: hidden;
    }
    
    .app-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #28a745, #17a2b8, #ffc107, #dc3545);
        background-size: 300% 100%;
        animation: gradientShift 3s ease-in-out infinite;
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 0%; }
        50% { background-position: 100% 0%; }
    }
    
    .footer-content {
        position: relative;
        z-index: 2;
    }
    
    .footer-top {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .footer-brand {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .footer-brand img {
        height: 50px;
        width: auto;
        margin-right: 15px;
        filter: brightness(1.2) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }
    
    .footer-brand-text {
        font-size: 1.4rem;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    
    .footer-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .footer-links {
        margin-bottom: 1.5rem;
    }
    
    .footer-links h5 {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .footer-links h5::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 30px;
        height: 2px;
        background: linear-gradient(90deg, #007bff, #28a745);
        border-radius: 1px;
    }
    
    .footer-links ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links ul li {
        margin-bottom: 0.5rem;
    }
    
    .footer-links ul li a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        padding: 0.25rem 0;
    }
    
    .footer-links ul li a:hover {
        color: #ffffff;
        padding-left: 10px;
        transform: translateX(5px);
    }
    
    .footer-links ul li a i {
        margin-right: 8px;
        font-size: 0.8rem;
        opacity: 0.7;
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .social-link:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    
    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .copyright {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin: 0;
    }
    
    .developer-credit {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .developer-credit .highlight {
        color: #007bff;
        font-weight: 700;
        text-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
    
    .footer-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .contact-info {
        margin-top: 1rem;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }
    
    .contact-item i {
        margin-right: 10px;
        width: 16px;
        color: #007bff;
    }
    
    /* Floating animation elements */
    .footer-decoration {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
    }
    
    .floating-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-shape:nth-child(1) {
        width: 100px;
        height: 100px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-shape:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }
    
    .floating-shape:nth-child(3) {
        width: 80px;
        height: 80px;
        bottom: 30%;
        left: 70%;
        animation-delay: 4s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .app-footer {
            padding: 2rem 0 1rem 0;
        }
        
        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-stats {
            justify-content: center;
            gap: 1rem;
        }
        
        .social-links {
            justify-content: center;
        }
        
        .footer-brand {
            justify-content: center;
            text-align: center;
        }
        
        .footer-brand-text {
            font-size: 1.2rem;
        }
    }
    
    @media (max-width: 576px) {
        .footer-stats {
            flex-direction: column;
            gap: 1rem;
        }
        
        .stat-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
        }
        
        .stat-item:last-child {
            border-bottom: none;
        }
    }
</style>

<footer class="app-footer">
    <!-- Floating decoration elements -->
    <div class="footer-decoration">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    
    <div class="container footer-content">
        <!-- Footer Top Section -->
        <div class="footer-top">
            <div class="row">
                <!-- Brand and Description -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-brand">
                        <img src="{{ asset('assests/image/nstu-logo.png') }}" alt="NSTU Logo">
                        <span class="footer-brand-text">NSTU Portal</span>
                    </div>
                    <p class="footer-description">
                        Secure and efficient transcript management system designed for students and administrators. 
                        Access your academic records with confidence and ease.
                    </p>
                    
                    <!-- Social Links -->
                    <div class="social-links">
                        <a href="#" class="social-link" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Home</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Departments</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>About Us</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Contact</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Help Center</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Services -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Services</h5>
                        <ul>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Request Results</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Payment Portal</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Download Results</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Track Status</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Support</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Contact Information</h5>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Noakhali Science & Technology University<br>Sonapur, Noakhali-3814</span>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-telephone-fill"></i>
                                <span>+880-321-61151</span>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-envelope-fill"></i>
                                <span>info@nstu.edu.bd</span>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-clock-fill"></i>
                                <span>Mon - Fri: 9:00 AM - 5:00 PM</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="footer-stats">
                        <div class="stat-item">
                            <span class="stat-number">5K+</span>
                            <span class="stat-label">Students</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">10K+</span>
                            <span class="stat-label">Results</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">99%</span>
                            <span class="stat-label">Success</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="copyright">
                &copy; {{ date('Y') }} NSTU Transcript Management System. All rights reserved.
            </div>
            <div class="developer-credit">
                Developed with <i class="bi bi-heart-fill text-danger"></i> by 
                <span class="highlight">Saiful Islam Munna</span>
            </div>
        </div>
    </div>
</footer>

<script>
    // Add scroll-to-top functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Create scroll to top button
        const scrollTopBtn = document.createElement('button');
        scrollTopBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
        scrollTopBtn.className = 'scroll-top-btn';
        scrollTopBtn.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        `;
        
        document.body.appendChild(scrollTopBtn);
        
        // Show/hide scroll to top button
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollTopBtn.style.opacity = '1';
                scrollTopBtn.style.visibility = 'visible';
            } else {
                scrollTopBtn.style.opacity = '0';
                scrollTopBtn.style.visibility = 'hidden';
            }
        });
        
        // Scroll to top functionality
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Hover effect for scroll button
        scrollTopBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) translateY(-2px)';
            this.style.boxShadow = '0 6px 20px rgba(0, 123, 255, 0.4)';
        });
        
        scrollTopBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) translateY(0)';
            this.style.boxShadow = '0 4px 15px rgba(0, 123, 255, 0.3)';
        });
    });
</script>
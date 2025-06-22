
@extends('layouts.app')

@section('title','Home')

@push('style')
<style>
    .hero-section {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.8), rgba(40, 167, 69, 0.8)), 
                    url('https://images.unsplash.com/photo-1523050854058-8df90110c9d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        padding: 2rem;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        animation: fadeInUp 1s ease-out;
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        animation: fadeInUp 1s ease-out 0.3s both;
    }
    
    .hero-buttons {
        animation: fadeInUp 1s ease-out 0.6s both;
    }
    
    .btn-hero {
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        margin: 0 10px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .btn-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        text-decoration: none;
    }
    
    .btn-primary-hero {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        border: none;
    }
    
    .btn-outline-hero {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .btn-outline-hero:hover {
        background: white;
        color: #007bff;
    }
    
    .features-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }
    
    .feature-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .feature-text {
        color: #666;
        line-height: 1.6;
    }
    
    .stats-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        color: white;
    }
    
    .stat-item {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .cta-section {
        padding: 80px 0;
        background: #fff;
        text-align: center;
    }
    
    .cta-title {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .cta-text {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 2rem;
    }
    
    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }
    
    .floating-elements::before,
    .floating-elements::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-elements::before {
        width: 200px;
        height: 200px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-elements::after {
        width: 150px;
        height: 150px;
        top: 60%;
        right: 15%;
        animation-delay: 3s;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .btn-hero {
            display: block;
            margin: 10px 0;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="floating-elements"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="hero-content">
                    <h1 class="hero-title">Transcript Management System</h1>
                    <p class="hero-subtitle">
                        Secure, Fast, and Reliable Academic Record Management
                        <br>Access your transcripts anytime, anywhere with complete confidence
                    </p>
                    <div class="hero-buttons">
                        <!-- Always show login and register buttons -->
                        <a href="{{ route('login') }}" class="btn btn-primary-hero btn-hero">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-hero btn-hero">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-4 font-weight-bold mb-3">Why Choose Our System?</h2>
                <p class="lead text-muted">Experience the future of academic record management with our comprehensive platform</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <i class="fas fa-shield-alt feature-icon text-primary"></i>
                    <h4 class="feature-title">Secure & Protected</h4>
                    <p class="feature-text">Your academic records are protected with bank-level security encryption and secure payment processing through SSLCommerz.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <i class="fas fa-bolt feature-icon text-success"></i>
                    <h4 class="feature-title">Fast Processing</h4>
                    <p class="feature-text">Quick result processing and instant notifications. Get your transcripts processed efficiently with minimal waiting time.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <i class="fas fa-mobile-alt feature-icon text-info"></i>
                    <h4 class="feature-title">Mobile Friendly</h4>
                    <p class="feature-text">Access your results from any device. Our responsive design ensures perfect functionality on mobile, tablet, and desktop.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <i class="fas fa-credit-card feature-icon text-warning"></i>
                    <h4 class="feature-title">Easy Payment</h4>
                    <p class="feature-text">Secure online payments with multiple payment options. Pay for your transcript requests safely and conveniently.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <i class="fas fa-download feature-icon text-purple"></i>
                    <h4 class="feature-title">Instant Download</h4>
                    <p class="feature-text">Download your approved results instantly. Access your transcripts 24/7 once they're processed and approved.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <i class="fas fa-headset feature-icon text-danger"></i>
                    <h4 class="feature-title">24/7 Support</h4>
                    <p class="feature-text">Round-the-clock customer support to help you with any queries or issues regarding your transcript requests.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number counter" data-count="5000">0</span>
                    <span class="stat-label">Happy Students</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number counter" data-count="10000">0</span>
                    <span class="stat-label">Results Processed</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number counter" data-count="99">0</span>
                    <span class="stat-label">% Success Rate</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number counter" data-count="24">0</span>
                    <span class="stat-label">Hours Support</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="cta-title">Ready to Get Started?</h2>
                <p class="cta-text">Join thousands of students who trust our platform for their academic record management</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-hero">
                    <i class="fas fa-rocket me-2"></i>Get Started Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    // Counter animation
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const startCount = (counter) => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        // Intersection Observer for counter animation
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCount(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar (if you have one)
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            }
        }));
    });
</script>
@endpush

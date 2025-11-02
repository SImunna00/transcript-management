<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🎓 Transcript Management System

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![GitHub](https://img.shields.io/badge/GitHub-SImunna00-181717?logo=github)](https://github.com/SImunna00/transcript-management)

A comprehensive web-based application for managing student transcripts, marksheets, and academic records with multi-role authentication (Admin, Teacher, Student).

## 📑 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#️-tech-stack)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Database Schema](#-database-schema)
- [API Documentation](#-api-documentation)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Security](#️-security)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

## 🎯 Overview

This Laravel-based Transcript Management System streamlines academic record management, enabling:
- Automated mark entry and CGPA calculation
- PDF marksheet generation
- Online transcript requests with payment processing
- Multi-role access control (Student, Teacher, Admin)

**Live Demo**: [Coming Soon]

## ✨ Features

### 👨‍🎓 Student Portal
- ✅ Secure registration and authentication
- ✅ View enrolled courses and marks
- ✅ Request official transcripts
- ✅ Integrated payment gateway (SSLCommerz)
- ✅ Track request status in real-time
- ✅ Download PDF marksheets

### 👨‍🏫 Teacher Portal
- ✅ Comprehensive mark entry system (Theory/Lab/Special courses)
- ✅ Student search and enrollment verification
- ✅ Automated marksheet generation with CGPA
- ✅ View student academic history
- ✅ Bulk mark entry support

### 👨‍💼 Admin Portal
- ✅ User management (Students, Teachers, Admins)
- ✅ Academic year and term configuration
- ✅ Course catalog management
- ✅ Transcript request processing
- ✅ Payment verification and tracking
- ✅ System reports and analytics
- ✅ Document upload and management

### 🔐 Security Features
- Multi-guard authentication system
- Role-based access control (RBAC)
- CSRF protection
- XSS prevention
- SQL injection protection
- Secure payment processing

## 🛠️ Tech Stack

| Category | Technology |
|----------|------------|
| **Backend** | Laravel 12.x, PHP 8.2+ |
| **Database** | SQLite (dev), MySQL/PostgreSQL (prod) |
| **Frontend** | Blade Templates, Bootstrap 5 |
| **Authentication** | Laravel Breeze (Multi-Guard) |
| **Payment** | SSLCommerz (Bangladesh) |
| **PDF Generation** | DomPDF / Laravel PDF |
| **Version Control** | Git, GitHub |
| **Server** | Apache/Nginx |

## 🚀 Installation

### Prerequisites

Ensure you have the following installed:
- PHP >= 8.2 ([Download](https://www.php.net/downloads))
- Composer ([Download](https://getcomposer.org/download/))
- Node.js & NPM ([Download](https://nodejs.org/))
- Git ([Download](https://git-scm.com/downloads))
- Database: SQLite (dev) or MySQL/PostgreSQL (production)

### Step 1: Clone Repository

```bash
git clone https://github.com/SImunna00/transcript-management.git
cd transcript-management
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Build assets
npm run build
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure `.env` File

Edit `.env` with your settings:

```env
APP_NAME="Transcript Management System"
APP_ENV=local
APP_KEY=base64:generated_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (SQLite for development)
DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite

# For MySQL/PostgreSQL in production
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=transcript_db
# DB_USERNAME=root
# DB_PASSWORD=your_password

# SSLCommerz Payment Configuration (Sandbox)
SSLCOMMERZ_STORE_ID=your_store_id
SSLCOMMERZ_STORE_PASSWORD=your_store_password
SSLCOMMERZ_SANDBOX=true

# For Production
# SSLCOMMERZ_SANDBOX=false

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@transcript.edu
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Step 5: Database Setup

```bash
# Create SQLite database (if using SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Or run specific seeders
php artisan db:seed --class=AcademicYearSeeder
php artisan db:seed --class=TermSeeder
php artisan db:seed --class=TeacherCourseSeeder
```

### Step 6: Storage & Permissions

```bash
# Create symbolic link for storage
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# On Windows (run as Administrator in CMD)
# icacls storage /grant Users:F /T
# icacls bootstrap/cache /grant Users:F /T
```

### Step 7: Start Development Server

```bash
# Start Laravel development server
php artisan serve

# In another terminal, watch for asset changes
npm run dev
```

Visit: **http://localhost:8000**

## ⚙️ Configuration

### Payment Gateway Setup (SSLCommerz)

#### For Sandbox (Testing)

1. **Register for SSLCommerz Sandbox Account**
   - Visit: [https://developer.sslcommerz.com/registration/](https://developer.sslcommerz.com/registration/)
   - Create a sandbox account (free)

2. **Get Credentials**
   - Login to [SSLCommerz Sandbox Dashboard](https://sandbox.sslcommerz.com/)
   - Navigate to: **Settings → API Credentials**
   - Copy **Store ID** and **Store Password**

3. **Add to `.env`**:
   ```env
   SSLCOMMERZ_STORE_ID=test123456  # Your sandbox store ID
   SSLCOMMERZ_STORE_PASSWORD=test123456@ssl  # Your sandbox password
   SSLCOMMERZ_SANDBOX=true
   ```

4. **Test Credentials (Sandbox)**:
   ```env
   # Default SSLCommerz sandbox credentials for testing
   SSLCOMMERZ_STORE_ID=testbox
   SSLCOMMERZ_STORE_PASSWORD=qwerty
   SSLCOMMERZ_SANDBOX=true
   ```

#### For Production

1. **Get Live Account**
   - Contact SSLCommerz: [https://sslcommerz.com/](https://sslcommerz.com/)
   - Complete merchant verification
   - Get production credentials

2. **Update `.env`**:
   ```env
   SSLCOMMERZ_STORE_ID=your_live_store_id
   SSLCOMMERZ_STORE_PASSWORD=your_live_password
   SSLCOMMERZ_SANDBOX=false  # Important: Set to false for production
   ```

3. **Configure IPN URL** (Instant Payment Notification):
   - In SSLCommerz dashboard, set IPN URL to:
   ```
   https://yourdomain.com/payment/ipn
   ```

#### SSLCommerz Test Cards

For sandbox testing, use these test cards:

| Card Type | Card Number | CVV | Expiry | Status |
|-----------|-------------|-----|--------|--------|
| Visa | 4242424242424242 | 123 | Any future date | Success |
| MasterCard | 5555555555554444 | 123 | Any future date | Success |
| Amex | 378282246310005 | 1234 | Any future date | Success |
| Decline | 4000000000000002 | 123 | Any future date | Declined |

**Mobile Banking (Sandbox)**:
- bKash: Use any 11-digit number starting with 01
- Rocket: Use any 11-digit number starting with 01
- Nagad: Use any 11-digit number starting with 01

### Email Configuration

For development, use [Mailtrap](https://mailtrap.io):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
```

For production, use services like:
- Gmail SMTP
- SendGrid
- Amazon SES
- Mailgun

### Line Ending Configuration (Windows)

```bash
# Configure Git to auto-convert line endings
git config core.autocrlf true
```

## 📚 Usage

### Default Login Credentials (After Seeding)

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@example.com | password |
| **Teacher** | teacher@example.com | password |
| **Student** | student@example.com | password |

⚠️ **Change these in production!**

### Authentication Routes

| Role | Login URL | Register URL | Dashboard URL |
|------|-----------|--------------|---------------|
| **Student** | `/login` | `/register` | `/dashboard` |
| **Teacher** | `/teacher/login` | `/teacher/register` | `/teacher/dashboard` |
| **Admin** | `/admin/login` | `/admin/register` | `/admin/dashboard` |

### Student Workflow

1. **Register/Login** → Student portal
2. **View Courses** → See enrolled courses
3. **Request Transcript**:
   - Fill request form
   - Make payment via SSLCommerz (supports bKash, Rocket, Nagad, Credit/Debit cards)
   - Track request status
4. **Download Marksheet** → PDF generation

### Teacher Workflow

1. **Login** → Teacher portal
2. **Select Academic Period** → Choose year and term
3. **Search Student** → Find by ID/name
4. **Enter Marks**:
   - Theory marks (CA, Semester, Total)
   - Lab marks
   - Special course marks
5. **Generate Marksheet** → Auto-calculate CGPA and create PDF
6. **View Reports** → Student performance analytics

### Admin Workflow

1. **Login** → Admin panel
2. **Manage Users** → Add/edit students, teachers
3. **Configure Academic Year** → Set terms and dates
4. **Manage Courses** → Add/edit course catalog
5. **Process Requests**:
   - Review transcript requests
   - Verify payments
   - Approve/reject requests
6. **Generate Reports** → Analytics dashboard

### Payment Flow

```
Student → Request Transcript → SSLCommerz Payment Page
   ↓
Choose Payment Method (Card/bKash/Rocket/Nagad)
   ↓
Complete Payment → SSLCommerz validates
   ↓
Success → IPN callback → Update request status
   ↓
Admin reviews → Approve/Process transcript
```

## 📊 Database Schema

### Core Tables

```
users (Students)
├── id
├── name
├── email
├── student_id (unique)
├── academic_year_id
├── term_id
└── timestamps

teachers
├── id
├── name
├── email
├── department
└── timestamps

admins
├── id
├── name
├── email
└── timestamps

academic_years
├── id
├── year (e.g., "2024-2025")
├── start_date
└── end_date

terms
├── id
├── academic_year_id
├── name (e.g., "1st Term")
└── timestamps

courses
├── id
├── code (unique)
├── name
├── type (theory/lab/special)
├── credit_hours
└── timestamps

enrollments
├── id
├── user_id
├── course_id
├── academic_year_id
├── term_id
└── timestamps

theory_marks
├── id
├── user_id
├── course_id
├── academic_year_id
├── term_id
├── ca_marks
├── semester_marks
├── total_marks
└── timestamps

lab_marks
├── id
├── user_id
├── course_id
├── marks
└── timestamps

special_marks
├── id
├── user_id
├── course_id
├── marks
└── timestamps

marksheets
├── id
├── user_id
├── academic_year_id
├── term_id
├── cgpa
├── file_path
└── timestamps

transcript_requests
├── id
├── user_id
├── request_date
├── status (pending/approved/rejected)
├── payment_status (pending/paid/failed)
├── payment_id (SSLCommerz transaction ID)
├── payment_method (card/bkash/rocket/nagad)
├── session (academic year)
├── amount
└── timestamps
```

### Relationships

- `User` hasMany `Enrollments`, `Marks`, `TranscriptRequests`
- `Course` hasMany `Enrollments`, `Marks`
- `AcademicYear` hasMany `Terms`, `Users`, `Enrollments`
- `Term` belongsTo `AcademicYear`

## 🔌 API Documentation

### Public Endpoints

```http
GET  /api/courses
GET  /api/academic-years
```

### Authenticated Endpoints (Require Bearer Token)

```http
# Student
GET  /api/student/marks
GET  /api/student/transcripts
POST /api/student/transcript-request

# Teacher
POST /api/teacher/marks
GET  /api/teacher/students/{id}

# Admin
GET  /api/admin/users
POST /api/admin/courses
PUT  /api/admin/requests/{id}/approve
```

### Payment Endpoints

```http
# Initialize payment
POST /payment/checkout
{
  "request_id": 1,
  "amount": 500,
  "currency": "BDT"
}

# Payment success callback
POST /payment/success

# Payment failure callback
POST /payment/fail

# Payment cancel callback
POST /payment/cancel

# IPN (Instant Payment Notification)
POST /payment/ipn
```

### Example Request

```bash
curl -X POST http://localhost:8000/api/teacher/marks \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "course_id": 5,
    "ca_marks": 30,
    "semester_marks": 70
  }'
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/MarkEntryTest.php

# Run with coverage
php artisan test --coverage

# Run specific test method
php artisan test --filter=test_teacher_can_enter_marks
```

### Writing Tests

Tests are located in `tests/Feature` and `tests/Unit`.

Example test:

```php
public function test_student_can_request_transcript()
{
    $student = User::factory()->create();
    
    $response = $this->actingAs($student)
        ->post('/transcript-request', [
            'session' => '2024-2025',
            'payment_method' => 'sslcommerz'
        ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('transcript_requests', [
        'user_id' => $student->id
    ]);
}
```

## 🚀 Deployment

### Deploy to Shared Hosting (cPanel)

1. **Upload files via FTP/File Manager**
2. **Move `public` folder contents to `public_html`**
3. **Update `.env`**:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   # SSLCommerz Production
   SSLCOMMERZ_SANDBOX=false
   SSLCOMMERZ_STORE_ID=your_live_store_id
   SSLCOMMERZ_STORE_PASSWORD=your_live_password
   ```
4. **Run migrations via SSH or cPanel Terminal**:
   ```bash
   php artisan migrate --force
   ```
5. **Set folder permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

### Deploy to VPS (Ubuntu/Nginx)

```bash
# Install dependencies
sudo apt update
sudo apt install php8.2 php8.2-fpm php8.2-mysql nginx composer

# Clone repository
cd /var/www
git clone https://github.com/SImunna00/transcript-management.git
cd transcript-management

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Configure Nginx (create /etc/nginx/sites-available/transcript)
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/transcript-management/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

# Enable site
sudo ln -s /etc/nginx/sites-available/transcript /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx

# Set up SSL with Let's Encrypt
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

### Deploy to Heroku

```bash
# Install Heroku CLI
# Login to Heroku
heroku login

# Create app
heroku create transcript-management-app

# Add PostgreSQL
heroku addons:create heroku-postgresql:hobby-dev

# Set environment variables
heroku config:set APP_KEY=$(php artisan key:generate --show)
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set SSLCOMMERZ_STORE_ID=your_store_id
heroku config:set SSLCOMMERZ_STORE_PASSWORD=your_password
heroku config:set SSLCOMMERZ_SANDBOX=false

# Deploy
git push heroku main

# Run migrations
heroku run php artisan migrate --force
```

## 🛡️ Security

### Pre-Production Checklist

- [ ] Remove development files:
  ```bash
  rm public/file-explorer.php
  rm public/quick-access.html
  rm create-shortcut.bat
  rm navigate.bat
  ```

- [ ] Update `.env`:
  ```env
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://yourdomain.com
  SSLCOMMERZ_SANDBOX=false
  ```

- [ ] Change default passwords
- [ ] Enable HTTPS (SSL certificate)
- [ ] Configure firewall
- [ ] Set up database backups
- [ ] Enable error logging (not displaying)
- [ ] Restrict file permissions:
  ```bash
  chmod -R 755 storage bootstrap/cache
  chmod 644 .env
  ```

- [ ] Configure CORS if using API
- [ ] Enable rate limiting
- [ ] Set up monitoring (logs, uptime)
- [ ] Whitelist SSLCommerz IPs for IPN callbacks

### Security Best Practices

```php
// Already implemented in the project:
- CSRF protection on all forms
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- Password hashing (bcrypt)
- Secure session management
- Input validation and sanitization
- Payment verification with SSLCommerz hash validation
```

## 🔧 Troubleshooting

### Common Issues

**1. CRLF/LF Line Ending Warnings**
```bash
# Solution: Configure Git
git config core.autocrlf true
```

**2. Permission Denied Errors**
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows (as Administrator)
icacls storage /grant Users:F /T
```

**3. Class Not Found Errors**
```bash
# Clear and rebuild autoload
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
php artisan cache:clear
```

**4. Database Connection Failed**
```bash
# Check .env database settings
# For SQLite, ensure database file exists
touch database/database.sqlite

# For MySQL, verify credentials
php artisan config:clear
```

**5. SSLCommerz Payment Errors**

**Error: "Store ID or Password incorrect"**
```bash
# Verify credentials in .env
# For sandbox, use test credentials:
SSLCOMMERZ_STORE_ID=testbox
SSLCOMMERZ_STORE_PASSWORD=qwerty
SSLCOMMERZ_SANDBOX=true

# Clear config cache
php artisan config:clear
```

**Error: "Payment gateway not responding"**
```bash
# Check sandbox mode
SSLCOMMERZ_SANDBOX=true  # For testing

# Verify network connectivity
curl https://sandbox.sslcommerz.com/gwprocess/v4/api.php
```

**Error: "IPN validation failed"**
```bash
# Ensure IPN URL is publicly accessible
# Check logs: storage/logs/laravel.log
# Verify hash validation in PaymentController
```

**6. 500 Internal Server Error**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Check file permissions
# Enable debug mode temporarily (local only!)
APP_DEBUG=true
```

**7. Route Not Found**
```bash
# Clear route cache
php artisan route:clear
php artisan route:cache
```

**8. Assets Not Loading**
```bash
# Rebuild assets
npm run build

# Create storage link
php artisan storage:link
```

### Debug Commands

```bash
# Show all routes
php artisan route:list

# Check database connection
php artisan db:show

# View configuration
php artisan config:show database

# Clear all caches
php artisan optimize:clear

# Run queue workers (if using queues)
php artisan queue:work

# Test SSLCommerz connection
php artisan tinker
>>> app('sslcommerz')->makePayment([...]);
```

### SSLCommerz Testing Tips

1. **Always use sandbox mode for development**
2. **Test all payment methods**: Card, bKash, Rocket, Nagad
3. **Test failure scenarios**: Use decline test card
4. **Verify IPN callbacks**: Check logs for webhook hits
5. **Test amount validation**: Ensure minimum 10 BDT

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the repository**
   ```bash
   # Click "Fork" on GitHub
   ```

2. **Create a feature branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```

3. **Make your changes**
   - Follow PSR-12 coding standards
   - Write tests for new features
   - Update documentation

4. **Commit your changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```

5. **Push to the branch**
   ```bash
   git push origin feature/AmazingFeature
   ```

6. **Open a Pull Request**
   - Describe your changes
   - Reference related issues

### Code Style

This project follows [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards.

```bash
# Check code style
./vendor/bin/phpcs

# Auto-fix code style
./vendor/bin/phpcbf
```

### Commit Message Convention

```
feat: Add new feature
fix: Fix bug
docs: Update documentation
style: Code style changes
refactor: Code refactoring
test: Add tests
chore: Maintenance tasks
```

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 SImunna00

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 👨‍💻 Author

**SImunna00**
- GitHub: [@SImunna00](https://github.com/SImunna00)
- Repository: [transcript-management](https://github.com/SImunna00/transcript-management)
- Email: support@example.com

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com) - The PHP framework
- [SSLCommerz](https://sslcommerz.com) - Payment gateway for Bangladesh
- [Bootstrap](https://getbootstrap.com) - UI framework
- [DomPDF](https://github.com/dompdf/dompdf) - PDF generation
- All contributors and open-source community

## 📞 Support

Need help? Here's how to get support:

- 📖 [Documentation](https://github.com/SImunna00/transcript-management/wiki)
- 🐛 [Report a Bug](https://github.com/SImunna00/transcript-management/issues)
- 💡 [Request a Feature](https://github.com/SImunna00/transcript-management/issues)
- 📧 Email: support@example.com
- 💬 Discussions: [GitHub Discussions](https://github.com/SImunna00/transcript-management/discussions)

### SSLCommerz Support
- Documentation: [https://developer.sslcommerz.com/](https://developer.sslcommerz.com/)
- Support Email: support@sslcommerz.com
- Sandbox Dashboard: [https://sandbox.sslcommerz.com/](https://sandbox.sslcommerz.com/)

## 📈 Project Stats

![GitHub stars](https://img.shields.io/github/stars/SImunna00/transcript-management?style=social)
![GitHub forks](https://img.shields.io/github/forks/SImunna00/transcript-management?style=social)
![GitHub issues](https://img.shields.io/github/issues/SImunna00/transcript-management)
![GitHub pull requests](https://img.shields.io/github/issues-pr/SImunna00/transcript-management)

---

**Made with ❤️ by SImunna00**

**Last Updated**: November 2025 | **Version**: 1.0.0

⭐ If you find this project helpful, please give it a star on GitHub!

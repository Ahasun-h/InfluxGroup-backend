# Influx Group - Backend Management System & Headless CMS API

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-^8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.style=for-the-badge)](#license)

A modern, robust, and feature-complete Enterprise ERP, CRM, Analytics, and Headless CMS API platform built with **Laravel 13** and **PHP 8.3**. Designed for high performance and seamless integration with frontend web/mobile applications.

---

## 🚀 System Architecture & Key Features

### 🏢 1. Enterprise Lead & CRM System
- **Lead Pipeline Management**: Track and manage prospective business leads across status workflows.
- **Customer CRM**: Maintain customer records, communication touchpoints, interaction logs, and full histories.
- **Lead-to-Customer Conversion**: Convert qualified leads directly into active customer accounts.

### 📄 2. Quotation Engine
- **Quotation Creation & Management**: Dynamic multi-item quotation generation with automated price & tax calculations.
- **PDF Generation**: Native PDF export capability powered by `barryvdh/laravel-dompdf`.
- **Inbound Request Conversion**: Transform public web quote requests directly into official quotations.

### 📰 3. Dynamic Headless Content Management System (CMS)
- **Modular Content Entities**: Comprehensive CRUD management for Products, Projects, Services & Solutions, News/Blog posts, and Custom Pages.
- **CMS Page Builder Sections**: Configurable section management for Hero banners, About Us, Journey Timelines, Core Values, Testimonials, Brand Statements, Partner Logos, and Contact CTAs.
- **Rich Media & File Attachment Support**: Multi-image galleries, brochure attachments, and rich-text upload handling.

### 💼 4. Career Opportunities Portal
- **Job Posting Management**: Manage career openings with status toggling, custom display ordering, soft deletion, and restoration capabilities.
- **Public Job Listings API**: Restful endpoints for frontend job board rendering.

### 📊 5. Analytics & Visitor Insights
- **Visitor & Page View Tracking**: Privacy-conscious real-time tracking of visitor traffic, page views, duration, referring domains, user agents, and IP addresses.
- **Analytical Dashboards**: Segmented analytics dashboards for **Website Traffic**, **Business Metrics**, and **Content Performance**.
- **Analytics API**: Interactive chart data endpoints for custom dashboard visualizations.

### 🌐 6. Public RESTful API Suite
- CORS-enabled, clean JSON endpoints under `/api/...` for products, projects, services, solutions, news, careers, CMS dynamic sections, contact forms, and quote submissions.

---

## 🛠️ Technology Stack

- **Framework**: Laravel 13.x
- **Language**: PHP 8.3+
- **Database**: MySQL / PostgreSQL / SQLite
- **Authentication**: Laravel Sanctum & Laravel Breeze
- **PDF Export**: Dompdf (`barryvdh/laravel-dompdf`)
- **Frontend Stack (Admin UI)**: Blade, Tailwind CSS, Vite, Alpine.js, Concurrently
- **Tooling**: Laravel Pint (Code Styling), Laravel Pail, Composer

---

## 💻 Installation & Setup Guide

### Prerequisites
Ensure your local development environment meets the following requirements:
- **PHP**: `>= 8.3` with standard extensions (`pdo`, `mbstring`, `openssl`, `xml`, `curl`)
- **Composer**: `>= 2.x`
- **Node.js**: `>= 18.x` & `npm`
- **Database**: MySQL 8.x / PostgreSQL / SQLite

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Ahasun-h/InfluxGroup-backend.git
   cd InfluxGroup-backend
   ```

2. **Run Standard Project Setup**
   The project includes an optimized composer setup script:
   ```bash
   composer run setup
   ```
   *Or execute the steps manually:*
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --force
   npm install
   npm run build
   ```

3. **Configure Environment (`.env`)**
   Update database connection parameters and application credentials in `.env`:
   ```env
   APP_NAME="Influx Group"
   APP_ENV=local
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=influxgroup_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Storage Symlink Setup**
   To ensure user-uploaded images and documents are publicly accessible:
   ```bash
   php artisan storage:link
   ```
   *(Alternatively, visit `/storage-link` in your browser if running under Nginx/Herd environment).*

5. **Start Development Servers**
   Run the unified development command (starts Artisan Server, Queue Listener, and Vite concurrently):
   ```bash
   composer run dev
   ```
   Access the backend at `http://localhost:8000`.

---

## 🌐 API Overview & Endpoints

All public API routes are prefixed with `/api`. Below are key available resources:

### Public Content APIs
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/products` | Fetch list of all published products |
| `GET` | `/api/products/featured` | Fetch featured products for homepage |
| `GET` | `/api/products/{slug}` | Fetch single product details by slug |
| `GET` | `/api/projects` | Fetch list of portfolio projects |
| `GET` | `/api/services` | Fetch services list |
| `GET` | `/api/solutions` | Fetch solutions list |
| `GET` | `/api/news` | Fetch blog / news articles |
| `GET` | `/api/careers/jobs` | Fetch open career opportunities |

### Headless CMS APIs
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/cms/hero` | Homepage Hero banner content |
| `GET` | `/api/cms/homepage` | Consolidated content payload for homepage |
| `GET` | `/api/cms/about/hero` | About page hero section |
| `GET` | `/api/cms/testimonials` | Testimonials listing |
| `GET` | `/api/cms/settings` | Website branding and global metadata |

### Submissions & Analytics APIs
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/contact/submit` | Submit contact form message |
| `POST` | `/api/quote-requests/submit` | Submit custom quotation request |
| `POST` | `/api/analytics/track` | Track page view & visitor engagement |

---

## 🧪 Testing & Code Quality

Execute automated tests:
```bash
composer test
```
*or*
```bash
php artisan test
```

Format code according to Laravel Pint guidelines:
```bash
./vendor/bin/pint
```

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

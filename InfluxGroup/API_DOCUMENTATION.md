# Influx Group API Documentation

Complete RESTful API documentation for the Influx Group Energy & Infrastructure Website.

## 📋 Table of Contents

- [Base URL](#base-url)
- [Authentication](#authentication)
- [API Endpoints](#api-endpoints)
- [Data Models](#data-models)
- [Error Handling](#error-handling)
- [Rate Limiting](#rate-limiting)
- [Postman Collection](#postman-collection)

---

## 🔗 Base URL

```
Production: https://api.influxgroup.com
Development: https://dev-api.influxgroup.com
```

---

## 🔐 Authentication

Most endpoints are public and don't require authentication. Admin endpoints require Bearer token authentication.

### Admin Login

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@influxgroup.com",
  "password": "your_password"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "tokenType": "Bearer",
    "expiresIn": 86400,
    "user": {
      "id": "admin-001",
      "name": "System Administrator",
      "email": "admin@influxgroup.com",
      "role": "admin",
      "permissions": [
        "products.manage",
        "projects.manage",
        "news.manage",
        "content.manage",
        "careers.manage",
        "users.manage"
      ]
    }
  }
}
```

### Using the Token

Include the token in the Authorization header for protected endpoints:

```http
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

---

## 📡 API Endpoints

### 1. Products API

#### Get All Products
```http
GET /api/products
```

**Query Parameters:**
- `category` (optional): Filter by category - `all`, `transformers`, `switchgear`, `renewables`, `automation`
- `page` (optional): Page number (default: 1)
- `limit` (optional): Items per page (default: 10)

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "prod-001",
      "name": "Power Transformer 250 MVA",
      "category": "transformers",
      "description": "High-efficiency power transformer for industrial applications",
      "specifications": {
        "capacity": "250 MVA",
        "voltage": "230/66 kV",
        "frequency": "50 Hz",
        "cooling": "ONAF"
      },
      "features": [
        "Low losses design",
        "Enhanced thermal performance",
        "Advanced protection systems"
      ],
      "image": "/images/products/transformer-250mva.jpg",
      "brochure": "/downloads/brochures/transformer-250mva.pdf",
      "createdAt": "2026-01-15T10:00:00Z",
      "updatedAt": "2026-01-15T10:00:00Z"
    }
  ],
  "pagination": {
    "total": 45,
    "page": 1,
    "limit": 10,
    "totalPages": 5
  }
}
```

#### Get Product by ID
```http
GET /api/products/:id
```

#### Get Product Categories
```http
GET /api/products/categories
```

#### Create Product (Admin)
```http
POST /api/products
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Distribution Transformer 100 KVA",
  "category": "transformers",
  "description": "Compact distribution transformer for residential and commercial use",
  "specifications": {
    "capacity": "100 KVA",
    "voltage": "11/0.4 kV",
    "frequency": "50 Hz",
    "cooling": "ONAN"
  },
  "features": [
    "Low maintenance design",
    "Compact footprint",
    "High efficiency"
  ]
}
```

#### Update Product (Admin)
```http
PUT /api/products/:id
Authorization: Bearer {token}
```

#### Delete Product (Admin)
```http
DELETE /api/products/:id
Authorization: Bearer {token}
```

---

### 2. Projects API

#### Get All Projects
```http
GET /api/projects
```

**Query Parameters:**
- `category` (optional): Filter by category - `all`, `power`, `transmission`, `renewable`, `industrial`
- `status` (optional): Filter by status - `ongoing`, `completed`, `planned`
- `page` (optional): Page number
- `limit` (optional): Items per page

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "proj-001",
      "title": "Matarbari Ultra Mega Power Project",
      "location": "Matarbari, Cox's Bazar",
      "capacity": "1200 MW",
      "type": "Coal-fired Power Plant",
      "category": "power",
      "status": "ongoing",
      "completion": "75%",
      "client": "Bangladesh Power Development Board",
      "value": "$4.5 Billion",
      "startDate": "2020-01-15",
      "expectedCompletion": "2026-12-31",
      "image": "/images/projects/matarbari.jpg",
      "images": [
        "/images/projects/matarbari-1.jpg",
        "/images/projects/matarbari-2.jpg"
      ],
      "scope": [
        "EPC Contracting",
        "Transformer Installation",
        "Switchgear Systems",
        "Transmission Integration"
      ],
      "highlights": [
        "Largest power project in Bangladesh",
        "Ultra-supercritical technology"
      ],
      "stats": {
        "transformers": 12,
        "switchgear": 45,
        "workforce": 2500
      }
    }
  ],
  "pagination": {
    "total": 25,
    "page": 1,
    "limit": 10,
    "totalPages": 3
  }
}
```

#### Get Featured Projects
```http
GET /api/projects/featured?limit=4
```

#### Get Project by ID
```http
GET /api/projects/:id
```

#### Create Project (Admin)
```http
POST /api/projects
Authorization: Bearer {token}
```

#### Update Project (Admin)
```http
PUT /api/projects/:id
Authorization: Bearer {token}
```

#### Delete Project (Admin)
```http
DELETE /api/projects/:id
Authorization: Bearer {token}
```

---

### 3. Services API

#### Get All Services
```http
GET /api/services
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "serv-001",
      "title": "EPC Contracting",
      "icon": "cog",
      "description": "Turnkey Engineering, Procurement, and Construction services",
      "features": [
        "Project Planning & Design",
        "Procurement Management",
        "Construction & Installation",
        "Commissioning & Handover"
      ],
      "process": [
        {
          "step": 1,
          "title": "Consultation",
          "description": "Initial requirement analysis and feasibility study"
        },
        {
          "step": 2,
          "title": "Design",
          "description": "Detailed engineering design and planning"
        }
      ],
      "image": "/images/services/epc-contracting.jpg"
    }
  ]
}
```

#### Get Service by ID
```http
GET /api/services/:id
```

---

### 4. Solutions API

#### Get All Solutions
```http
GET /api/solutions
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "sol-001",
      "title": "EPC Solutions",
      "icon": "zap",
      "description": "Complete turnkey solutions for power generation and transmission",
      "features": [
        "Project Management",
        "Engineering Design",
        "Procurement Excellence",
        "Construction Expertise"
      ],
      "applications": [
        "Power Plants",
        "Substations",
        "Transmission Lines",
        "Distribution Networks"
      ],
      "image": "/images/solutions/epc.jpg"
    }
  ]
}
```

#### Get Industries Served
```http
GET /api/solutions/industries
```

---

### 5. News API

#### Get All News
```http
GET /api/news
```

**Query Parameters:**
- `category` (optional): Filter by category
- `page` (optional): Page number
- `limit` (optional): Items per page

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "news-001",
      "title": "Influx Group Completes Mongla 50MW Solar Park",
      "category": "project-milestones",
      "categoryLabel": "Project Milestones",
      "excerpt": "Successfully commissioned Bangladesh's first utility-scale solar park",
      "content": "<p>Detailed article content here...</p>",
      "image": "/images/news/mongla-solar-completion.jpg",
      "author": {
        "name": "Rahim Uddin",
        "role": "PR Manager"
      },
      "publishedDate": "2026-04-15T10:00:00Z",
      "readTime": "5 min read",
      "featured": true,
      "tags": ["renewable", "solar", "milestone"]
    }
  ],
  "pagination": {
    "total": 45,
    "page": 1,
    "limit": 10,
    "totalPages": 5
  }
}
```

#### Get Featured News
```http
GET /api/news/featured?limit=3
```

#### Get News by ID
```http
GET /api/news/:id
```

#### Create News Article (Admin)
```http
POST /api/news
Authorization: Bearer {token}
```

#### Update News Article (Admin)
```http
PUT /api/news/:id
Authorization: Bearer {token}
```

#### Delete News Article (Admin)
```http
DELETE /api/news/:id
Authorization: Bearer {token}
```

---

### 6. Gallery API

#### Get Gallery Media
```http
GET /api/gallery
```

**Query Parameters:**
- `type` (optional): Filter by type - `all`, `photo`, `video`
- `category` (optional): Filter by category
- `page` (optional): Page number

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "gallery-001",
      "type": "photo",
      "title": "Matarbari Power Plant Construction",
      "category": "power-projects",
      "categoryLabel": "Power Projects",
      "url": "/images/gallery/matarbari-construction.jpg",
      "thumbnail": "/images/gallery/thumbs/matarbari-construction-thumb.jpg",
      "caption": "Aerial view of construction progress",
      "alt": "Matarbari Power Plant Construction Site",
      "project": "Matarbari Ultra Mega Power Project",
      "projectId": "proj-001",
      "date": "2026-03-15T10:00:00Z",
      "featured": true,
      "order": 1
    }
  ],
  "pagination": {
    "total": 85,
    "page": 1,
    "limit": 20,
    "totalPages": 5
  }
}
```

#### Get Gallery Categories
```http
GET /api/gallery/categories
```

#### Upload Media (Admin)
```http
POST /api/gallery/upload
Authorization: Bearer {token}
Content-Type: multipart/form-data

file: [binary]
type: photo
category: power-projects
title: Power Plant Installation
caption: Installation of main transformer
```

#### Delete Media (Admin)
```http
DELETE /api/gallery/:id
Authorization: Bearer {token}
```

---

### 7. Contact API

#### Submit Contact Form
```http
POST /api/contact/submit
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "+880 1712-345678",
  "subject": "Product Inquiry - Power Transformer",
  "message": "I am interested in your 250 MVA power transformer. Please provide technical specifications and quotation."
}
```

**Response:**
```json
{
  "success": true,
  "message": "Thank you for contacting us. We will get back to you within 24 hours.",
  "data": {
    "submissionId": "sub-20260506-001",
    "submittedAt": "2026-05-06T10:30:00Z"
  }
}
```

#### Request Quote
```http
POST /api/contact/quote
Content-Type: application/json

{
  "name": "Md. Karim",
  "company": "ABC Textile Mills Ltd",
  "email": "karim@abctextile.com",
  "phone": "+880 1812-456789",
  "product": "Power Transformer 250 MVA",
  "quantity": 2,
  "requirements": "We need two 250 MVA transformers for our new facility. Delivery required within 6 months.",
  "budget": "Not specified",
  "timeline": "6 months"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Your quote request has been submitted. Our sales team will contact you within 48 hours.",
  "data": {
    "quoteId": "quote-20260506-001",
    "referenceNumber": "INFLX-QT-20260506-001",
    "submittedAt": "2026-05-06T10:30:00Z",
    "expectedResponse": "48 hours"
  }
}
```

#### Get Office Locations
```http
GET /api/contact/offices
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "office-dhaka",
      "city": "Dhaka",
      "type": "Corporate Headquarters",
      "address": "Level 12, Energy Plaza, Tejgaon Industrial Area",
      "area": "Tejgaon I/A",
      "city": "Dhaka 1208",
      "country": "Bangladesh",
      "phone": "+880 2 987 6543",
      "email": "dhaka@influxgroup.com",
      "hours": {
        "sunday": "9:00 AM - 6:00 PM",
        "monday": "9:00 AM - 6:00 PM",
        "tuesday": "9:00 AM - 6:00 PM",
        "wednesday": "9:00 AM - 6:00 PM",
        "thursday": "9:00 AM - 6:00 PM",
        "friday": "Closed",
        "saturday": "Closed"
      },
      "coordinates": {
        "lat": 23.7544,
        "lng": 90.3837
      },
      "mapUrl": "https://maps.google.com/?q=Influx+Group+Dhaka"
    }
  ]
}
```

---

### 8. Testimonials API

#### Get All Testimonials
```http
GET /api/testimonials
```

**Query Parameters:**
- `featured` (optional): Get featured testimonials only - `true`
- `limit` (optional): Number of testimonials to return

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "test-001",
      "name": "Rahman Ali",
      "position": "Chief Engineer",
      "company": "Bangladesh Power Development Board",
      "companyLogo": "/images/logos/bpdb.png",
      "content": "Influx Group has been our trusted partner for over 15 years...",
      "rating": 5,
      "project": "National Grid Transmission Upgrade",
      "image": "/images/testimonials/rahman-ali.jpg",
      "featured": true,
      "date": "2026-03-15T10:00:00Z"
    }
  ]
}
```

#### Create Testimonial (Admin)
```http
POST /api/testimonials
Authorization: Bearer {token}
```

#### Update Testimonial (Admin)
```http
PUT /api/testimonials/:id
Authorization: Bearer {token}
```

#### Delete Testimonial (Admin)
```http
DELETE /api/testimonials/:id
Authorization: Bearer {token}
```

---

### 9. Partners API

#### Get All Partners
```http
GET /api/partners
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "partner-001",
      "name": "Bangladesh Power Development Board",
      "shortName": "BPDB",
      "type": "government",
      "logo": "/images/partners/bpdb.png",
      "website": "https://www.bpdb.gov.bd",
      "description": "Government agency responsible for power generation and distribution",
      "partnershipType": "Client",
      "since": "1995",
      "featured": true,
      "order": 1
    }
  ]
}
```

#### Create Partner (Admin)
```http
POST /api/partners
Authorization: Bearer {token}
```

#### Update Partner (Admin)
```http
PUT /api/partners/:id
Authorization: Bearer {token}
```

#### Delete Partner (Admin)
```http
DELETE /api/partners/:id
Authorization: Bearer {token}
```

---

### 10. Careers API

#### Get All Job Openings
```http
GET /api/careers/jobs
```

**Query Parameters:**
- `department` (optional): Filter by department
- `location` (optional): Filter by location - `dhaka`, `chittagong`
- `type` (optional): Filter by employment type - `full-time`, `part-time`, `contract`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "job-001",
      "title": "Senior Electrical Engineer",
      "department": "Engineering",
      "location": "Dhaka",
      "type": "Full-time",
      "experience": "5-8 years",
      "description": "We are looking for an experienced Electrical Engineer...",
      "responsibilities": [
        "Design power distribution systems",
        "Lead project engineering teams",
        "Conduct feasibility studies"
      ],
      "requirements": [
        "BSc in Electrical Engineering",
        "5+ years experience in power sector",
        "Knowledge of IEEE/IEC standards"
      ],
      "benefits": [
        "Competitive salary",
        "Health insurance",
        "Professional development"
      ],
      "salary": "TK 80,000 - 120,000",
      "deadline": "2026-06-30T23:59:59Z",
      "status": "active",
      "postedDate": "2026-05-01T10:00:00Z"
    }
  ]
}
```

#### Get Job by ID
```http
GET /api/careers/jobs/:id
```

#### Submit Job Application
```http
POST /api/careers/jobs/:id/apply
Content-Type: multipart/form-data

fullName: Abdul Karim
email: abdul.karim@email.com
phone: +880 1712-345678
coverLetter: I am excited to apply...
resume: [file]
```

**Response:**
```json
{
  "success": true,
  "message": "Your application has been submitted successfully.",
  "data": {
    "applicationId": "app-20260506-001",
    "jobTitle": "Senior Electrical Engineer",
    "submittedAt": "2026-05-06T10:30:00Z"
  }
}
```

#### Create Job Opening (Admin)
```http
POST /api/careers/jobs
Authorization: Bearer {token}
```

#### Update Job Opening (Admin)
```http
PUT /api/careers/jobs/:id
Authorization: Bearer {token}
```

#### Delete Job Opening (Admin)
```http
DELETE /api/careers/jobs/:id
Authorization: Bearer {token}
```

---

### 11. Content Management API

#### Get Company Info
```http
GET /api/content/company-info
```

**Response:**
```json
{
  "success": true,
  "data": {
    "company": {
      "name": "Influx Group",
      "tagline": "Leaders in Energy & Infrastructure",
      "founded": 1980,
      "description": "Following the legacy of JRC and Energypac...",
      "mission": {
        "title": "Our Mission",
        "description": "To deliver reliable, innovative, and sustainable energy solutions...",
        "points": [
          "Provide world-class engineering solutions",
          "Foster sustainable development through renewable energy",
          "Build long-term partnerships based on trust and excellence"
        ]
      },
      "vision": {
        "title": "Our Vision",
        "description": "To be the leading energy and infrastructure solutions provider...",
        "points": [
          "Expand regional presence by 2030",
          "Lead in renewable energy adoption",
          "Achieve carbon neutrality in operations"
        ]
      },
      "stats": [
        {
          "value": "45+",
          "label": "Years Experience"
        },
        {
          "value": "15GW",
          "label": "Power Generated"
        },
        {
          "value": "250+",
          "label": "Global Clients"
        },
        {
          "value": "500+",
          "label": "Technical Staff"
        }
      ],
      "timeline": [
        {
          "year": 1980,
          "title": "Foundation",
          "description": "Established as a pioneering electrical engineering company"
        },
        {
          "year": 1995,
          "title": "Expansion",
          "description": "Expanded operations across Bangladesh"
        }
      ],
      "coreValues": [
        {
          "id": "safety",
          "title": "Safety First",
          "icon": "shield-check",
          "description": "We prioritize safety in all operations...",
          "color": "#EF4444"
        }
      ],
      "certifications": [
        {
          "name": "ISO 9001:2015",
          "description": "Quality Management System",
          "issuedBy": "ISO",
          "validUntil": "2027-12-31",
          "certificateUrl": "/downloads/certificates/iso-9001.pdf"
        }
      ]
    }
  }
}
```

#### Get SEO Metadata
```http
GET /api/content/seo/:page
```

**Response:**
```json
{
  "success": true,
  "data": {
    "title": "Influx Group | Leaders in Energy & Infrastructure Solutions Bangladesh",
    "description": "Powering Bangladesh since 1980. Leading EPC contractor...",
    "keywords": "Influx Group, power engineering Bangladesh, EPC contractor...",
    "og": {
      "title": "Influx Group - Energy & Infrastructure Solutions",
      "description": "Leading energy and infrastructure solutions provider...",
      "image": "https://influxgroup.com/images/og-home.jpg",
      "type": "website",
      "url": "https://influxgroup.com"
    },
    "twitter": {
      "card": "summary_large_image",
      "title": "Influx Group - Energy & Infrastructure Solutions",
      "description": "Leading energy and infrastructure solutions provider...",
      "image": "https://influxgroup.com/images/twitter-home.jpg"
    },
    "canonical": "https://influxgroup.com",
    "robots": "index, follow",
    "schema": {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Influx Group",
      "url": "https://influxgroup.com",
      "logo": "https://influxgroup.com/logo.png",
      "description": "Leading energy and infrastructure solutions provider"
    }
  }
}
```

#### Update Company Info (Admin)
```http
PUT /api/content/company-info
Authorization: Bearer {token}
```

---

### 12. Search API

#### Global Search
```http
GET /api/search?q=transformer&type=all
```

**Query Parameters:**
- `q` (required): Search query string
- `type` (optional): Search type - `all`, `products`, `projects`, `news`, `services`
- `page` (optional): Page number

**Response:**
```json
{
  "success": true,
  "query": "transformer",
  "data": {
    "products": {
      "total": 12,
      "results": [
        {
          "id": "prod-001",
          "type": "product",
          "title": "Power Transformer 250 MVA",
          "category": "Transformers",
          "url": "/products/power-transformer-250-mva",
          "thumbnail": "/images/products/transformer-250mva-thumb.jpg",
          "description": "High-efficiency power transformer for industrial applications"
        }
      ]
    },
    "projects": {
      "total": 5,
      "results": [
        {
          "id": "proj-005",
          "type": "project",
          "title": "Grid Transformer Installation Project",
          "category": "Transmission",
          "url": "/projects/grid-transformer-installation",
          "thumbnail": "/images/projects/grid-transformer-thumb.jpg",
          "description": "Installation of 500kV grid transformers"
        }
      ]
    },
    "news": {
      "total": 3,
      "results": []
    },
    "services": {
      "total": 1,
      "results": []
    },
    "totalResults": 21
  }
}
```

#### Search Suggestions
```http
GET /api/search/suggest?q=pow
```

**Response:**
```json
{
  "success": true,
  "query": "pow",
  "data": {
    "suggestions": [
      {
        "text": "Power Transformer 250 MVA",
        "type": "product",
        "url": "/products/power-transformer-250-mva"
      },
      {
        "text": "Power Distribution Systems",
        "type": "service",
        "url": "/services/power-distribution"
      },
      {
        "text": "Power Plants",
        "type": "category",
        "url": "/projects?category=power"
      }
    ]
  }
}
```

---

### 13. Analytics API

#### Track Page View (Public)
```http
POST /api/analytics/pageview
Content-Type: application/json

{
  "page": "/products",
  "title": "Products - Influx Group",
  "referrer": "https://influxgroup.com",
  "userAgent": "Mozilla/5.0...",
  "sessionId": "sess_12345"
}
```

#### Track Event (Public)
```http
POST /api/analytics/event
Content-Type: application/json

{
  "event": "quote_requested",
  "category": "engagement",
  "label": "Power Transformer 250 MVA",
  "value": 1,
  "page": "/products"
}
```

#### Get Analytics Dashboard (Admin)
```http
GET /api/analytics/dashboard?period=30d
Authorization: Bearer {token}
```

**Query Parameters:**
- `period` (required): Time period - `7d`, `30d`, `90d`, `1y`

**Response:**
```json
{
  "success": true,
  "data": {
    "period": "30d",
    "pageViews": {
      "total": 45230,
      "unique": 28450,
      "trend": "+12.5%"
    },
    "topPages": [
      {
        "page": "/",
        "views": 12500,
        "percentage": 27.6
      },
      {
        "page": "/products",
        "views": 8900,
        "percentage": 19.7
      },
      {
        "page": "/projects",
        "views": 7200,
        "percentage": 15.9
      }
    ],
    "contactForms": {
      "submitted": 145,
      "quoteRequests": 67,
      "jobApplications": 23
    },
    "engagement": {
      "avgSessionDuration": "3m 24s",
      "bounceRate": "42.3%",
      "pagesPerSession": 2.8
    },
    "sources": [
      {
        "source": "Google",
        "visitors": 18500,
        "percentage": 40.9
      },
      {
        "source": "Direct",
        "visitors": 12300,
        "percentage": 27.2
      },
      {
        "source": "LinkedIn",
        "visitors": 5200,
        "percentage": 11.5
      }
    ]
  }
}
```

---

## 📊 Data Models

### Product Model

```typescript
interface Product {
  id: string;
  name: string;
  category: 'transformers' | 'switchgear' | 'renewables' | 'automation';
  description: string;
  specifications: {
    [key: string]: string;
  };
  features: string[];
  image: string;
  brochure?: string;
  createdAt: Date;
  updatedAt: Date;
}
```

### Project Model

```typescript
interface Project {
  id: string;
  title: string;
  location: string;
  capacity: string;
  type: string;
  category: 'power' | 'transmission' | 'renewable' | 'industrial';
  status: 'ongoing' | 'completed' | 'planned';
  completion: string;
  client: string;
  value: string;
  startDate: Date;
  expectedCompletion: Date;
  image: string;
  images: string[];
  scope: string[];
  highlights: string[];
  stats: {
    [key: string]: number | string;
  };
  createdAt: Date;
}
```

### News Model

```typescript
interface NewsArticle {
  id: string;
  title: string;
  category: string;
  categoryLabel: string;
  excerpt: string;
  content: string; // HTML content
  image: string;
  author: {
    name: string;
    role: string;
    photo?: string;
  };
  publishedDate: Date;
  readTime: string;
  featured: boolean;
  tags: string[];
  createdAt: Date;
}
```

### Job Model

```typescript
interface Job {
  id: string;
  title: string;
  department: string;
  location: string;
  type: 'Full-time' | 'Part-time' | 'Contract';
  experience: string;
  description: string;
  responsibilities: string[];
  requirements: string[];
  benefits: string[];
  salary: string;
  deadline: Date;
  status: 'active' | 'closed' | 'draft';
  postedDate: Date;
}
```

---

## ❌ Error Handling

All API responses follow a consistent format for errors:

### Error Response Format

```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Validation failed",
    "details": [
      {
        "field": "email",
        "message": "Email is required"
      }
    ]
  }
}
```

### HTTP Status Codes

- **200 OK** - Request succeeded
- **201 Created** - Resource created successfully
- **400 Bad Request** - Invalid request parameters
- **401 Unauthorized** - Authentication required or invalid
- **403 Forbidden** - Insufficient permissions
- **404 Not Found** - Resource not found
- **422 Unprocessable Entity** - Validation error
- **429 Too Many Requests** - Rate limit exceeded
- **500 Internal Server Error** - Server error

### Common Error Codes

| Code | Description |
|------|-------------|
| `VALIDATION_ERROR` | Request validation failed |
| `UNAUTHORIZED` | Authentication required |
| `FORBIDDEN` | Insufficient permissions |
| `NOT_FOUND` | Resource not found |
| `CONFLICT` | Resource already exists |
| `RATE_LIMIT_EXCEEDED` | Too many requests |
| `SERVER_ERROR` | Internal server error |

---

## ⚡ Rate Limiting

- **Public endpoints**: 100 requests per 15 minutes per IP
- **Authenticated endpoints**: 1000 requests per 15 minutes per user
- **Search endpoints**: 30 requests per minute per IP

Rate limit headers are included in responses:

```http
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1714982400
```

---

## 📮 Postman Collection

### Importing the Collection

1. Open Postman
2. Click "Import" in the top left
3. Select "File" and choose `Influx_Group_API_Collection.postman_collection.json`
4. Click "Import"

### Setting Up Environment Variables

Create a new environment with the following variables:

```json
{
  "baseUrl": "https://api.influxgroup.com",
  "adminToken": "your_jwt_token_here"
}
```

### Using the Collection

1. Select the "Influx Group API" collection
2. Choose the desired endpoint folder (e.g., "Products API")
3. Select a request (e.g., "Get All Products")
4. Click "Send" to execute the request

### Testing Authentication

1. First, execute the "Admin Login" request in the "Authentication API" folder
2. Copy the token from the response
3. Update the `adminToken` variable in your environment
4. Now you can access admin-protected endpoints

---

## 🛠️ Development Guidelines

### Best Practices

1. **Always handle errors gracefully** on the client side
2. **Use pagination** for list endpoints to improve performance
3. **Implement caching** for static content (company info, services, etc.)
4. **Validate all input** data before sending to the API
5. **Use HTTPS only** in production
6. **Implement retry logic** for failed requests
7. **Log API errors** for debugging and monitoring

### Integration Example (Vue.js)

```javascript
// src/services/api.js
import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'https://api.influxgroup.com',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json'
  }
});

// Request interceptor
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('adminToken');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Response interceptor
api.interceptors.response.use(
  (response) => response.data,
  (error) => {
    if (error.response?.status === 401) {
      // Handle unauthorized
      localStorage.removeItem('adminToken');
      window.location.href = '/login';
    }
    return Promise.reject(error.response?.data || error);
  }
);

// API Methods
export const productsAPI = {
  getAll: (params) => api.get('/api/products', { params }),
  getById: (id) => api.get(`/api/products/${id}`),
  getCategories: () => api.get('/api/products/categories'),
  create: (data) => api.post('/api/products', data),
  update: (id, data) => api.put(`/api/products/${id}`, data),
  delete: (id) => api.delete(`/api/products/${id}`)
};

export const projectsAPI = {
  getAll: (params) => api.get('/api/projects', { params }),
  getFeatured: (limit = 4) => api.get('/api/projects/featured', { params: { limit } }),
  getById: (id) => api.get(`/api/projects/${id}`),
  create: (data) => api.post('/api/projects', data),
  update: (id, data) => api.put(`/api/projects/${id}`, data),
  delete: (id) => api.delete(`/api/projects/${id}`)
};

export const contactAPI = {
  submit: (data) => api.post('/api/contact/submit', data),
  requestQuote: (data) => api.post('/api/contact/quote', data),
  getOffices: () => api.get('/api/contact/offices')
};

export const searchAPI = {
  search: (query, type = 'all') => api.get('/api/search', { params: { q: query, type } }),
  suggest: (query) => api.get('/api/search/suggest', { params: { q: query } })
};

export default api;
```

---

## 📝 Support

For API support and questions:
- **Email**: api-support@influxgroup.com
- **Documentation**: https://docs.influxgroup.com/api
- **Status Page**: https://status.influxgroup.com

---

## 📄 License

© 2026 Influx Group. All rights reserved.

---

**Document Version**: 1.0.0
**Last Updated**: May 6, 2026

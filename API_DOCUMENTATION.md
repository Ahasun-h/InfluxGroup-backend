# InfluxGroup Backend API Documentation

## Base URL
```
http://influxgroup-backend.test/api
```

---

## Content APIs

### Products
- `GET /api/products` - Get all products (paginated)
- `GET /api/products/categories` - Get product categories
- `GET /api/products/{slug}` - Get single product by slug

### Projects
- `GET /api/projects` - Get all projects (paginated)
- `GET /api/projects/featured` - Get featured projects
- `GET /api/projects/{slug}` - Get single project by slug

### News & Articles
- `GET /api/news` - Get all news (paginated)
- `GET /api/news/featured` - Get featured news
- `GET /api/news/categories` - Get news categories
- `GET /api/news/{slug}` - Get single article by slug

### Services
- `GET /api/services` - Get all services

### Solutions
- `GET /api/solutions` - Get all solutions

### Testimonials
- `GET /api/testimonials` - Get all testimonials

### Gallery
- `GET /api/gallery` - Get all gallery images
- `GET /api/gallery/categories` - Get gallery categories

### Pages
- `GET /api/pages` - Get all published pages
- `GET /api/pages/{slug}` - Get single page by slug

### Jobs/Careers
- `GET /api/careers/jobs` - Get all active job openings

### Company Info
- `GET /api/content/company-info` - Get company information and full homepage content

---

## CMS Section APIs

### Hero Section
**Endpoint:** `GET /api/cms/hero`

**Response:**
```json
{
  "success": true,
  "data": {
    "badge": "Leaders in Energy & Infrastructure",
    "title": "POWERING BANGLADESH SINCE 1980",
    "description": "From utility-scale power plants to smart grid automation...",
    "primary_cta": {
      "text": "EXPLORE CATALOG",
      "link": "/projects"
    },
    "secondary_cta": {
      "text": "CORPORATE PROFILE",
      "link": "/about"
    },
    "background_image": "/storage/uploads/hero-bg.jpg",
    "seo_attributes": {...},
    "categories": [
      {
        "order": 1,
        "name": "Power Plants",
        "count": "50+ Models",
        "icon": "<svg>...</svg>"
      }
    ]
  }
}
```

### Brand Statements
**Endpoint:** `GET /api/cms/brand-statements`

**Response:**
```json
{
  "success": true,
  "data": {
    "title": "Building Bangladesh's Future",
    "description": "We are the authority in infrastructure development.",
    "image": "/storage/uploads/brand-image.jpg",
    "overlay_title": "35+ YEARS",
    "overlay_text": "Of Excellence",
    "stats": [
      {"number": "500+", "label": "Projects Completed"},
      {"number": "40", "label": "Years Experience"},
      {"number": "150+", "label": "Happy Clients"}
    ]
  }
}
```

### Journey Timeline
**Endpoint:** `GET /api/cms/journey`

**Response:**
```json
{
  "success": true,
  "data": {
    "title": "Our Journey",
    "subtitle": "Building Tomorrow's Infrastructure Today",
    "milestones": [
      {
        "year": "1980",
        "title": "Foundation",
        "description": "Influx Group was established"
      },
      {
        "year": "1995",
        "title": "Expansion",
        "description": "Expanded to power infrastructure"
      }
    ]
  }
}
```

### Mission & Vision
**Endpoint:** `GET /api/cms/mission-vision`

**Response:**
```json
{
  "success": true,
  "data": {
    "mission": {
      "title": "Our Mission",
      "description": "To power Bangladesh's growth...",
      "points": ["Commitment to Excellence", "Sustainable Development"]
    },
    "vision": {
      "title": "Our Vision",
      "description": "To be the leader in infrastructure...",
      "points": ["Industry Leadership", "Global Presence"]
    }
  }
}
```

### Core Values
**Endpoint:** `GET /api/cms/core-values`

**Response:**
```json
{
  "success": true,
  "data": {
    "title": "Core Values",
    "subtitle": "The principles that guide us",
    "values": [
      {
        "title": "Integrity",
        "description": "We maintain the highest ethical standards",
        "icon": "ShieldCheck"
      },
      {
        "title": "Innovation",
        "description": "We embrace cutting-edge technology",
        "icon": "Lightbulb"
      }
    ]
  }
}
```

### Partners
**Endpoint:** `GET /api/cms/partners`

**Response:**
```json
{
  "success": true,
  "data": {
    "title": "Trusted by Industry Leaders",
    "subtitle": "Proud partner to government agencies, multinational corporations, and leading enterprises",
    "partners": [
      {
        "name": "Partner Company Name",
        "logo": "🏢" or "/storage/uploads/partner-logo.png"
      }
    ]
  }
}
```

### Contact CTA
**Endpoint:** `GET /api/cms/contact-cta`

**Response:**
```json
{
  "success": true,
  "data": {
    "title": "Ready to Power Your Success?",
    "description": "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs.",
    "button_text": "Get in Touch",
    "button_link": "/contact"
  }
}
```

### Complete Homepage Content
**Endpoint:** `GET /api/cms/homepage`

**Response:**
```json
{
  "success": true,
  "data": {
    "hero": {...},
    "brand_statements": {...},
    "journey": {...},
    "mission_vision": {...},
    "core_values": {...},
    "partners": {...},
    "contact_cta": {...},
    "headings": {
      "services_title": "Our Services",
      "services_subtitle": "",
      "projects_title": "Featured Projects",
      "projects_subtitle": "",
      "testimonials_title": "What Our Clients Say",
      "testimonials_subtitle": ""
    },
    "stats": {
      "projects_completed": "500+",
      "years_experience": "40",
      "happy_clients": "150",
      "awards_won": "25"
    }
  }
}
```

---

## Admin-Only Endpoints

### Update Homepage Content
**Endpoint:** `POST /api/content/homepage`

**Authentication:** Required ( sanctum token)

**Request Body:**
```json
{
  "hero": {...},
  "brand_statements": {...},
  ...
}
```

---

## Common Response Structure

### Success Response
```json
{
  "success": true,
  "data": {...}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message here"
}
```

### Not Found Response
```json
{
  "success": false,
  "message": "Resource not found"
}
```

---

## Usage Examples

### Fetch Hero Section
```javascript
fetch('http://influxgroup-backend.test/api/cms/hero')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log(data.data);
    }
  });
```

### Fetch Complete Homepage
```javascript
fetch('http://influxgroup-backend.test/api/cms/homepage')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const { hero, brand_statements, journey, mission_vision, core_values, partners, contact_cta } = data.data;
      // Use the data in your frontend
    }
  });
```

### Fetch Featured Projects
```javascript
fetch('http://influxgroup-backend.test/api/projects/featured')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log(data.data);
    }
  });
```

---

## Notes

1. All CMS APIs use the `content_management` table
2. Image URLs are relative paths - prepend with your domain or use `asset()` in Laravel
3. All endpoints are public except admin endpoints which require authentication
4. Pagination is available on list endpoints (products, projects, news)
5. Use `/api/cms/homepage` to get all homepage sections in one request

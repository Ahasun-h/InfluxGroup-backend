# CMS API Quick Reference

## All CMS Section APIs Created

### 1. Hero Section API
**Endpoint:** `GET /api/cms/hero`

Returns:
- Badge text
- Title
- Description
- Primary CTA (text, link)
- Secondary CTA (text, link)
- Background image
- SEO attributes
- Categories (name, count, icon)

---

### 2. Brand Statements API
**Endpoint:** `GET /api/cms/brand-statements`

Returns:
- Title
- Description
- Image
- Overlay title & text
- Stats array (number, label)

---

### 3. Journey Timeline API
**Endpoint:** `GET /api/cms/journey`

Returns:
- Title
- Subtitle
- Milestones array (year, title, description)

---

### 4. Mission & Vision API
**Endpoint:** `GET /api/cms/mission-vision`

Returns:
- Mission (title, description, points)
- Vision (title, description, points)

---

### 5. Core Values API
**Endpoint:** `GET /api/cms/core-values`

Returns:
- Title
- Subtitle
- Values array (title, description, icon)

---

### 6. Partners API
**Endpoint:** `GET /api/cms/partners`

Returns:
- Title
- Subtitle
- Partners array (name, logo - emoji or image path)

---

### 7. Contact CTA API
**Endpoint:** `GET /api/cms/contact-cta`

Returns:
- Title
- Description
- Button text
- Button link

---

### 8. Complete Homepage API
**Endpoint:** `GET /api/cms/homepage`

Returns ALL sections in one request:
- Hero
- Brand statements
- Journey
- Mission & Vision
- Core values
- Partners
- Contact CTA
- Headings (services, projects, testimonials)
- Stats (projects completed, years experience, happy clients, awards won)

---

## Usage Examples

### Vue.js / Frontend Integration

```javascript
// Fetch single section
const { data } = await axios.get('/api/cms/hero')
console.log(data.data)

// Fetch complete homepage
const { data } = await axios.get('/api/cms/homepage')
const { hero, brand_statements, journey, mission_vision, core_values, partners, contact_cta } = data.data
```

### React Example

```javascript
import { useState, useEffect } from 'react'

function HomePage() {
  const [content, setContent] = useState(null)

  useEffect(() => {
    fetch('/api/cms/homepage')
      .then(res => res.json())
      .then(data => setContent(data.data))
  }, [])

  if (!content) return <div>Loading...</div>

  return (
    <div>
      <h1>{content.hero.title}</h1>
      <p>{content.hero.description}</p>
      {/* Render other sections */}
    </div>
  )
}
```

---

## All API Endpoints Summary

### Content APIs
- `/api/products` - Get products
- `/api/projects` - Get projects
- `/api/news` - Get news
- `/api/services` - Get services
- `/api/testimonials` - Get testimonials
- `/api/partners` - Get partners (CMS version)
- `/api/careers/jobs` - Get job openings
- `/api/pages` - Get pages

### CMS APIs
- `/api/cms/hero` - Hero section
- `/api/cms/brand-statements` - Brand statements
- `/api/cms/journey` - Journey timeline
- `/api/cms/mission-vision` - Mission & vision
- `/api/cms/core-values` - Core values
- `/api/cms/partners` - Partners section
- `/api/cms/contact-cta` - Contact CTA section
- `/api/cms/homepage` - **Complete homepage** (all sections)

---

## Response Format

All APIs return JSON in this format:

```json
{
  "success": true,
  "data": {
    // Your data here
  }
}
```

Error response:

```json
{
  "success": false,
  "message": "Error message"
}
```

---

## Notes

1. All CMS APIs use `content_management` table
2. Image paths are relative - use `asset()` or prepend domain
3. No authentication required for public endpoints
4. All endpoints are CORS-enabled for frontend access
5. Use `/api/cms/homepage` for best performance (one request instead of 8)

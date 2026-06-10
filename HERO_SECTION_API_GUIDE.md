# Hero Section API Implementation Guide

## Overview
This guide explains how to implement and use the `/api/cms/hero` API endpoint to dynamically update the Hero Section on the homepage.

---

## API Response Structure

### Expected JSON Response

```json
{
  "success": true,
  "data": {
    "id": 1,
    "background_image": "/uploads/hero-bg-2024.jpg",
    "subtitle": "Leaders in Energy",
    "title": "POWERING BANGLADESH",
    "description": "From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.",
    "cta_text": "EXPLORE CATALOG",
    "cta_link": "/projects",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-06-11T14:25:00.000000Z"
  }
}
```

### Field Descriptions

| Field | Type | Required | Description | Example |
|-------|------|----------|-------------|---------|
| `id` | integer | Yes | Unique identifier for the hero section | `1` |
| `background_image` | string | Yes | Path or URL to hero background image | `/uploads/hero-bg.jpg` |
| `subtitle` | string | Yes | Small subtitle above the main title | `"Leaders in Energy"` |
| `title` | string | Yes | Main hero heading (uppercase) | `"POWERING BANGLADESH"` |
| `description` | string | Yes | Hero description paragraph | `"From utility-scale..."` |
| `cta_text` | string | Yes | Primary CTA button text | `"EXPLORE CATALOG"` |
| `cta_link` | string | Yes | Primary CTA button URL | `"/projects"` |
| `created_at` | datetime | Auto | Creation timestamp | `"2024-01-15T10:30:00Z"` |
| `updated_at` | datetime | Auto | Last update timestamp | `"2024-06-11T14:25:00Z"` |

---

## Frontend Usage (Already Implemented)

### Component: `src/pages/Home.vue`

The Hero Section now uses the API data with fallbacks:

```vue
<!-- Background Image -->
<img
  :src="getImageUrl(heroData?.background_image || homepageData?.hero?.background_image || '/hero.png')"
  alt="Power Infrastructure"
/>

<!-- Subtitle -->
<span>{{ heroData?.subtitle || homepageData?.hero?.subtitle || 'Leaders in Energy' }}</span>

<!-- Title -->
<h1>{{ heroData?.title || homepageData?.hero?.title || 'POWERING BANGLADESH' }}</h1>

<!-- Description -->
<p>{{ heroData?.description || homepageData?.hero?.description || 'Default description...' }}</p>

<!-- CTA Button -->
<a :href="heroData?.cta_link || homepageData?.hero?.cta_link || '/projects'">
  {{ heroData?.cta_text || homepageData?.hero?.cta_text || 'EXPLORE CATALOG' }}
</a>
```

### Data Fetching

```javascript
import { heroService } from '../services/content'

const heroData = ref(null)

const fetchHeroData = async () => {
  try {
    const data = await heroService.getHeroData()
    heroData.value = data
  } catch (error) {
    console.error('Failed to fetch hero data:', error)
  }
}

onMounted(() => {
  fetchHeroData()
})
```

---

## Backend Implementation (Laravel/PHP)

### Database Migration

```php
// database/migrations/2024_01_01_create_hero_section_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('background_image');
            $table->string('subtitle');
            $table->string('title');
            $text('description');
            $table->string('cta_text');
            $table->string('cta_link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_sections');
    }
};
```

### Model

```php
// app/Models/HeroSection.php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_image',
        'subtitle',
        'title',
        'description',
        'cta_text',
        'cta_link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active hero section
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
```

### Controller

```php
// app/Http/Controllers/CMS/HeroController.php

<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HeroController extends Controller
{
    /**
     * Get the active hero section
     * GET /api/cms/hero
     */
    public function index()
    {
        $hero = HeroSection::active()->first();

        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'No active hero section found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hero
        ]);
    }

    /**
     * Store/Update hero section
     * POST /api/cms/hero
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'background_image' => 'required|string',
            'subtitle' => 'required|string|max:100',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:500',
            'cta_text' => 'required|string|max:50',
            'cta_link' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Deactivate all existing heroes
        HeroSection::query()->update(['is_active' => false]);

        // Create or update hero section
        $hero = HeroSection::updateOrCreate(
            ['id' => $request->id ?? null],
            [
                'background_image' => $request->background_image,
                'subtitle' => $request->subtitle,
                'title' => $request->title,
                'description' => $request->description,
                'cta_text' => $request->cta_text,
                'cta_link' => $request->cta_link,
                'is_active' => $request->is_active ?? true,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $hero,
            'message' => 'Hero section updated successfully'
        ]);
    }

    /**
     * Upload hero background image
     * POST /api/cms/hero/upload-image
     */
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $path = $request->file('image')->store('hero-section', 'public');
        $url = Storage::url($path);

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url' => $url
            ]
        ]);
    }

    /**
     * Get all hero sections (admin)
     * GET /api/cms/hero/all
     */
    public function all()
    {
        $heroes = HeroSection::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $heroes
        ]);
    }

    /**
     * Delete hero section
     * DELETE /api/cms/hero/{id}
     */
    public function destroy($id)
    {
        $hero = HeroSection::find($id);

        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Hero section not found'
            ], 404);
        }

        // Delete image file
        if ($hero->background_image) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $hero->background_image));
        }

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero section deleted successfully'
        ]);
    }
}
```

### API Routes

```php
// routes/api.php

// Hero Section Routes (CMS)
Route::prefix('cms')->group(function () {
    // Get active hero section (public)
    Route::get('/hero', [HeroController::class, 'index']);

    // Admin routes (protected by authentication)
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/hero', [HeroController::class, 'store']);
        Route::post('/hero/upload-image', [HeroController::class, 'uploadImage']);
        Route::get('/hero/all', [HeroController::class, 'all']);
        Route::delete('/hero/{id}', [HeroController::class, 'destroy']);
    });
});
```

---

## How to Update Hero Section

### Method 1: Using API Endpoint

#### 1. Upload Background Image First

```bash
curl -X POST http://influx-group.test/api/cms/hero/upload-image \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "image=@/path/to/your/image.jpg"
```

**Response:**
```json
{
  "success": true,
  "data": {
    "path": "hero-section/abc123.jpg",
    "url": "/storage/hero-section/abc123.jpg"
  }
}
```

#### 2. Update Hero Section

```bash
curl -X POST http://influx-group.test/api/cms/hero \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "background_image": "/storage/hero-section/abc123.jpg",
    "subtitle": "Leaders in Energy",
    "title": "POWERING BANGLADESH",
    "description": "Your description here",
    "cta_text": "EXPLORE CATALOG",
    "cta_link": "/projects",
    "is_active": true
  }'
```

### Method 2: Using Admin Panel (if available)

1. Navigate to CMS > Hero Section
2. Click "Upload Image" to upload background image
3. Fill in the form fields:
   - **Subtitle**: Short text above title (max 100 chars)
   - **Title**: Main heading (max 200 chars)
   - **Description**: Paragraph text (max 500 chars)
   - **CTA Text**: Button text (max 50 chars)
   - **CTA Link**: Button URL path
4. Click "Save" to update

### Method 3: Using Database Seeder (for initial setup)

```php
// database/seeders/HeroSectionSeeder.php

<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    public function run()
    {
        HeroSection::create([
            'background_image' => '/storage/hero-section/default-hero.jpg',
            'subtitle' => 'Leaders in Energy',
            'title' => 'POWERING BANGLADESH',
            'description' => 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
            'cta_text' => 'EXPLORE CATALOG',
            'cta_link' => '/projects',
            'is_active' => true,
        ]);
    }
}
```

---

## Image Specifications

### Recommended Image Properties

| Property | Value |
|----------|-------|
| **Format** | JPG, PNG, WebP |
| **Max Size** | 5MB |
| **Recommended Dimensions** | 1920x1080px (16:9) |
| **Minimum Dimensions** | 1280x720px |
| **Aspect Ratio** | 16:9 or similar |

### Image Content Guidelines

- **Subject**: Power infrastructure, industrial facilities, energy equipment
- **Style**: Professional, high-quality, good lighting
- **Colors**: Industrial tones (blues, grays, metallic)
- **Composition**: Subject should be centered or right-aligned (text overlay on left)
- **Brightness**: Medium to allow text readability with overlay

---

## Testing the API

### Test GET Request (Public)

```bash
curl -X GET http://influx-group.test/api/cms/hero
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "background_image": "/storage/hero-section/hero-bg.jpg",
    "subtitle": "Leaders in Energy",
    "title": "POWERING BANGLADESH",
    "description": "From utility-scale power plants...",
    "cta_text": "EXPLORE CATALOG",
    "cta_link": "/projects",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-06-11T14:25:00.000000Z"
  }
}
```

### Test POST Request (Admin)

```bash
curl -X POST http://influx-group.test/api/cms/hero \
  -H "Authorization: Bearer YOUR_ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "background_image": "/storage/hero-section/new-bg.jpg",
    "subtitle": "New Subtitle",
    "title": "NEW TITLE",
    "description": "New description text",
    "cta_text": "CLICK HERE",
    "cta_link": "/contact"
  }'
```

---

## Troubleshooting

### Common Issues

#### 1. Image Not Displaying
**Problem**: Image path is correct but not showing
**Solution**: Ensure the storage link is created: `php artisan storage:link`

#### 2. API Returns 404
**Problem**: `GET /api/cms/hero` returns 404
**Solution**: Check if a hero section exists with `is_active = true`

#### 3. CORS Errors
**Problem**: Frontend cannot access API
**Solution**: Add CORS middleware or configure `config/cors.php`

#### 4. Validation Errors
**Problem**: POST request fails with validation errors
**Solution**: Check field lengths match the validation rules

---

## Security Considerations

1. **Authentication**: Admin endpoints should be protected
2. **File Upload**: Validate file types and sizes
3. **XSS Prevention**: Sanitize text inputs (Laravel does this by default)
4. **Rate Limiting**: Implement rate limiting on upload endpoints
5. **Storage**: Use `storage:link` instead of public uploads

---

## Summary Checklist

- [ ] Create database migration
- [ ] Create HeroSection model
- [ ] Create HeroController
- [ ] Add API routes
- [ ] Run migrations: `php artisan migrate`
- [ ] Run seeder: `php artisan db:seed --class=HeroSectionSeeder`
- [ ] Create storage link: `php artisan storage:link`
- [ ] Test GET endpoint
- [ ] Test POST endpoint
- [ ] Test image upload
- [ ] Verify frontend displays data correctly

---

## Additional Resources

- Laravel API Documentation: https://laravel.com/docs/api
- Vue.js Composition API: https://vuejs.org/guide/extras/composition-api-faq.html
- Image Optimization: Use `spatie/laravel-image-optimizer` package

---

**Note**: This implementation assumes a Laravel backend. Adjust according to your backend framework.

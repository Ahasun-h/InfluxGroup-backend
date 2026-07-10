# Vue Analytics Tracking Integration

## Overview
This analytics system tracks user visits to your Vue frontend and displays the data in the Laravel admin backend at `/admin/analytics/website`.

## Architecture

### Backend (Laravel)
- **API Endpoint**: `POST /api/analytics/track`
- **Controller**: `App\Http\Controllers\Api\AnalyticsTrackingController.php`
- **Models**: `Visitor`, `PageView`
- **Admin Dashboard**: `/admin/analytics/website`

### Frontend (Vue)
- **Tracking Service**: `src/services/analyticsTracking.js`
- **Vue Composable**: `src/composables/useAnalytics.js`
- **Integration**: `src/App.vue` (automatic tracking)

## How It Works

### 1. Session Management
- Each user gets a unique session ID stored in localStorage
- Session ID persists across browser sessions
- Session format: `vue_timestamp_randomstring`

### 2. Data Collection
When users visit pages in your Vue app, the following data is collected:
- **Session ID**: Unique identifier for the user session
- **URL**: Current page path
- **Title**: Page title
- **Referer**: Previous page (if available)
- **User Agent**: Browser and device information
- **IP Address**: User's IP address
- **Timestamp**: When the visit occurred

### 3. Automatic Tracking
The system automatically tracks:
- Initial page load
- All route changes
- Page titles and URLs

## Usage Examples

### Basic Automatic Tracking (Already Implemented)
```vue
<!-- src/App.vue -->
<script setup>
import analyticsTracking from './services/analyticsTracking'

// Automatic tracking is already implemented
// No additional code needed for basic functionality
</script>
```

### Manual Tracking in Components
```vue
<script setup>
import { useAnalytics } from '@/composables/useAnalytics'

const { trackPageView, setTrackingEnabled } = useAnalytics()

// Track custom event
function trackCustomAction() {
  trackPageView('/custom-action', 'Custom Action')
}

// Disable tracking for specific pages
setTrackingEnabled(false)
</script>
```

### Tracking Service Direct Usage
```javascript
import analyticsTracking from '@/services/analyticsTracking'

// Track specific page
analyticsTracking.trackPageView('/products', 'Products Page')

// Disable tracking temporarily
analyticsTracking.setTracking(false)

// Reset session (creates new visitor)
analyticsTracking.resetSession()

// Get session info
const info = analyticsTracking.getSessionInfo()
console.log(info)
```

## Configuration

### API Configuration
Update `src/config/api.js` if needed:
```javascript
export const API_CONFIG = {
  baseURL: 'http://your-backend-domain/api', // Update this
  timeout: 10000,
}
```

### Environment Variables
Create `.env` file in Vue project:
```
VITE_API_URL=http://influxgroup-backend.test/api
```

## Viewing Analytics Data

### Admin Dashboard
Access the analytics dashboard at:
- **Main Dashboard**: `/admin/analytics`
- **Website Analytics**: `/admin/analytics/website`
- **Business Analytics**: `/admin/analytics/business`
- **Content Analytics**: `/admin/analytics/content`

### Data Available
- **Unique Visitors**: Number of distinct users
- **Page Views**: Total page views
- **Returning Visitors**: Users who visited multiple times
- **Top Pages**: Most visited pages
- **Traffic Sources**: Where users came from
- **Device Types**: Desktop, mobile, tablet
- **Browsers**: Chrome, Firefox, Safari, etc.

## Testing

### Test Page
Access the test page at:
```
http://influxgroup-backend.test/test-vue-analytics.html
```

### Manual Testing
```bash
# Start Laravel backend
php artisan serve

# Start Vue frontend
cd InfluxGroup
npm run dev

# Visit pages in Vue app
# Check /admin/analytics/website for data
```

### API Testing
```bash
# Test the tracking endpoint directly
curl -X POST http://influxgroup-backend.test/api/analytics/track \
  -H "Content-Type: application/json" \
  -d '{
    "session_id": "test_session_123",
    "url": "/test-page",
    "title": "Test Page",
    "referer": null,
    "user_agent": "Mozilla/5.0"
  }'
```

## Features

### Automatic Features
- ✅ Session management
- ✅ Route change tracking
- ✅ Device/browser detection
- ✅ Error handling and retry
- ✅ Request batching
- ✅ LocalStorage persistence

### Advanced Features
- Disable tracking for specific users/regions
- Custom event tracking
- Session reset functionality
- Queue management for failed requests

## Troubleshooting

### No Data Showing
1. Check API configuration in `src/config/api.js`
2. Verify Laravel backend is running
3. Check browser console for errors
4. Verify session ID in localStorage

### API Errors
1. Check CORS settings in Laravel
2. Verify API endpoint is accessible
3. Check Laravel logs: `storage/logs/laravel.log`
4. Test API endpoint manually

### Session Issues
1. Clear localStorage
2. Check browser privacy settings
3. Verify localStorage is enabled

## Performance Considerations

### Optimization
- Tracking requests are batched
- Failed requests are retried
- Minimal impact on page performance
- Asynchronous non-blocking calls

### Best Practices
- Don't track sensitive pages (admin, login)
- Implement rate limiting if needed
- Consider privacy implications
- Provide opt-out mechanism

## Security Considerations

### Data Protection
- No personal data collected automatically
- IP addresses logged for analytics only
- User agents contain device info only
- Sessions are anonymous

### Recommendations
- Implement data retention policies
- Consider GDPR compliance
- Provide privacy policy
- Allow users to opt-out

## Files Created

### Backend Files
- `app/Http/Controllers/Api/AnalyticsTrackingController.php`
- `routes/api.php` (updated)
- `public/test-vue-analytics.html`

### Frontend Files
- `src/services/analyticsTracking.js`
- `src/composables/useAnalytics.js`
- `src/App.vue` (updated)
- `src/config/api.js` (referenced)

## Next Steps

1. ✅ Analytics tracking is fully implemented
2. ✅ Test page available for verification
3. ✅ Admin dashboard ready to display data
4. ✅ Automatic tracking enabled in Vue app

**Start using:**
1. Visit your Vue application
2. Navigate between pages
3. Check `/admin/analytics/website` for collected data

**Customization:**
- Add custom event tracking
- Implement user opt-out
- Add custom dimensions
- Create custom reports
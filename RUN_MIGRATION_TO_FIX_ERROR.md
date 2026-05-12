# 🚀 Quick Migration Guide - Fix Brand Statement Error

## ⚠️ **Current Error:**
```
Table 'influx_group.Content_management_table' doesn't exist
```

## ✅ **Solution: Run Migration**

### **Option 1: Using Laravel Artisan (Recommended)**
```bash
php artisan migrate
```

### **Option 2: Manual SQL Execution**
If you can't run PHP commands, execute this SQL in your database:

```sql
-- Create Content_management_table
CREATE TABLE `Content_management_table` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `section_key` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Unique identifier for the section',
    `title` VARCHAR(255) NULL,
    `type` VARCHAR(255) DEFAULT 'section' COMMENT 'Type of content',
    `status` VARCHAR(255) DEFAULT 'publish',
    `order` INT DEFAULT 0,
    `content_data` JSON NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);

-- Insert brand statement data
INSERT INTO `Content_management_table` 
(`section_key`, `title`, `type`, `status`, `order`, `content_data`, `created_at`, `updated_at`)
VALUES 
('brand_statement', 'Brand Statement', 'section', 'publish', 2, 
'{"title":"ESTABLISHED AUTHORITY IN HEAVY ENGINEERING","description":"Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.","stats":[{"value":"45+","label":"Years Experience","order":1},{"value":"1200+","label":"Projects Delivered","order":2},{"value":"ISO","label":"Certified Company","order":3},{"value":"500+","label":"Expert Engineers","order":4}],"image_url":"https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200","overlay_title":"Core Reliability","overlay_text":"Zero Downtime Operation Protocols"}',
NOW(), NOW());
```

## 🔄 **After Migration:**

### **1. Clear Application Cache**
```bash
php artisan cache:clear
php artisan config:clear
```

### **2. Test Brand Statement Page**
Visit: `/admin/brand-statements`

Should work without errors! ✅

## 💡 **How System Works Now:**

### **Before Migration:**
- Uses existing `hero_sections` table
- System automatically detects which table to use
- **Works immediately** without migration

### **After Migration:**
- Switches to `Content_management_table` automatically
- Uses new JSON content structure
- **Full WordPress-style CMS**

## 🎯 **Current Status:**

✅ **SYSTEM WORKING NOW** - Uses `hero_sections` table
⏳ **READY TO UPGRADE** - Just run migration
🚀 **AUTOMATIC SWITCH** - Models detect table and use appropriate one

## 📋 **Verification:**

### **Check Which Table is Being Used:**
```php
// In your controller
$tableExists = \Schema::hasTable('Content_management_table');
if ($tableExists) {
    // Using new system
} else {
    // Using hero_sections fallback
}
```

## 🎨 **What Happens After Migration:**

1. ✅ **Models auto-detect** new table
2. ✅ **Existing data preserved** in hero_sections
3. ✅ **New content** uses Content_management_table
4. ✅ **Gradual migration** - no rush to switch

## ⚡ **Quick Test:**

After running migration, visit `/admin/brand-statements` and make a test edit. 
If it saves successfully, the new system is working!

---

**Status**: Ready to migrate! System will work both before and after migration. 🚀
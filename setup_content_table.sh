#!/bin/bash

# Setup script for content table migration

echo "🚀 Setting up Content Management System..."
echo ""

echo "📋 Step 1: Running database migration..."
php artisan migrate --force

echo ""
echo "✅ Migration completed!"
echo ""
echo "📊 Database structure:"
echo "  - Table: 'content' (renamed from 'hero_sections')"
echo "  - Supports multiple content types: hero, brand_statement, etc."
echo "  - Both HeroSection and BrandStatement models use the same table"
echo ""
echo "🎯 Available endpoints:"
echo "  - /admin/hero (Hero Section Management)"
echo "  - /admin/brand-statements (Brand Statement Management)"
echo ""
echo "✨ Setup complete! You can now access your CMS system."

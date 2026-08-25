<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;

class PagesCmsController extends Controller
{
    // ── Products Page ────────────────────────────────────────────────────

    public function getProductsHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'products_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'products_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['products_hero_badge']->section_content       ?? 'Our Products',
                'title'       => $items['products_hero_title']->section_content       ?? 'ENGINEERING <span class="text-industrial-blue">EXCELLENCE</span>',
                'description' => $items['products_hero_description']->section_content ?? 'Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.',
            ]
        ]);
    }

    // ── Projects Page ────────────────────────────────────────────────────

    public function getProjectsHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'projects_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'projects_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['projects_hero_badge']->section_content       ?? 'Our Projects',
                'title'       => $items['projects_hero_title']->section_content       ?? 'BUILDING <span class="text-industrial-blue">BANGLADESH</span>',
                'description' => $items['projects_hero_description']->section_content ?? 'From mega power projects to renewable energy installations, we deliver engineering excellence that powers the nation.',
            ]
        ]);
    }

    // ── Services & Solutions Page ────────────────────────────────────────

    public function getServicesHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'services_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'services_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['services_hero_badge']->section_content       ?? 'What We Offer',
                'title'       => $items['services_hero_title']->section_content       ?? 'SERVICES &amp; <span class="text-industrial-blue">SOLUTIONS</span>',
                'description' => $items['services_hero_description']->section_content ?? 'Comprehensive engineering services and tailored solutions from concept to commissioning, ensuring your power infrastructure operates at peak performance.',
            ]
        ]);
    }

    // ── News Page ────────────────────────────────────────────────────────

    public function getNewsHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'news_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'news_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['news_hero_badge']->section_content       ?? 'News & Updates',
                'title'       => $items['news_hero_title']->section_content       ?? 'LATEST <span class="text-industrial-blue">NEWS</span>',
                'description' => $items['news_hero_description']->section_content ?? 'Stay updated with the latest developments, achievements, and insights from Influx Group.',
            ]
        ]);
    }

    // ── Career Opportunities Page ───────────────────────────────────────

    public function getCareerHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'career_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'career_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['career_hero_badge']->section_content       ?? 'Join Our Team',
                'title'       => $items['career_hero_title']->section_content       ?? 'Career <span class="text-industrial-blue">Opportunities</span>',
                'description' => $items['career_hero_description']->section_content ?? 'Build your career with Bangladesh\'s leading engineering conglomerate. Join our team of professionals powering the nation\'s infrastructure development.',
                'stat1_value' => $items['career_hero_stat1_value']->section_content ?? '45+',
                'stat1_label' => $items['career_hero_stat1_label']->section_content ?? 'Years of Excellence',
                'stat2_value' => $items['career_hero_stat2_value']->section_content ?? '500+',
                'stat2_label' => $items['career_hero_stat2_label']->section_content ?? 'Technical Professionals',
                'stat3_value' => $items['career_hero_stat3_value']->section_content ?? '15+',
                'stat3_label' => $items['career_hero_stat3_label']->section_content ?? 'Current Openings',
            ]
        ]);
    }

    public function getCareerContactCtaSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'career_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'career_contact_cta')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['career_cta_badge']->section_content       ?? 'Don\'t See a Matching Role?',
                'title'       => $items['career_cta_title']->section_content       ?? 'Send Your <span class="text-industrial-blue">Resume</span>',
                'description' => $items['career_cta_description']->section_content ?? 'We are always looking for talented engineers and professionals. Send us your CV and we will keep you in mind for future opportunities.',
                'email'       => $items['career_cta_email']->section_content       ?? 'careers@influxgroup.com',
                'phone'       => $items['career_cta_phone']->section_content       ?? '+880 2 987 6543',
                'address'     => $items['career_cta_address']->section_content     ?? 'Head Office: Dhaka, Bangladesh',
            ]
        ]);
    }
}

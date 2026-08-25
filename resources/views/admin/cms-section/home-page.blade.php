<x-layouts.cms_app title="CMS Admin - Home Page" :cmsData="$cmsData">
    <x-slot:styles>

    </x-slot:styles>

    @php
        // Helper function to check if logo is an emoji
        if (!function_exists('isEmojiLogo')) {
            function isEmojiLogo($logo) {
                if (empty($logo)) return false;
                // Check if it contains emoji characters using a simpler pattern
                return preg_match('/[\x{1F300}-\x{1F9FF}]/u', $logo) ||
                       preg_match('/[\x{2600}-\x{26FF}]/u', $logo) ||
                       preg_match('/[\x{2700}-\x{27BF}]/u', $logo);
            }
        }

        // Helper function to check if logo is an image URL
        if (!function_exists('isImageLogo')) {
            function isImageLogo($logo) {
                if (empty($logo)) return false;
                // Check if it's a URL (not an emoji)
                return !isEmojiLogo($logo) && (filter_var($logo, FILTER_VALIDATE_URL) || str_starts_with($logo, '/'));
            }
        }
    @endphp

    <!-- Left Sidebar with Collapsible Forms -->
    <aside class="cms-sidebar">
        <div class="cms-sidebar-header">
            <div class="cms-sidebar-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                CMS Admin
            </div>
            <div class="cms-sidebar-subtitle">Home Page Sections</div>
        </div>

        <nav>
            <!-- Hero Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('hero')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Hero Section
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="hero-content">
                    <div class="alert" id="alert-hero-success" class="alert-success">
                        <strong>Success!</strong> Hero section saved successfully.
                    </div>
                    <div class="alert" id="alert-hero-error" class="alert-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="hero-form" class="cms-form" onsubmit="saveSection(event, 'hero')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Badge Text</label>
                            <input type="text" name="badge" class="cms-form-input" value="{{ $cmsData['hero']['items']['hero_section_badge_text']->section_content ?? 'Leaders in Energy & Infrastructure' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['hero']['items']['hero_section_title']->section_content ?? 'POWERING BANGLADESH SINCE 1980' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['hero']['items']['hero_section_description']->section_content ?? 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.' }}</textarea>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Primary CTA Button Text</label>
                            <input type="text" name="cta_button_text" class="cms-form-input" value="{{ $cmsData['hero']['items']['hero_section_primary_cta_text']->section_content ?? 'EXPLORE CATALOG' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Primary CTA Button Link</label>
                            <input type="text" name="cta_button_link" class="cms-form-input" value="{{ $cmsData['hero']['items']['hero_section_primary_cta_link']->section_content ?? '/projects' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Secondary CTA Button Text</label>
                            <input type="text" name="secondary_button_text" class="cms-form-input" value="{{ $cmsData['hero']['items']['hero_section_secondary_cta_text']->section_content ?? 'CORPORATE PROFILE' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Secondary CTA Button Link</label>
                            <input type="text" name="secondary_button_link" class="cms-form-input" value="{{ $cmsData['hero']['items']['hero_section_secondary_cta_link']->section_content ?? '/about' }}">
                        </div>

                        <!-- Background Image Section -->
                        <div class="form-subtitle">Background Image</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Background Image</label>
                            @php
                                $bgImage = null;
                                if (isset($cmsData['hero']['items']['hero_section_Background']) && $cmsData['hero']['items']['hero_section_Background']->media_files) {
                                    $mediaFiles = json_decode($cmsData['hero']['items']['hero_section_Background']->media_files, true);
                                    $bgImage = $mediaFiles['source_file'] ?? null;
                                }
                            @endphp

                            <input type="file"
                                   name="background_image_dropify"
                                   id="background_image_dropify"
                                   class="dropify"
                                   accept="image/*"
                                   data-default-file="{{ $bgImage ? asset($bgImage) : '' }}"
                                   data-max-width="3000"
                                   data-max-height="3000"
                                   data-show-remove="true"
                                   data-show-errors="true">

                            <input type="hidden" name="background_image" id="background_image_url" value="{{ $bgImage ?? '' }}">
                            <input type="hidden" name="seo_attributes" id="seo_attributes_value" value="{{ $cmsData['hero']['items']['hero_section_Background']->attributes ?? '' }}">

                            <div style="margin-top: 0.75rem;">
                                <label class="cms-form-label" style="font-size: 0.7rem; color: #64748b;">Or Enter Image URL</label>
                                <input type="text"
                                       id="background_url_input"
                                       value="{{ $bgImage ? asset($bgImage) : '' }}"
                                       class="cms-form-input"
                                       style="font-size: 0.8rem; padding: 0.5rem 0.75rem;"
                                       placeholder="/uploads/hero/image.jpg">
                            </div>

                            <div style="margin-top: 0.75rem;">
                                <label class="cms-form-label" style="font-size: 0.7rem; color: #64748b;">SEO Attributes (JSON)</label>
                                <input type="text"
                                       id="seo_attributes_input"
                                       value="{{ $cmsData['hero']['items']['hero_section_Background']->attributes ?? '' }}"
                                       class="cms-form-input"
                                       style="font-size: 0.8rem; padding: 0.5rem 0.75rem;"
                                       placeholder='{"alt": "Hero background"}'>
                            </div>
                        </div>

                        <div class="form-subtitle">Hero Categories</div>

                        @foreach($cmsData['hero']['categories'] as $index => $category)
                            <div class="cms-category-item">
                                <div class="cms-category-header">
                                    <div class="cms-icon-preview">
                                        {!! $category['icon'] !!}
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Category {{ $index + 1 }} Name</label>
                                            <input type="text" name="cat{{ $category['order'] }}_name" class="cms-form-input" value="{{ $category['name'] }}">
                                        </div>
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Category {{ $index + 1 }} Count</label>
                                            <input type="text" name="cat{{ $category['order'] }}_count" class="cms-form-input" value="{{ $category['count'] }}">
                                        </div>
                                        <input type="hidden" name="cat{{ $category['order'] }}_icon" value="{{ $category['icon'] }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="cms-btn cms-btn-success">Save Hero Section</button>
                    </form>
                </div>
            </div>

            <!-- Brand Statements -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('brand-statements')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Brand Statements
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="brand-statements-content">
                    <div class="alert" id="alert-brand-statements-success"></div>
                    <div class="alert" id="alert-brand-statements-error"></div>

                    <form id="brand-form" class="cms-form" onsubmit="saveSection(event, 'brand-statements')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['brandStatements']['items']['brand_statements_title']->section_content ?? 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['brandStatements']['items']['brand_statements_description']->section_content ?? 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.' }}</textarea>
                        </div>

                        <!-- Image Upload Section -->
                        <div class="form-subtitle">Brand Image</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Image Upload</label>
                            @php
                                $brandImage = null;
                                if (isset($cmsData['brandStatements']['items']['brand_statements_image']) && $cmsData['brandStatements']['items']['brand_statements_image']->section_content) {
                                    $brandImage = $cmsData['brandStatements']['items']['brand_statements_image']->section_content;
                                }
                            @endphp

                            <input type="file"
                                   name="brand_image_dropify"
                                   id="brand_image_dropify"
                                   class="dropify-brand"
                                   accept="image/*"
                                   data-default-file="{{ $brandImage ? asset($brandImage) : '' }}"
                                   data-max-width="3000"
                                   data-max-height="3000"
                                   data-show-remove="true"
                                   data-show-errors="true">

                            <input type="hidden" name="image_url" id="brand_image_url" value="{{ $brandImage ?? '' }}">
                            <input type="text" id="brand_url_input" value="{{ $brandImage ? asset($brandImage) : '' }}" class="cms-form-input" style="margin-top: 0.5rem;" placeholder="Or enter image URL">
                        </div>

                        <!-- Overlay Text -->
                        <div class="form-subtitle">Overlay Text</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Overlay Title</label>
                            <input type="text" name="overlay_title" class="cms-form-input" value="{{ $cmsData['brandStatements']['items']['brand_statements_overlay_title']->section_content ?? '' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Overlay Text</label>
                            <textarea name="overlay_text" class="cms-form-textarea">{{ $cmsData['brandStatements']['items']['brand_statements_overlay_text']->section_content ?? '' }}</textarea>
                        </div>

                        <!-- Statistics Section -->
                        <div class="form-subtitle">Brand Statistics</div>

                        @php
                            $brandStats = $cmsData['brandStatements']['stats'] ?? collect([]);
                            $hasStats = $brandStats && $brandStats->count() > 0;
                        @endphp

                        @if($hasStats)
                            @foreach($brandStats as $index => $stat)
                                <div class="cms-category-item" style="background: #0f172a; border-color: #334155;">
                                    <div style="flex: 1;">
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Stat {{ $index + 1 }} Value</label>
                                            <input type="text" name="stat{{ $stat['order'] ?? ($index + 1) }}_value" class="cms-form-input" value="{{ $stat['value'] ?? '' }}">
                                        </div>
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Stat {{ $index + 1 }} Label</label>
                                            <input type="text" name="stat{{ $stat['order'] ?? ($index + 1) }}_label" class="cms-form-input" value="{{ $stat['label'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="color: #94a3b8; font-size: 0.875rem; text-align: center; padding: 1rem;">
                                No statistics found. Creating default fields...
                            </div>
                            @for($i = 1; $i <= 4; $i++)
                                <div class="cms-category-item" style="background: #0f172a; border-color: #334155;">
                                    <div style="flex: 1;">
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Stat {{ $i }} Value</label>
                                            <input type="text" name="stat{{ $i }}_value" class="cms-form-input" value="" placeholder="Enter value">
                                        </div>
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Stat {{ $i }} Label</label>
                                            <input type="text" name="stat{{ $i }}_label" class="cms-form-input" value="" placeholder="Enter label">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif

                        @php
                            // Debug information
                            if (app()->environment('local')) {
                                echo '<!-- Debug: Stats count = ' . $brandStats->count() . ' -->';
                                echo '<!-- Debug: Has stats = ' . ($hasStats ? 'yes' : 'no') . ' -->';
                            }
                        @endphp

                        <button type="submit" class="cms-btn cms-btn-success">Save Brand Statements</button>
                    </form>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('mission-vision')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Mission & Vision
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="mission-vision-content">
                    <div class="alert cms-alert-success" id="alert-mission-vision-success"></div>
                    <div class="alert cms-alert-error" id="alert-mission-vision-error"></div>

                    <form id="mission-vision-form" class="cms-form" onsubmit="saveSection(event, 'mission-vision')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <!-- Mission Section -->
                        <div class="form-subtitle">Mission</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Mission Title</label>
                            <input type="text" name="mission[title]" class="cms-form-input" value="{{ $cmsData['missionVision']['mission']['title'] }}" placeholder="OUR MISSION">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Mission Description</label>
                            <textarea name="mission[description]" class="cms-form-textarea" placeholder="Describe your mission...">{{ $cmsData['missionVision']['mission']['description'] }}</textarea>
                        </div>

                        <!-- Mission Strategic Points -->
                        <div class="form-subtitle">Strategic Points</div>

                        <div id="mission-points-container" style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($cmsData['missionVision']['mission']['points'] as $index => $point)
                                <div class="cms-strategic-point-item" style="display: flex; align-items: center; gap: 0.75rem; background: #0f172a; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #334155;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="mission[points][]" class="cms-form-input" value="{{ $point }}" placeholder="Add a strategic point..." style="flex: 1;">
                                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem;">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addMissionPoint()" style="margin-top: 0.75rem; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid #334155; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Strategic Point
                        </button>

                        <!-- Vision Section -->
                        <div class="form-subtitle" style="margin-top: 2rem;">Vision</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Vision Title</label>
                            <input type="text" name="vision[title]" class="cms-form-input" value="{{ $cmsData['missionVision']['vision']['title'] }}" placeholder="OUR VISION">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Vision Description</label>
                            <textarea name="vision[description]" class="cms-form-textarea" placeholder="Describe your vision...">{{ $cmsData['missionVision']['vision']['description'] }}</textarea>
                        </div>

                        <!-- Vision Future Milestones -->
                        <div class="form-subtitle">Future Milestones</div>

                        <div id="vision-points-container" style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($cmsData['missionVision']['vision']['points'] as $index => $point)
                                <div class="cms-strategic-point-item" style="display: flex; align-items: center; gap: 0.75rem; background: #0f172a; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #334155;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="vision[points][]" class="cms-form-input" value="{{ $point }}" placeholder="Add a milestone..." style="flex: 1;">
                                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem;">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addVisionPoint()" style="margin-top: 0.75rem; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid #334155; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Future Milestone
                        </button>

                        <button type="submit" class="cms-btn cms-btn-success" style="margin-top: 2rem;">Save Mission & Vision</button>
                    </form>
                </div>
            </div>

            <!-- Core Values Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('core-values')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Core Values
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="core-values-content">
                    <div class="alert cms-alert-success" id="alert-core-values-success"></div>
                    <div class="alert cms-alert-error" id="alert-core-values-error"></div>

                    <form id="core-values-form" class="cms-form" onsubmit="saveSection(event, 'core-values')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['coreValues']['items']['core_values_title']->section_content ?? 'CORE VALUES' }}" placeholder="CORE VALUES">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Subtitle</label>
                            <textarea name="subtitle" class="cms-form-textarea" placeholder="The principles that guide everything we do">{{ $cmsData['coreValues']['items']['core_values_subtitle']->section_content ?? '' }}</textarea>
                        </div>

                        <div class="form-subtitle" style="display: flex; align-items: center; justify-content: space-between;">
                            Core Values Items
                            <span id="core-values-counter" style="font-size: 0.7rem; color: #64748b; font-weight: 600; background: rgba(59, 130, 246, 0.1); padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                    @php
                                        $currentCount = $cmsData['coreValues']['values']->count();
                                        echo $currentCount . '/4';
                                    @endphp
                                </span>
                        </div>

                        <div id="core-values-container" style="display: flex; flex-direction: column; gap: 1rem;">
                            @if($cmsData['coreValues']['values'] && $cmsData['coreValues']['values']->count() > 0)
                                @foreach($cmsData['coreValues']['values'] as $index => $value)
                                    <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem;">
                                        <!-- Delete Button -->
                                        <button type="button" onclick="deleteCoreValue({{ $value['id'] }})" style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #ef4444; border: none; border-radius: 0.25rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <input type="hidden" name="delete_value_{{ $value['id'] }}" id="delete_value_{{ $value['id'] }}" value="">

                                        <!-- Icon Section -->
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Icon (SVG)</label>
                                            <div style="display: flex; gap: 1rem; align-items: center;">
                                                <div class="cms-icon-preview" style="width: 48px; height: 48px; background: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    <div id="icon-preview-{{ $value['id'] }}" style="width: 32px; height: 32px; color: #60a5fa;">
                                                        {!! $value['icon'] !!}
                                                    </div>
                                                </div>
                                                <textarea name="values[{{ $value['id'] }}][icon]" id="icon-input-{{ $value['id'] }}" rows="4" class="cms-form-input" style="flex: 1; font-family: monospace; font-size: 0.75rem;" placeholder="Paste SVG code..." oninput="updateIconPreview({{ $value['id'] }}, this.value)">{!! $value['icon'] !!}</textarea>
                                            </div>
                                        </div>

                                        <!-- Title Input -->
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Value Title</label>
                                            <input type="text" name="values[{{ $value['id'] }}][title]" class="cms-form-input" value="{{ $value['title'] }}" placeholder="Value Title">
                                        </div>

                                        <!-- Description Input -->
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Value Description</label>
                                            <textarea name="values[{{ $value['id'] }}][description]" rows="3" class="cms-form-textarea" placeholder="Value description...">{{ $value['description'] }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div style="text-align: center; padding: 2rem; color: #64748b; background: #0f172a; border-radius: 0.5rem; border: 1px dashed #334155;">
                                    <svg style="width: 32px; height: 32px; margin: 0 auto 0.75rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p style="font-size: 0.875rem;">No core values found. Click "Add New Value" to create your first value.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Add New Value Button -->
                        <button type="button" id="add-core-value-btn" onclick="addNewCoreValue()" style="margin-top: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem; background: #0f172a; border: 2px dashed #334155; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <span style="font-weight: 600; color: #94a3b8; font-size: 0.875rem;">Add New Value</span>
                            <span id="add-value-status" style="color: #64748b; font-size: 0.75rem;">Click to add a new core value (max 4)</span>
                        </button>

                        <button type="submit" class="cms-btn cms-btn-success" style="margin-top: 1rem;">Save Core Values</button>
                    </form>
                </div>
            </div>

            <!-- Partners Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('partners')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Partners
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="partners-content">
                    <div class="alert cms-alert-success" id="alert-partners-success"></div>
                    <div class="alert cms-alert-error" id="alert-partners-error"></div>

                    <form id="partners-form" class="cms-form" onsubmit="saveSection(event, 'partners')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['partners']['items']['partners_title']?->section_content ?? $cmsData['partners']['title'] ?? 'Trusted by Industry Leaders' }}" placeholder="Trusted by Industry Leaders">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Subtitle</label>
                            <textarea name="subtitle" class="cms-form-textarea" placeholder="Proud partner to government agencies, multinational corporations, and leading enterprises">{{ $cmsData['partners']['items']['partners_subtitle']?->section_content ?? $cmsData['partners']['subtitle'] ?? '' }}</textarea>
                        </div>

                        <div class="form-subtitle" style="display: flex; align-items: center; justify-content: space-between;">
                            Partners List
                            <span id="partners-counter" style="font-size: 0.7rem; color: #64748b; font-weight: 600; background: rgba(59, 130, 246, 0.1); padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                    @php
                                        $partnersList = $cmsData['partners']['list'] ?? collect();
                                        $partnersCount = $partnersList->count();
                                        echo $partnersCount . '/6';
                                    @endphp
                                </span>
                        </div>

                        <div id="partners-container" style="display: flex; flex-direction: column; gap: 1rem;">
                            @if($partnersList && $partnersList->count() > 0)
                                @foreach($partnersList as $index => $partner)
                                    <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative;">
                                        <!-- Delete Button -->
                                        <button type="button" onclick="deletePartner({{ $partner['id'] }})" style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #ef4444; border: none; border-radius: 0.25rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <input type="hidden" name="delete_partner_{{ $partner['id'] }}" id="delete_partner_{{ $partner['id'] }}" value="">

                                        <!-- Logo Upload/Display Section -->
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Partner Logo</label>
                                            @php
                                                $logoImage = $partner['logo'] ?? null;
                                                if ($logoImage && !str_starts_with($logoImage, 'http') && !str_starts_with($logoImage, '/')) {
                                                    $logoImage = asset($logoImage);
                                                } elseif ($logoImage && str_starts_with($logoImage, '/storage')) {
                                                    $logoImage = asset($logoImage);
                                                }
                                            @endphp

                                            <input type="file"
                                                   name="partner_logo_{{ $partner['id'] }}_dropify"
                                                   id="partner_logo_{{ $partner['id'] }}_dropify"
                                                   class="dropify-partner"
                                                   accept="image/*"
                                                   data-default-file="{{ $logoImage ?? '' }}"
                                                   data-max-width="3000"
                                                   data-max-height="3000"
                                                   data-show-remove="true"
                                                   data-show-errors="true">

                                            <input type="hidden" name="partners[{{ $partner['id'] }}][logo]" id="partner_logo_{{ $partner['id'] }}_url" value="{{ $partner['logo'] ?? '' }}">
                                            <div style="margin-top: 0.5rem; font-size: 0.7rem; color: #64748b;">Upload an image or use a URL/emoji via Dropify</div>
                                        </div>

                                        <!-- Partner Name -->
                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Partner Name</label>
                                            <input type="text" name="partners[{{ $partner['id'] }}][name]" class="cms-form-input" value="{{ $partner['name'] }}" placeholder="Partner Name">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="no-partners-message" style="text-align: center; padding: 2rem; color: #64748b; background: #0f172a; border-radius: 0.5rem; border: 1px dashed #334155;">
                                    <svg style="width: 32px; height: 32px; margin: 0 auto 0.75rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p style="font-size: 0.875rem;">No partners found. Click "Add New Partner" to create your first partner.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Add New Partner Button -->
                        @php
                            $partnersList = $cmsData['partners']['list'] ?? collect();
                            $partnersCount = $partnersList->count();
                            $maxPartners = 6;
                            $remainingSlots = $maxPartners - $partnersCount;
                            $isMaxReached = $partnersCount >= $maxPartners;
                        @endphp

                        <button type="button"
                                id="add-partner-btn"
                                onclick="addNewPartner()"
                                @if($isMaxReached)
                                    disabled
                                    style="margin-top: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem; background: #0f172a; border: 2px dashed #334155; border-radius: 0.5rem; cursor: not-allowed; opacity: 0.5; pointer-events: none;"
                                @else
                                    style="margin-top: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem; background: #0f172a; border: 2px dashed #334155; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                                @endif
                                data-current-count="{{ $partnersCount }}"
                                data-max-partners="{{ $maxPartners }}"
                                data-remaining-slots="{{ $remainingSlots }}">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center;">
                                @if($isMaxReached)
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728a9 9 0 01-12.728 0m12.728-12.728a9 9 0 00-12.728 0"></path>
                                    </svg>
                                @else
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                @endif
                            </div>
                            <span style="font-weight: 600; color: #94a3b8; font-size: 0.875rem;">
                                @if($isMaxReached)
                                    Maximum Partners Reached
                                @else
                                    Add New Partner
                                @endif
                            </span>
                            <span id="add-partner-status" style="color: #64748b; font-size: 0.75rem;">
                                @if($isMaxReached)
                                    Maximum 6 partners allowed
                                @elseif($remainingSlots === 1)
                                    1 partner slot remaining
                                @else
                                    Click to add a new partner ({{ $remainingSlots }} slots remaining)
                                @endif
                            </span>
                        </button>

                        <button type="submit" class="cms-btn cms-btn-success" style="margin-top: 1rem;">Save Partners</button>
                    </form>
                </div>
            </div>

            <!-- Certifications Section Navigation Item -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('certifications')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167 3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167 3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167M3 12l1.5-3m5.5 3l3-6M3 12l6-3m6 3l6-3"></path>
                        </svg>
                        Certifications
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="certifications-content">
                    <div class="alert cms-alert-success" id="alert-certifications-success"></div>
                    <div class="alert cms-alert-error" id="alert-certifications-error"></div>

                    <form id="certifications-form" class="cms-form" onsubmit="saveSection(event, 'certifications')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['certifications']['items']['certifications_title']?->section_content ?? $cmsData['certifications']['title'] ?? 'Certifications & Standards' }}" placeholder="Certifications & Standards">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Subtitle</label>
                            <textarea name="subtitle" class="cms-form-textarea" placeholder="Internationally recognized certifications ensuring quality and safety">{{ $cmsData['certifications']['items']['certifications_subtitle']?->section_content ?? $cmsData['certifications']['subtitle'] ?? '' }}</textarea>
                        </div>

                        <div class="form-subtitle" style="display: flex; align-items: center; justify-content: space-between;">
                            Certifications List
                            <span id="certifications-counter" style="font-size: 0.7rem; color: #64748b; font-weight: 600; background: rgba(59, 130, 246, 0.1); padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                @php
                                    $certificationsList = $cmsData['certifications']['certifications'] ?? collect();
                                    $certificationsCount = $certificationsList->count();
                                    echo $certificationsCount . '/12';
                                @endphp
                            </span>
                        </div>

                        <div id="certifications-container" style="display: flex; flex-direction: column; gap: 1rem;">
                            @if($certificationsList && $certificationsList->count() > 0)
                                @foreach($certificationsList as $index => $certification)
                                    <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative;">
                                        <!-- Delete Button -->
                                        <button type="button" onclick="deleteCertification({{ $certification['id'] }})" style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #ef4444; border: none; border-radius: 0.25rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <input type="hidden" name="delete_certification_{{ $certification['id'] }}" id="delete_certification_{{ $certification['id'] }}" value="">

                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Certification Name/Title</label>
                                            <input type="text" name="certifications[{{ $certification['id'] }}][name]" class="cms-form-input" value="{{ $certification['name'] }}" placeholder="ISO 9001:2015">
                                        </div>

                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Description (Optional)</label>
                                            <textarea name="certifications[{{ $certification['id'] }}][description]" class="cms-form-textarea" placeholder="Quality management system certification">{{ $certification['description'] }}</textarea>
                                        </div>

                                        <div class="cms-form-group">
                                            <label class="cms-form-label">Icon/Emoji (Optional)</label>
                                            <input type="text" name="certifications[{{ $certification['id'] }}][icon]" class="cms-form-input" value="{{ $certification['icon'] }}" placeholder="🏆">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="no-certifications-message" style="text-align: center; padding: 2rem; color: #64748b; background: #0f172a; border-radius: 0.5rem; border: 1px dashed #334155;">
                                    <svg style="width: 32px; height: 32px; margin: 0 auto 0.75rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167 3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167M3 12l1.5-3m5.5 3l3-6M3 12l6-3m6 3l6-3"></path>
                                    </svg>
                                    <p style="font-size: 0.875rem;">No certifications found. Click "Add New Certification" to create your first certification.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Add New Certification Button -->
                        @php
                            $certificationsCount = $certificationsList->count();
                            $maxCertifications = 12;
                            $remainingCertSlots = $maxCertifications - $certificationsCount;
                            $isMaxCertReached = $certificationsCount >= $maxCertifications;
                        @endphp
                        <button
                            id="add-certification-btn"
                            onclick="addNewCertification()"
                            @if($isMaxCertReached)
                                disabled
                                style="margin-top: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem; background: #0f172a; border: 2px dashed #334155; border-radius: 0.5rem; cursor: not-allowed; opacity: 0.5; pointer-events: none;"
                            @else
                                style="margin-top: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem; background: #0f172a; border: 2px dashed #334155; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                            @endif
                            data-current-count="{{ $certificationsCount }}"
                            data-max-certifications="{{ $maxCertifications }}"
                            data-remaining-slots="{{ $remainingCertSlots }}">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center;">
                                @if($isMaxCertReached)
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728a9 9 0 01-12.728 0m12.728-12.728a9 9 0 00-12.728 0"></path>
                                    </svg>
                                @else
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                @endif
                            </div>
                            <span style="font-weight: 600; color: #94a3b8; font-size: 0.875rem;">
                                @if($isMaxCertReached)
                                    Maximum Certifications Reached
                                @else
                                    Add New Certification
                                @endif
                            </span>
                            <span id="add-certification-status" style="color: #64748b; font-size: 0.75rem;">
                                @if($isMaxCertReached)
                                    Maximum 12 certifications allowed
                                @elseif($remainingCertSlots === 1)
                                    1 certification slot remaining
                                @else
                                    Click to add a new certification ({{ $remainingCertSlots }} slots remaining)
                                @endif
                            </span>
                        </button>

                        <button type="submit" class="cms-btn cms-btn-success" style="margin-top: 1rem;">Save Certifications</button>
                    </form>
                </div>
            </div>

            <!-- Subscription Section Navigation Item -->
            <button class="cms-nav-header" onclick="toggleSection('subscription-section')">
                <div class="cms-nav-label">
                    <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2M5 11V9a2 2 0 012-2"></path>
                    </svg>
                    Subscription Section
                </div>
                <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="cms-nav-content" id="subscription-section-content">
                <div class="alert cms-alert-success" id="alert-subscription-section-success"></div>
                <div class="alert cms-alert-error" id="alert-subscription-section-error"></div>

                <form id="subscription-section-form" class="cms-form" onsubmit="saveSection(event, 'subscription-section')">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="cms-form-group">
                        <label class="cms-form-label">Section Title</label>
                        <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['subscription_section']['title'] ?? 'Ready to Power Your Success?' }}" placeholder="Ready to Power Your Success?">
                    </div>

                    <div class="cms-form-group">
                        <label class="cms-form-label">Section Description</label>
                        <textarea name="description" class="cms-form-textarea" placeholder="Describe your subscription CTA...">{{ $cmsData['subscription_section']['description'] ?? 'Discover how our innovative solutions can transform your business and drive sustainable growth.' }}</textarea>
                    </div>

                    <div class="cms-form-group">
                        <label class="cms-form-label">Button Text</label>
                        <input type="text" name="button_text" class="cms-form-input" value="{{ $cmsData['subscription_section']['button_text'] ?? 'Get Started' }}" placeholder="Get Started">
                    </div>

                    <div class="cms-form-group">
                        <label class="cms-form-label">Button Link</label>
                        <input type="text" name="button_link" class="cms-form-input" value="{{ $cmsData['subscription_section']['button_link'] ?? '/contact' }}" placeholder="/contact">
                    </div>

                    <button type="submit" class="cms-btn cms-btn-success">Save Subscription Section</button>
                </form>
            </div>

            <div style="padding: 2rem 1.5rem; text-align: center; color: #64748b; font-size: 0.875rem;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 0.5rem; opacity: 0.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <p>More sections coming soon...</p>
            </div>
        </nav>

        <a href="{{ route('dashboard') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </aside>

    <!-- Main Content - Browser preview -->
    <main class="cms-main">
        <div class="cms-header">
            <div>
                <div class="cms-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <span>Home Page CMS</span>
                </div>
                <h1 class="cms-page-title">Home Page Live Preview</h1>
            </div>
        </div>

        <div class="browser-container">
            <div class="browser-card">
                <!-- Browser Toolbar -->
                <div class="browser-toolbar">
                    <div class="browser-buttons">
                        <button onclick="reloadPage()" class="browser-btn" title="Reload page">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                        <button onclick="goHome()" class="browser-btn" title="Go home">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="browser-address-bar">
                        <span class="browser-secure-icon">🔒</span>
                        <input type="text" value="http://localhost:5173/preview/hero-section" id="url-input" placeholder="Enter preview URL...">
                        <span id="current-section-badge" class="browser-section-badge">Hero Section</span>
                    </div>

                    <button onclick="openInNewTab()" class="browser-btn" title="Open in new tab">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Browser Content -->
                <div class="browser-content">
                    <div class="loading-overlay" id="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                    <iframe
                        src="http://localhost:5173/preview/hero-section"
                        class="browser-iframe"
                        id="browser-iframe"
                        data-default-src="http://localhost:5173/preview/hero-section"
                        onload="hideLoading()"
                        onerror="handleError()">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <x-slot:scripts>
        <!-- jQuery (CDN for compatibility) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Make jQuery available globally for all scripts
            // Use noConflict but still make it accessible
            window.jQuery = jQuery;
            window.$ = jQuery;
            console.log('jQuery loaded successfully, version:', $.fn.jquery);
        </script>
        <!-- Dropify JS (Local) -->
        <script src="{{ asset('libs/dropify/dist/js/dropify.min.js') }}"></script>
        <script>
            // Verify Dropify loaded and is properly registered
            if (typeof $.fn.dropify === 'undefined') {
                console.error('Dropify failed to load or not registered on jQuery');
            } else {
                console.log('Dropify loaded and registered successfully');
            }
        </script>
        <script>
            // Function to initialize all Dropify instances
            window.initializeAllDropify = function() {
                console.log('Page-specific initializeAllDropify called');

                // Check if jQuery and Dropify are available
                if (typeof $ === 'undefined') {
                    console.error('jQuery not available, cannot initialize Dropify');
                    return false;
                }
                if (typeof $.fn.dropify === 'undefined') {
                    console.error('Dropify plugin not available, cannot initialize');
                    return false;
                }

                let successCount = 0;
                let errorCount = 0;

                // Initialize partner Dropify instances with enhanced configuration
                console.log('Page-specific initializeAllDropify called');

                // Check if jQuery and Dropify are available
                if (typeof $ === 'undefined') {
                    console.error('jQuery not available, cannot initialize Dropify');
                    return false;
                }
                if (typeof $.fn.dropify === 'undefined') {
                    console.error('Dropify plugin not available, cannot initialize');
                    return false;
                }

                let successCount = 0;
                let errorCount = 0;

                // Initialize partner Dropify instances with enhanced configuration
                $('.dropify-partner:not(.dropify-initialized)').each(function() {
                    const $this = $(this);
                    const elementId = $this.attr('id');
                    const defaultFile = $this.data('default-file');

                    console.log('=== Initializing partner Dropify:', elementId, '===');
                    console.log('Default file:', defaultFile);
                    console.log('Element visible:', $this.is(':visible'));
                    console.log('Parent visible:', $this.parent().is(':visible'));
                    console.log('Section visible:', $this.closest('.cms-nav-content').is(':visible'));

                    try {
                        // Force remove any existing wrapper
                        $this.siblings('.dropify-wrapper').remove();
                        $this.unwrap('.dropify-wrapper');

                        // Initialize Dropify regardless of visibility - it will handle hidden elements
                        console.log('Calling dropify() on element:', elementId);

                        $this.dropify({
                            messages: {
                                'default': 'Drag and drop a partner logo here or click',
                                'replace': 'Drag and drop or click to replace',
                                'remove': 'Remove',
                                'error': 'Ooops, something wrong happened.'
                            },
                            error: {
                                'fileSize': 'The file size is too big (max 3MB).',
                                'minWidth': 'The image width is too small (min 100px).',
                                'maxWidth': 'The image width is too big (max 3000px).',
                                'minHeight': 'The image height is too small (min 100px).',
                                'maxHeight': 'The image height is too big (max 3000px).',
                                'imageFormat': 'The image format is not allowed.',
                                'fileExtension': 'The file extension is not allowed.'
                            }
                        });

                        // Add the initialized class
                        $this.addClass('dropify-initialized');

                        // Verify the instance was created
                        const dropifyInstance = $this.data('dropify');
                        const wrapper = $this.parent('.dropify-wrapper');

                        console.log('Dropify instance created:', !!dropifyInstance);
                        console.log('Wrapper created:', wrapper.length > 0);
                        console.log('Wrapper HTML:', wrapper.length > 0 ? wrapper[0].outerHTML.substring(0, 200) + '...' : 'No wrapper');

                        if (dropifyInstance && wrapper.length > 0) {
                            console.log('✓ Partner Dropify successfully initialized:', elementId);
                            successCount++;
                        } else {
                            console.error('✗ Dropify initialization failed for:', elementId);
                            console.error('Instance exists:', !!dropifyInstance);
                            console.error('Wrapper exists:', wrapper.length > 0);
                            errorCount++;
                        }

                    } catch (e) {
                        console.error('✗ Exception initializing partner Dropify for', elementId, ':', e);
                        console.error('Error stack:', e.stack);
                        errorCount++;
                    }
                });

                // Initialize standard Dropify instances
                $('.dropify:not(.dropify-initialized):not(.dropify-partner)').each(function() {
                    const $this = $(this);
                    try {
                        if ($this.is(':visible')) {
                            $this.dropify({
                                messages: {
                                    'default': 'Drag and drop a file here or click',
                                    'replace': 'Drag and drop or click to replace',
                                    'remove': 'Remove',
                                    'error': 'Ooops, something wrong happened.'
                                }
                            }).addClass('dropify-initialized');
                            console.log('✓ Standard Dropify initialized:', $this.attr('id'));
                            successCount++;
                        }
                    } catch (e) {
                        console.error('✗ Error initializing Dropify for', $this.attr('id'), ':', e);
                        errorCount++;
                    }
                });

                // Initialize brand Dropify instances (initialize regardless of visibility)
                $('.dropify-brand:not(.dropify-initialized)').each(function() {
                    const $this = $(this);
                    try {
                        // Remove visibility check to allow initialization in collapsed sections
                        $this.dropify({
                            messages: {
                                'default': 'Drag and drop a file here or click',
                                'replace': 'Drag and drop or click to replace',
                                'remove': 'Remove',
                                'error': 'Ooops, something wrong happened.'
                            },
                            error: {
                                'fileSize': 'The file size is too big (3MB max).',
                                'minWidth': 'The image width is too small (min 100px).',
                                'maxWidth': 'The image width is too big (max 3000px).',
                                'minHeight': 'The image height is too small (min 100px).',
                                'maxHeight': 'The image height is too big (max 3000px).',
                                'imageFormat': 'The image format is not allowed.',
                                'fileExtension': 'The file extension is not allowed.'
                            }
                        }).addClass('dropify-initialized');
                        console.log('✓ Brand Dropify initialized:', $this.attr('id'));
                        successCount++;
                    } catch (e) {
                        console.error('✗ Error initializing brand Dropify for', $this.attr('id'), ':', e);
                        errorCount++;
                    }
                });

                console.log('Dropify initialization complete. Success:', successCount, 'Errors:', errorCount);

                // Attach event handlers to newly initialized partner Dropify instances
                if (successCount > 0) {
                    attachPartnerDropifyEvents();
                }

                return successCount > 0;
            }

            // Verify Dropify loaded and initialize
            if (typeof $.fn.dropify === 'undefined') {
                console.error('Dropify failed to load');
            } else {
                console.log('Dropify loaded successfully (local version)');
                console.log('Calling initializeAllDropify after function definition...');

                // Initialize all Dropify instances
                window.initializeAllDropify();
            }

            // Function to attach event handlers to partner Dropify instances
            window.attachPartnerDropifyEvents = function() {
                console.log('Attaching partner Dropify events...');

                // Remove existing event handlers to avoid duplicates
                $('.dropify-partner.dropify-initialized').off('dropify.change dropify.afterClear');

                // Handle partner logo uploads with Dropify events
                $('.dropify-partner.dropify-initialized').on('dropify.change', function(event, element) {
                    console.log('Dropify change event fired for:', this.id);

                    try {
                        const inputElement = element.input[0];
                        if (!inputElement) {
                            console.error('No input element found in dropify instance for', this.id);
                            return;
                        }

                        const partnerId = inputElement.id.replace('partner_logo_', '').replace('_dropify', '');
                        const hiddenInput = document.getElementById('partner_logo_' + partnerId + '_url');

                        console.log('Partner logo change event triggered for ID:', partnerId);

                        if (inputElement.files && inputElement.files[0]) {
                            const file = inputElement.files[0];
                            console.log('File selected:', file.name, file.type, file.size);

                            // Validate file type
                            if (!file.type.startsWith('image/')) {
                                console.error('Invalid file type:', file.type);
                                alert('Please select an image file.');
                                return;
                            }

                            // Validate file size (3MB max)
                            if (file.size > 3 * 1024 * 1024) {
                                console.error('File too large:', file.size);
                                alert('File size must be less than 3MB.');
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const base64Result = e.target.result;
                                if (hiddenInput) {
                                    hiddenInput.value = base64Result;
                                    console.log('✓ Partner logo uploaded for partner ID:', partnerId, 'Data length:', base64Result.length);
                                } else {
                                    console.error('✗ Hidden input not found for partner ID:', partnerId);
                                }
                            };
                            reader.onerror = function() {
                                console.error('✗ Error reading file for partner ID:', partnerId);
                                alert('Error reading file. Please try again.');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            console.log('No files in input element');
                        }
                    } catch (e) {
                        console.error('✗ Error in dropify.change handler:', e);
                    }
                });

                // Handle Dropify reset events
                $('.dropify-partner.dropify-initialized').on('dropify.afterClear', function(event, element) {
                    console.log('Dropify afterClear event fired for:', this.id);

                    try {
                        const inputElement = element.input[0];
                        if (!inputElement) {
                            console.error('No input element found in dropify instance for', this.id);
                            return;
                        }

                        const partnerId = inputElement.id.replace('partner_logo_', '').replace('_dropify', '');
                        const hiddenInput = document.getElementById('partner_logo_' + partnerId + '_url');

                        if (hiddenInput) {
                            hiddenInput.value = '';
                            console.log('✓ Partner logo cleared for partner ID:', partnerId);
                        } else {
                            console.error('✗ Hidden input not found for partner ID:', partnerId);
                        }
                    } catch (e) {
                        console.error('✗ Error in dropify.afterClear handler:', e);
                    }
                });

                const eventCount = $('.dropify-partner.dropify-initialized').length;
                console.log('✓ Partner Dropify events attached successfully. Total instances:', eventCount);
                return eventCount > 0;
            }

            // Manual debugging function to force re-initialize partner Dropify instances
            window.forceReinitializePartnerDropify = function() {
                console.log('Force re-initializing partner Dropify instances...');

                // Destroy existing partner Dropify instances
                $('.dropify-partner').each(function() {
                    const $this = $(this);
                    if ($this.data('dropify')) {
                        console.log('Destroying:', $this.attr('id'));
                        try {
                            $this.data('dropify').destroy();
                            $this.removeClass('dropify-initialized');
                        } catch (e) {
                            console.error('Error destroying', $this.attr('id'), ':', e);
                        }
                    }
                });

                // Re-initialize
                setTimeout(() => {
                    initializeAllDropify();
                    console.log('Force re-initialization complete');
                }, 100);
            }

            // Make function available globally for debugging
            window.forceReinitializePartnerDropify = forceReinitializePartnerDropify;

            // Comprehensive debugging function
            window.testPartnerDropify = function() {
                console.log('=== Partner Dropify Comprehensive Test ===');
                console.log('jQuery available:', typeof $ !== 'undefined');
                console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'N/A');
                console.log('Dropify available:', typeof $.fn.dropify !== 'undefined');
                console.log('Partner elements found:', $('.dropify-partner').length);
                console.log('Partner elements initialized:', $('.dropify-partner.dropify-initialized').length);

                let workingCount = 0;
                let brokenCount = 0;
                let hiddenCount = 0;

                $('.dropify-partner').each(function() {
                    const $this = $(this);
                    const instance = $this.data('dropify');
                    const wrapper = $this.parent('.dropify-wrapper');
                    const isVisible = $this.is(':visible');
                    const wrapperExists = wrapper.length > 0;

                    if (instance && wrapperExists && isVisible) {
                        workingCount++;
                        console.log('✓', $this.attr('id'), '- Working (has instance, wrapper, visible)');
                    } else if (!isVisible) {
                        hiddenCount++;
                        console.log('⊘', $this.attr('id'), '- Hidden (will initialize when section opens)');
                    } else {
                        brokenCount++;
                        console.log('✗', $this.attr('id'), '- Broken:', {
                            'hasInstance': !!instance,
                            'hasWrapper': wrapperExists,
                            'isVisible': isVisible,
                            'defaultFile': $this.data('default-file')
                        });
                    }
                });

                console.log('=== Test Results ===');
                console.log('Working:', workingCount);
                console.log('Hidden:', hiddenCount);
                console.log('Broken:', brokenCount);
                console.log('Total:', workingCount + hiddenCount + brokenCount);

                // Test manual initialization
                if (brokenCount > 0) {
                    console.log('=== Attempting to fix broken instances ===');
                    const initSuccess = initializeAllDropify();
                    console.log('Fix attempt result:', initSuccess ? 'Success' : 'Failed');
                }

                return {
                    working: workingCount,
                    hidden: hiddenCount,
                    broken: brokenCount,
                    total: workingCount + hiddenCount + brokenCount
                };
            };

            // Quick fix function
            window.fixPartnerDropify = function() {
                console.log('=== Attempting to fix Partner Dropify ===');

                // Step 1: Ensure jQuery is loaded
                if (typeof $ === 'undefined') {
                    console.error('✗ jQuery not loaded');
                    return false;
                }

                // Step 2: Ensure Dropify is loaded
                if (typeof $.fn.dropify === 'undefined') {
                    console.error('✗ Dropify not loaded');
                    return false;
                }

                console.log('✓ Libraries loaded, proceeding with fix...');

                // Step 3: Clear existing instances completely
                console.log('Step 1: Clearing existing instances...');
                $('.dropify-partner').each(function() {
                    const $this = $(this);
                    if ($this.data('dropify')) {
                        try {
                            $this.data('dropify').destroy();
                            $this.removeClass('dropify-initialized');
                            console.log('✓ Destroyed:', $this.attr('id'));
                        } catch (e) {
                            console.error('✗ Error destroying:', $this.attr('id'), e);
                        }
                    }
                    // Remove any existing wrappers
                    $this.siblings('.dropify-wrapper').remove();
                    $this.unwrap('.dropify-wrapper');
                });

                // Step 4: Re-initialize with a simple approach
                console.log('Step 2: Re-initializing with simple approach...');
                setTimeout(() => {
                    $('.dropify-partner').each(function() {
                        const $this = $(this);
                        try {
                            $this.dropify().addClass('dropify-initialized');
                            console.log('✓ Simple init for:', $this.attr('id'));
                        } catch (e) {
                            console.error('✗ Simple init failed for', $this.attr('id'), ':', e);
                        }
                    });

                    // Attach events
                    attachPartnerDropifyEvents();

                    // Step 5: Verify results
                    const testResults = testPartnerDropify();
                    console.log('Fix results:', testResults);
                    console.log('Fix complete!', testResults.broken === 0 ? 'SUCCESS' : 'PARTIAL');

                    return testResults.broken === 0;
                }, 300);

                return true;
            };

            // Simple direct test - run this to see if dropify works
            window.simpleDropifyTest = function() {
                console.log('=== Simple Dropify Test ===');

                // Test basic functionality
                const testElement = $('.dropify-partner').first();
                if (!testElement.length) {
                    console.error('✗ No partner dropify elements found');
                    return false;
                }

                console.log('Testing element:', testElement.attr('id'));
                console.log('jQuery works:', typeof $ !== 'undefined');
                console.log('Dropify available:', typeof $.fn.dropify !== 'undefined');

                if (typeof $.fn.dropify === 'undefined') {
                    console.error('✗ Dropify plugin not available');
                    return false;
                }

                // Try to initialize just this one element
                try {
                    console.log('Attempting to initialize single element...');

                    // Clean up first
                    if (testElement.data('dropify')) {
                        testElement.data('dropify').destroy();
                    }

                    // Initialize
                    testElement.dropify();

                    // Check result
                    const instance = testElement.data('dropify');
                    const wrapper = testElement.parent('.dropify-wrapper');

                    console.log('Instance created:', !!instance);
                    console.log('Wrapper created:', wrapper.length > 0);

                    if (instance && wrapper.length > 0) {
                        console.log('✓ Dropify works! Element:', testElement.attr('id'));
                        console.log('Wrapper HTML:', wrapper[0].outerHTML.substring(0, 300) + '...');
                        return true;
                    } else {
                        console.error('✗ Dropify failed to create wrapper');
                        return false;
                    }

                } catch (e) {
                    console.error('✗ Exception during test:', e);
                    return false;
                }
            };

            // Make initialization available globally
            window.initPartnerDropify = initializeAllDropify;

            // Debug function to inspect partners container structure
            window.debugPartnersContainer = function() {
                const container = document.getElementById('partners-container');
                if (!container) {
                    console.error('❌ Partners container not found');
                    return;
                }

                console.log('=== PARTNERS CONTAINER DEBUG ===');
                console.log('🔍 Container ID:', container.id);
                console.log('🔍 Container class:', container.className);
                console.log('🔍 Direct children length:', container.children.length);

                // List all children
                console.log('🔍 All direct children:');
                Array.from(container.children).forEach((child, index) => {
                    console.log(`  ${index + 1}. ${child.tagName}.${child.className || 'no-class'} - id: ${child.id || 'no-id'}`);
                });

                // Count .cms-value-item elements
                const partnerItems = container.querySelectorAll('.cms-value-item');
                console.log('🔍 .cms-value-item elements found:', partnerItems.length);

                console.log('🔍 All .cms-value-item elements:');
                Array.from(partnerItems).forEach((item, index) => {
                    console.log(`  ${index + 1}. ${item.className} - has data: ${!!item.dataset}`);
                });

                // Check for add button
                const addButton = document.getElementById('add-partner-btn');
                console.log('🔍 Add button exists:', !!addButton);
                if (addButton) {
                    console.log('🔍 Add button position:', addButton.previousElementSibling ? 'Has previous sibling' : 'No previous sibling');
                }

                console.log('=== END DEBUG ===');
                return {
                    totalChildren: container.children.length,
                    partnerItems: partnerItems.length,
                    addButtonExists: !!addButton
                };
            };

            // Test partner counting
            window.testPartnerCounting = function() {
                const container = document.getElementById('partners-container');
                if (!container) {
                    console.error('❌ Container not found');
                    return;
                }

                console.log('=== TEST PARTNER COUNTING ===');

                // Try different counting methods
                const method1 = container.querySelectorAll('.cms-value-item').length;
                const method2 = container.children.length;
                const method3 = Array.from(container.children).filter(child => child.classList.contains('cms-value-item')).length;

                console.log('🔍 Method 1 (querySelectorAll):', method1);
                console.log('🔍 Method 2 (children.length):', method2);
                console.log('🔍 Method 3 (filter .cms-value-item):', method3);

                // Count all elements that could be partners
                const allElements = container.querySelectorAll('*');
                console.log('🔍 All elements in container:', allElements.length);

                console.log('=== TEST COMPLETE ===');
                return {
                    querySelectorAll: method1,
                    childrenLength: method2,
                    filtered: method3
                };
            };
        </script>

        <!-- CMS JavaScript Functions -->
        <script>
            // Toggle section visibility
            function toggleSection(sectionId) {
                // Ensure jQuery is available
                if (typeof $ === 'undefined') {
                    console.error('jQuery not available in toggleSection');
                    // Try to use window.jQuery as fallback
                    if (typeof window.jQuery !== 'undefined') {
                        window.$ = window.jQuery;
                        console.log('jQuery restored from window.jQuery');
                    } else {
                        console.error('jQuery completely unavailable - toggleSection cannot work');
                        return;
                    }
                }

                const content = document.getElementById(sectionId + '-content');
                const allContents = document.querySelectorAll('.cms-nav-content');
                const allHeaders = document.querySelectorAll('.cms-nav-header');

                // Hide all sections first
                allContents.forEach(c => {
                    if (c.id !== sectionId + '-content') {
                        c.style.display = 'none';
                    }
                });

                // Remove active class from all headers
                allHeaders.forEach(h => {
                    h.classList.remove('active');
                });

                // Toggle current section
                if (content.style.display === 'none' || !content.style.display) {
                    content.style.display = 'block';
                    event.currentTarget.classList.add('active');

                    // Update preview URL
                    let previewUrl;
                    if (sectionId === 'subscription-section') {
                        previewUrl = 'http://localhost:5173/preview/home-subscription-section';
                    } else {
                        previewUrl = 'http://localhost:5173/preview/' + sectionId;
                    }
                    document.getElementById('url-input').value = previewUrl;
                    document.getElementById('current-section-badge').textContent = formatSectionTitle(sectionId);
                    document.getElementById('browser-iframe').src = previewUrl;
                    showLoading();

                    // Re-initialize Dropify when Partners section is opened
                    if (sectionId === 'partners') {
                        console.log('=== Partners section opened, initializing Dropify ===');

                        // Safety check for jQuery
                        if (typeof $ === 'undefined' || typeof $.fn.dropify === 'undefined') {
                            console.error('jQuery or Dropify not available for Partners section');
                            return;
                        }

                        // Clear any existing Dropify instances first
                        try {
                            $('.dropify-partner').each(function() {
                                const $this = $(this);
                                if ($this.data('dropify')) {
                                    try {
                                        console.log('Destroying existing Dropify:', $this.attr('id'));
                                        $this.data('dropify').destroy();
                                        $this.removeClass('dropify-initialized');
                                        // Remove any existing wrappers
                                        $this.siblings('.dropify-wrapper').remove();
                                        $this.unwrap('.dropify-wrapper');
                                    } catch (e) {
                                        console.error('Error destroying Dropify:', e);
                                    }
                                }
                            });
                        } catch (e) {
                            console.error('Error in Dropify cleanup:', e);
                        }

                        // Wait for section to be fully visible, then initialize
                        setTimeout(() => {
                            console.log('Section should be visible now, initializing partner Dropify...');

                            // Safety check before initialization
                            if (typeof $ === 'undefined' || typeof $.fn.dropify === 'undefined') {
                                console.error('jQuery or Dropify not available for initialization');
                                return;
                            }

                            // Direct initialization approach
                            try {
                                $('.dropify-partner').each(function() {
                                    const $this = $(this);
                                    const elementId = $this.attr('id');
                                    const defaultFile = $this.data('default-file');

                                    console.log('Direct init for:', elementId);

                                    try {
                                        // Ensure element is clean
                                        $this.removeClass('dropify-initialized');

                                        // Initialize dropify
                                        $this.dropify({
                                            messages: {
                                                'default': 'Drag and drop a partner logo here or click',
                                                'replace': 'Drag and drop or click to replace',
                                                'remove': 'Remove',
                                                'error': 'Ooops, something wrong happened.'
                                            }
                                        });

                                        // Mark as initialized
                                        $this.addClass('dropify-initialized');

                                        console.log('✓ Direct init complete for:', elementId);

                                    } catch (e) {
                                        console.error('✗ Direct init failed for', elementId, ':', e);
                                    }
                                });

                                // Attach events
                                if (typeof attachPartnerDropifyEvents === 'function') {
                                    attachPartnerDropifyEvents();
                                }

                                const dropifyCount = $('.dropify-partner.dropify-initialized').length;
                                console.log('=== Partners section Dropify initialization complete ===');
                                console.log('Total partner instances:', dropifyCount);

                                // Final verification
                                let workingCount = 0;
                                $('.dropify-partner.dropify-initialized').each(function() {
                                    const $this = $(this);
                                    const instance = $this.data('dropify');
                                    const wrapper = $this.parent('.dropify-wrapper');

                                    if (instance && wrapper.length > 0) {
                                        workingCount++;
                                        console.log('✓', $this.attr('id'), '- Working');
                                    } else {
                                        console.error('✗', $this.attr('id'), '- Not working:', {
                                            'instance': !!instance,
                                            'wrapper': wrapper.length > 0
                                        });
                                    }
                                });

                                console.log('Working instances:', workingCount, '/', dropifyCount);

                            } catch (e) {
                                console.error('Error in Dropify initialization:', e);
                            }

                        }, 200); // Reduced timeout for faster response
                    }
                }
            }

            // Format section title for display
            function formatSectionTitle(sectionId) {
                return sectionId.split('-')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            }

            // Certification Functions
            window.addNewCertification = function() {
                const container = document.getElementById('certifications-container');
                const maxCertifications = 12;

                if (!container) {
                    console.error('Certifications container not found');
                    return;
                }

                const currentCount = container.querySelectorAll('.cms-value-item').length;
                const remainingSlots = maxCertifications - currentCount;

                console.log('=== addNewCertification called ===');
                console.log('Current certifications in container:', currentCount);
                console.log('Max certifications:', maxCertifications);
                console.log('Remaining slots:', remainingSlots);

                if (currentCount >= maxCertifications) {
                    alert(`Maximum ${maxCertifications} certifications allowed. You have reached the limit (${currentCount}/${maxCertifications}).`);
                    console.log('❌ Cannot add certification - limit reached');
                    return;
                }

                if (remainingSlots <= 0) {
                    alert(`Cannot add more certifications. Maximum ${maxCertifications} allowed. Current: ${currentCount}`);
                    console.log('❌ Cannot add certification - no remaining slots');
                    return;
                }

                console.log('✓ Certification addition allowed');

                // Find the next available sequential ID
                let newId = 1;
                const existingCertifications = container.querySelectorAll('.cms-value-item');
                existingCertifications.forEach(cert => {
                    const inputs = cert.querySelectorAll('input[name^="certifications["]');
                    inputs.forEach(input => {
                        const match = input.name.match(/certifications\[(\d+)\]/);
                        if (match) {
                            const id = parseInt(match[1]);
                            if (id >= newId) {
                                newId = id + 1;
                            }
                        }
                    });
                });

                console.log('🔍 Next sequential ID:', newId);
                const certificationHtml = `
                    <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative;">
                        <button type="button" onclick="deleteCertification(${newId})" style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #ef4444; border: none; border-radius: 0.25rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <input type="hidden" name="delete_certification_${newId}" id="delete_certification_${newId}" value="">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Certification Name/Title</label>
                            <input type="text" name="certifications[${newId}][name]" class="cms-form-input" placeholder="ISO 9001:2015">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description (Optional)</label>
                            <textarea name="certifications[${newId}][description]" class="cms-form-textarea" placeholder="Quality management system certification"></textarea>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Icon/Emoji (Optional)</label>
                            <input type="text" name="certifications[${newId}][icon]" class="cms-form-input" placeholder="🏆">
                        </div>
                    </div>
                `;

                // Remove empty state message if present
                const noCertificationsMsg = document.getElementById('no-certifications-message');
                if (noCertificationsMsg) {
                    noCertificationsMsg.remove();
                }

                // Insert inside the certifications-container
                console.log('🔍 BEFORE insertion - Current DOM count:', container.querySelectorAll('.cms-value-item').length);
                container.insertAdjacentHTML('beforeend', certificationHtml);
                console.log('🔍 AFTER insertion - DOM count:', container.querySelectorAll('.cms-value-item').length);

                updateCertificationsCounter();
                console.log('=== addNewCertification complete ===');
            };

            window.deleteCertification = function(id) {
                const deleteField = document.getElementById('delete_certification_' + id);
                if (deleteField) {
                    deleteField.value = '1';
                }

                const certificationItem = deleteField ? deleteField.closest('.cms-value-item') : null;
                if (certificationItem) {
                    certificationItem.remove();
                }

                updateCertificationsCounter();

                // If no certifications left, show the empty message
                const container = document.getElementById('certifications-container');
                if (container && container.querySelectorAll('.cms-value-item').length === 0) {
                    const emptyHtml = `
                        <div id="no-certifications-message" style="text-align: center; padding: 2rem; color: #64748b; background: #0f172a; border-radius: 0.5rem; border: 1px dashed #334155;">
                            <svg style="width: 32px; height: 32px; margin: 0 auto 0.75rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167 3.42 3.42 0 001.946-.806 3.42 3.42 0 014.638 3.167M3 12l1.5-3m5.5 3l3-6M3 12l6-3m6 3l6-3"></path>
                            </svg>
                            <p style="font-size: 0.875rem;">No certifications found. Click "Add New Certification" to create your first certification.</p>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', emptyHtml);
                }
            };

            window.updateCertificationsCounter = function() {
                const container = document.getElementById('certifications-container');
                const addButton = document.getElementById('add-certification-btn');
                const maxCertifications = 12;

                if (!container) {
                    console.error('❌ Certifications container not found');
                    return;
                }

                const actualCount = container.querySelectorAll('.cms-value-item').length;
                const remainingSlots = maxCertifications - actualCount;

                console.log('=== updateCertificationsCounter DEBUG ===');
                console.log('🔍 Container exists:', !!container);
                console.log('🔍 .cms-value-item elements found:', actualCount);
                console.log('🔍 maxCertifications:', maxCertifications);
                console.log('🔍 remainingSlots:', remainingSlots);

                // Update counter display
                const counter = document.getElementById('certifications-counter');
                if (counter) {
                    counter.textContent = actualCount + '/' + maxCertifications;
                    console.log('✅ Counter updated to:', actualCount + '/' + maxCertifications);
                }

                // Update add button status
                const status = document.getElementById('add-certification-status');
                if (status && addButton) {
                    if (actualCount >= maxCertifications) {
                        status.textContent = 'Maximum certifications reached';
                        addButton.style.opacity = '0.5';
                        addButton.style.pointerEvents = 'none';
                        addButton.disabled = true;
                        console.log('✅ Button DISABLED (max reached)');
                    } else if (remainingSlots === 1) {
                        status.textContent = '1 certification slot remaining';
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log('✅ Button enabled (1 slot remaining)');
                    } else {
                        status.textContent = `Click to add a new certification (${remainingSlots} slots remaining)`;
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log(`✅ Button enabled (${remainingSlots} slots remaining)`);
                    }
                }

                console.log('=== updateCertificationsCounter complete ===\n');
            };

            // Initialize certifications counter on page load
            window.initializeCertificationsCounter = function() {
                const container = document.getElementById('certifications-container');
                const addButton = document.getElementById('add-certification-btn');
                if (!addButton || !container) return;

                const actualCount = container.querySelectorAll('.cms-value-item').length;
                const maxCertifications = parseInt(addButton.dataset.maxCertifications || '12');
                const remainingSlots = maxCertifications - actualCount;

                console.log('=== initializeCertificationsCounter ===');
                console.log('Elements in container:', actualCount);
                console.log('Max certifications:', maxCertifications);
                console.log('Remaining slots:', remainingSlots);

                // Update counter display
                const counter = document.getElementById('certifications-counter');
                if (counter) {
                    counter.textContent = actualCount + '/' + maxCertifications;
                }

                // Update add button status based on actual count
                const status = document.getElementById('add-certification-status');
                if (status) {
                    if (actualCount >= maxCertifications) {
                        status.textContent = 'Maximum certifications reached';
                        addButton.style.opacity = '0.5';
                        addButton.style.pointerEvents = 'none';
                        addButton.disabled = true;
                        console.log('✓ Maximum reached on init - Button disabled');
                    } else if (remainingSlots === 1) {
                        status.textContent = '1 certification slot remaining';
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log('✓ 1 slot remaining on init - Button enabled');
                    } else {
                        status.textContent = `Click to add a new certification (${remainingSlots} slots remaining)`;
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log(`✓ ${remainingSlots} slots remaining on init - Button enabled`);
                    }
                }

                console.log('=== initializeCertificationsCounter complete ===\n');
                return {
                    actualCount: actualCount,
                    maxCertifications: maxCertifications,
                    remainingSlots: remainingSlots
                };
            };

            // Show loading overlay
            function showLoading() {
                document.getElementById('loading-overlay').style.display = 'flex';
            }

            // Hide loading overlay
            function hideLoading() {
                document.getElementById('loading-overlay').style.display = 'none';
            }

            // Handle iframe errors
            function handleError() {
                hideLoading();
                console.error('Failed to load preview');
            }

            // Reload page
            function reloadPage() {
                const iframe = document.getElementById('browser-iframe');
                showLoading();
                iframe.src = iframe.src;
            }

            // Go to home preview
            function goHome() {
                window.location.href = '/preview/hero-section';
            }

            // Open in new tab
            function openInNewTab() {
                const url = document.getElementById('url-input').value;
                window.open(url, '_blank');
            }

            // Save section data
            async function saveSection(event, sectionId) {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);
                const alertSuccess = document.getElementById('alert-' + sectionId + '-success');
                const alertError = document.getElementById('alert-' + sectionId + '-error');

                try {
                    // Use the unified HomePageController update method for all sections
                    let routeUrl = '/admin/cms-section/home-page/' + sectionId;

                    // Handle file uploads
                    const fileInputs = form.querySelectorAll('input[type="file"]');
                    for (const fileInput of fileInputs) {
                        if (fileInput.files && fileInput.files[0]) {
                            const file = fileInput.files[0];
                            formData.append(fileInput.name, file);
                        }
                    }

                    // Remove Dropify inputs from formData (they're handled separately)
                    // and process them
                    const dropifyInputs = form.querySelectorAll('.dropify, .dropify-brand, .dropify-partner');
                    for (const dropifyInput of dropifyInputs) {
                        // Skip if a new file was selected so we keep the actual File object in formData
                        if (dropifyInput.files && dropifyInput.files.length > 0) {
                            continue;
                        }

                        const fileName = dropifyInput.name;
                        const correspondingHidden = document.getElementById(fileName.replace('_dropify', '_url'));

                        if (correspondingHidden && correspondingHidden.value) {
                            formData.set(fileName, correspondingHidden.value);
                        } else if (dropifyInput.dataset.defaultFile) {
                            formData.set(fileName, dropifyInput.dataset.defaultFile);
                        }
                    }

                    showLoading();

                    const response = await fetch(routeUrl, {
                        method: 'PUT',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success || response.ok) {
                        if (alertSuccess) {
                            alertSuccess.style.display = 'block';
                            alertSuccess.innerHTML = '<strong>Success!</strong> ' + (result.message || 'Section saved successfully.');
                            setTimeout(() => {
                                alertSuccess.style.display = 'none';
                            }, 3000);
                        }
                        // Reload preview
                        reloadPage();
                    } else {
                        throw new Error(result.message || 'Failed to save section');
                    }
                } catch (error) {
                    console.error('Error saving section:', error);
                    if (alertError) {
                        alertError.style.display = 'block';
                        alertError.innerHTML = '<strong>Error!</strong> ' + error.message;
                        setTimeout(() => {
                            alertError.style.display = 'none';
                        }, 5000);
                    }
                } finally {
                    hideLoading();
                }
            }

            // Add new partner
            window.addNewPartner = function() {
                const container = document.getElementById('partners-container');
                const maxPartners = 6;

                if (!container) {
                    console.error('Partners container not found');
                    return;
                }

                // Count ALL .cms-value-item elements currently in the container
                const currentCount = container.querySelectorAll('.cms-value-item').length;
                const remainingSlots = maxPartners - currentCount;

                console.log('=== addNewPartner called ===');
                console.log('Current partners in container:', currentCount);
                console.log('Max partners:', maxPartners);
                console.log('Remaining slots:', remainingSlots);

                // Check if we can add more partners
                if (currentCount >= maxPartners) {
                    alert(`Maximum ${maxPartners} partners allowed. You have reached the limit (${currentCount}/${maxPartners}).`);
                    console.log('❌ Cannot add partner - limit reached');
                    return;
                }

                if (remainingSlots <= 0) {
                    alert(`Cannot add more partners. Maximum ${maxPartners} allowed. Current: ${currentCount}`);
                    console.log('❌ Cannot add partner - no remaining slots');
                    return;
                }

                console.log('✓ Partner addition allowed');

                // Find the next available sequential ID
                let newId = 1;
                const existingPartners = container.querySelectorAll('.cms-value-item');
                existingPartners.forEach(partner => {
                    const inputs = partner.querySelectorAll('input[name^="partners["]');
                    inputs.forEach(input => {
                        const match = input.name.match(/partners\[(\d+)\]/);
                        if (match) {
                            const id = parseInt(match[1]);
                            if (id >= newId) {
                                newId = id + 1;
                            }
                        }
                    });
                });

                console.log('🔍 Next sequential ID:', newId);
                const partnerHtml = `
                    <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative;">
                        <button type="button" onclick="this.parentElement.remove(); updatePartnersCounter();" style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #ef4444; border: none; border-radius: 0.25rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <input type="hidden" name="delete_partner_${newId}" id="delete_partner_${newId}" value="">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Partner Logo</label>
                            <input type="file"
                                   name="partner_logo_${newId}_dropify"
                                   id="partner_logo_${newId}_dropify"
                                   class="dropify-partner"
                                   accept="image/*"
                                   data-default-file=""
                                   data-max-width="3000"
                                   data-max-height="3000"
                                   data-show-remove="true"
                                   data-show-errors="true">

                            <input type="hidden" name="partners[${newId}][logo]" id="partner_logo_${newId}_url" value="">
                            <div style="margin-top: 0.5rem; font-size: 0.7rem; color: #64748b;">Upload an image or use a URL/emoji via Dropify</div>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Partner Name</label>
                            <input type="text" name="partners[${newId}][name]" class="cms-form-input" placeholder="Partner Name">
                        </div>
                    </div>
                `;

                // Remove empty state message if present
                const noPartnersMsg = document.getElementById('no-partners-message');
                if (noPartnersMsg) {
                    noPartnersMsg.remove();
                }

                // Insert inside the partners-container (as last child)
                console.log('🔍 BEFORE insertion - Current DOM count:', container.querySelectorAll('.cms-value-item').length);
                console.log('🔍 Container exists:', !!container);
                console.log('🔍 Adding new partner INSIDE container');

                // Use 'beforeend' to add as the last child of the container
                container.insertAdjacentHTML('beforeend', partnerHtml);

                console.log('🔍 AFTER insertion - DOM count:', container.querySelectorAll('.cms-value-item').length);
                console.log('🔍 New HTML added successfully inside container');

                // Initialize Dropify for the new input with proper timing
                setTimeout(() => {
                    console.log('🔍 setTimeout fired - DOM count:', container.querySelectorAll('.cms-value-item').length);
                    // Safety check for jQuery
                    if (typeof $ === 'undefined' || typeof $.fn.dropify === 'undefined') {
                        console.error('jQuery or Dropify not available for new partner initialization');
                        updatePartnersCounter();
                        return;
                    }

                    // Initialize just the new partner dropify
                    const newDropifyElement = $('#partner_logo_' + newId + '_dropify');
                    if (newDropifyElement.length) {
                        try {
                            console.log('Initializing Dropify for new partner:', newId);

                            newDropifyElement.dropify({
                                messages: {
                                    'default': 'Drag and drop a partner logo here or click',
                                    'replace': 'Drag and drop or click to replace',
                                    'remove': 'Remove',
                                    'error': 'Ooops, something wrong happened.'
                                },
                                error: {
                                    'fileSize': 'The file size is too big (max 3MB).',
                                    'minWidth': 'The image width is too small (min 100px).',
                                    'maxWidth': 'The image width is too big (max 3000px).',
                                    'minHeight': 'The image height is too small (min 100px).',
                                    'maxHeight': 'The image height is too big (max 3000px).',
                                    'imageFormat': 'The image format is not allowed.',
                                    'fileExtension': 'The file extension is not allowed.'
                                }
                            }).addClass('dropify-initialized');

                            // Verify initialization
                            const dropifyInstance = newDropifyElement.data('dropify');
                            const wrapper = newDropifyElement.parent('.dropify-wrapper');

                            if (dropifyInstance && wrapper.length > 0) {
                                console.log('✓ New partner Dropify initialized successfully:', newId);

                                // Attach events for this new instance
                                if (typeof attachPartnerDropifyEvents === 'function') {
                                    attachPartnerDropifyEvents();
                                }
                            } else {
                                console.error('✗ Failed to initialize new partner Dropify:', newId);
                            }

                        } catch (e) {
                            console.error('✗ Error initializing new partner Dropify:', newId, e);
                        }
                    } else {
                        console.error('✗ Could not find new partner element:', newId);
                    }

                    // Update counter after partner is added
                    const finalCount = updatePartnersCounter();
                    console.log('=== addNewPartner complete ===');
                    console.log('Final count:', finalCount.actualCount, '/', finalCount.maxPartners);
                    console.log('Can add more:', finalCount.canAdd ? 'Yes' : 'No');
                }, 200); // Allow DOM to settle
            }

            // Delete partner
            window.deletePartner = function(partnerId) {
                if (confirm('Are you sure you want to delete this partner?')) {
                    const deleteInput = document.getElementById('delete_partner_' + partnerId);
                    if (deleteInput) {
                        deleteInput.value = '1';
                    }
                    const partnerElement = deleteInput.closest('.cms-value-item');
                    if (partnerElement) {
                        partnerElement.remove();
                        updatePartnersCounter();
                    }
                }
            }

            // Update partners counter
            window.updatePartnersCounter = function() {
                const container = document.getElementById('partners-container');
                const addButton = document.getElementById('add-partner-btn');
                const maxPartners = 6;

                if (!container) {
                    console.error('❌ Partners container not found');
                    return;
                }

                // Count ALL .cms-value-item elements in the container
                const actualCount = container.querySelectorAll('.cms-value-item').length;
                const remainingSlots = maxPartners - actualCount;

                console.log('=== updatePartnersCounter DEBUG ===');
                console.log('🔍 Container exists:', !!container);
                console.log('🔍 Container children length:', container.children.length);
                console.log('🔍 .cms-value-item elements found:', actualCount);
                console.log('🔍 maxPartners:', maxPartners);
                console.log('🔍 remainingSlots:', remainingSlots);

                // Additional debugging: list all found elements
                const partnerElements = container.querySelectorAll('.cms-value-item');
                console.log('🔍 Partner elements array:', Array.from(partnerElements).map((el, index) => {
                    return { index: index, className: el.className, hasId: !!el.id };
                }));

                console.log('📊 FINAL COUNT - Elements counted:', actualCount);
                console.log('📊 FINAL COUNT - Max partners:', maxPartners);
                console.log('📊 FINAL COUNT - Remaining slots:', remainingSlots);

                // Update counter display
                const counter = document.getElementById('partners-counter');
                if (counter) {
                    counter.textContent = actualCount + '/' + maxPartners;
                    console.log('✅ Counter updated to:', actualCount + '/' + maxPartners);
                }

                // Update add button status with detailed feedback
                const status = document.getElementById('add-partner-status');
                if (status && addButton) {
                    if (actualCount >= maxPartners) {
                        // Maximum reached - disable button
                        status.textContent = 'Maximum partners reached';
                        addButton.style.opacity = '0.5';
                        addButton.style.pointerEvents = 'none';
                        addButton.disabled = true;
                        console.log('✅ Button DISABLED (max reached)');
                    } else if (remainingSlots === 1) {
                        // One slot remaining - enable button
                        status.textContent = '1 partner slot remaining';
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log('✅ Button ENABLED (1 slot remaining)');
                    } else {
                        // Multiple slots remaining - enable button
                        status.textContent = `Click to add a new partner (${remainingSlots} slots remaining)`;
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log(`✅ Button ENABLED (${remainingSlots} slots remaining)`);
                    }
                }

                console.log('=== updatePartnersCounter complete ===\n');

                return {
                    actualCount: actualCount,
                    maxPartners: maxPartners,
                    remainingSlots: remainingSlots,
                    canAdd: actualCount < maxPartners
                };
            }

            // Initialize: Set Hero section as active by default
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, checking jQuery availability...');

                // Verify jQuery is available
                if (typeof $ === 'undefined') {
                    console.error('jQuery not available on DOM load');
                    // Try to restore from window
                    if (typeof window.jQuery !== 'undefined') {
                        window.$ = window.jQuery;
                        console.log('jQuery restored from window.jQuery');
                    }
                } else {
                    console.log('jQuery available on DOM load, version:', $.fn.jquery);
                }

                // Initialize partners counter on page load
                initializePartnersCounter();

                // Initialize certifications counter
                if (typeof initializeCertificationsCounter === 'function') {
                    initializeCertificationsCounter();
                }

                // Don't initialize Dropify on page load for hidden sections
                // Dropify will be initialized when sections are opened
                // Only initialize visible sections (Hero section by default)

                // Open Hero section by default (which will initialize its Dropify instances)
                setTimeout(() => {
                    const heroHeader = document.querySelector('button[onclick="toggleSection(\'hero\')"]');
                    if (heroHeader) {
                        console.log('Opening Hero section by default');
                        // Manually trigger the hero section opening
                        const heroContent = document.getElementById('hero-content');
                        if (heroContent) {
                            heroContent.style.display = 'block';
                            heroHeader.classList.add('active');

                            // Initialize hero section Dropify instances
                            setTimeout(() => {
                                if (typeof window.initializeAllDropify === 'function') {
                                    window.initializeAllDropify();
                                    console.log('Hero section Dropify instances initialized');
                                } else {
                                    console.error('initializeAllDropify function not available');
                                }
                            }, 100);
                        }
                    }
                }, 100);
            });

            // Initialize partners counter on page load
            function initializePartnersCounter() {
                const addButton = document.getElementById('add-partner-btn');
                const container = document.getElementById('partners-container');
                if (!addButton || !container) return;

                // Count ALL .cms-value-item elements in the container
                const actualCount = container.querySelectorAll('.cms-value-item').length;
                const maxPartners = parseInt(addButton.dataset.maxPartners || '6');
                const remainingSlots = maxPartners - actualCount;

                console.log('=== initializePartnersCounter ===');
                console.log('Elements in container:', actualCount);
                console.log('Max partners:', maxPartners);
                console.log('Remaining slots:', remainingSlots);

                // Update counter display
                const counter = document.getElementById('partners-counter');
                if (counter) {
                    counter.textContent = actualCount + '/' + maxPartners;
                }

                // Update add button status based on actual count
                const status = document.getElementById('add-partner-status');
                if (status) {
                    if (actualCount >= maxPartners) {
                        // Maximum reached - disable button
                        status.textContent = 'Maximum partners reached';
                        addButton.style.opacity = '0.5';
                        addButton.style.pointerEvents = 'none';
                        addButton.disabled = true;
                        console.log('✓ Maximum reached on init - Button disabled');
                    } else if (remainingSlots === 1) {
                        // One slot remaining - enable button
                        status.textContent = '1 partner slot remaining';
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log('✓ 1 slot remaining on init - Button enabled');
                    } else {
                        // Multiple slots remaining - enable button
                        status.textContent = `Click to add a new partner (${remainingSlots} slots remaining)`;
                        addButton.style.opacity = '1';
                        addButton.style.pointerEvents = 'auto';
                        addButton.disabled = false;
                        console.log(`✓ ${remainingSlots} slots remaining on init - Button enabled`);
                    }
                }

                console.log('=== initializePartnersCounter complete ===\n');
                return {
                    actualCount: actualCount,
                    maxPartners: maxPartners,
                    remainingSlots: remainingSlots
                };
            }
        </script>

        <!-- Fallback: Ensure Core Values functions are defined -->
        <script>
            // Debug: Check if functions are already defined
            console.log('=== Fallback Check ===');
            console.log('addNewCoreValue already defined?', typeof window.addNewCoreValue !== 'undefined');

            // These should already be defined from cms_app layout, but just in case:
            if (typeof window.addNewCoreValue === 'undefined') {
                console.warn('addNewCoreValue not defined, creating fallback');
                window.addNewCoreValue = function() {
                    console.log('Fallback addNewCoreValue called');
                    alert('Core Values functionality is loading. Please try again in a moment.');
                };
            }

            if (typeof window.deleteCoreValue === 'undefined') {
                console.warn('deleteCoreValue not defined, creating fallback');
                window.deleteCoreValue = function(id) {
                    console.log('Fallback deleteCoreValue called');
                    alert('Core Values functionality is loading. Please try again in a moment.');
                };
            }

            if (typeof window.checkCoreValuesLimit === 'undefined') {
                window.checkCoreValuesLimit = function() {
                    console.log('Fallback checkCoreValuesLimit called');
                };
            }

            console.log('Fallback check complete');
            console.log('addNewCoreValue type:', typeof window.addNewCoreValue);
        </script>
    </x-slot:scripts>

</x-layouts.cms_app>







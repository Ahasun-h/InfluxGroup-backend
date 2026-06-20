<x-layouts.app title="Services & Solutions Page Content">
    <x-slot:styles>
        <!-- Load Dropify dependencies -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
        <script src="{{ asset('js/dropify.min.js') }}"></script>

        <style>
            :root {
                --industrial-blue: #0066CC;
                --industrial-dark: #1a1f2e;
                --industrial-light: #f8fafc;
                --industrial-red: #dc2626;
            }

            /* Page styling */
            .services-solutions-admin {
                background: var(--industrial-light);
                min-height: 100vh;
            }

            /* Header Section - Matching frontend hero */
            .admin-header {
                background: var(--industrial-dark);
                color: white;
                padding: 3rem 0;
                position: relative;
                overflow: hidden;
                border-bottom: 4px solid var(--industrial-blue);
            }

            .admin-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(0, 102, 204, 0.2) 0%, transparent 100%);
            }

            .admin-header-content {
                position: relative;
                z-index: 1;
            }

            .admin-badge {
                background: var(--industrial-blue);
                color: white;
                padding: 0.25rem 0.75rem;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.3em;
                border-radius: 0.25rem;
            }

            .admin-title {
                font-family: 'Arial Black', sans-serif;
                font-weight: 900;
                text-transform: uppercase;
                font-style: italic;
                line-height: 0.9;
                font-size: 2.5rem;
                margin: 0.5rem 0;
            }

            /* Section cards matching frontend */
            .admin-section {
                background: white;
                border-radius: 0.75rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
                margin-bottom: 2rem;
                overflow: hidden;
            }

            .admin-section-header {
                background: var(--industrial-dark);
                color: white;
                padding: 1.5rem;
                border-left: 4px solid var(--industrial-blue);
            }

            .admin-section-title {
                font-family: 'Arial Black', sans-serif;
                font-weight: 900;
                text-transform: uppercase;
                font-style: italic;
                font-size: 1.25rem;
                margin: 0;
            }

            .admin-section-body {
                padding: 2rem;
            }

            /* Dark section styling */
            .admin-section-dark {
                background: var(--industrial-dark);
                color: white;
            }

            .admin-section-dark .admin-section-header {
                background: rgba(0, 102, 204, 0.1);
                border-left-color: var(--industrial-blue);
            }

            .admin-section-dark .admin-section-title {
                color: white;
            }

            .admin-section-dark .admin-section-body {
                background: rgba(26, 31, 46, 0.5);
                color: white;
            }

            /* Form inputs */
            .admin-input {
                background: var(--industrial-light);
                border: 2px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--industrial-dark);
                width: 100%;
                transition: all 0.2s ease;
            }

            .admin-input:focus {
                outline: none;
                border-color: var(--industrial-blue);
                box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
            }

            .admin-textarea {
                background: var(--industrial-light);
                border: 2px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--industrial-dark);
                width: 100%;
                transition: all 0.2s ease;
                resize: vertical;
                min-height: 80px;
            }

            .admin-textarea:focus {
                outline: none;
                border-color: var(--industrial-blue);
                box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
            }

            .admin-label {
                color: #475569;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                margin-bottom: 0.5rem;
                display: block;
            }

            .admin-section-dark .admin-label {
                color: rgba(255, 255, 255, 0.8);
            }

            /* Step cards */
            .admin-step-card {
                background: linear-gradient(135deg, rgba(0, 102, 204, 0.05) 0%, rgba(26, 31, 46, 0.02) 100%);
                border: 2px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 1.5rem;
                transition: all 0.2s ease;
            }

            .admin-step-card:hover {
                border-color: var(--industrial-blue);
                background: linear-gradient(135deg, rgba(0, 102, 204, 0.1) 0%, rgba(26, 31, 46, 0.05) 100%);
            }

            .admin-step-number {
                font-family: 'Arial Black', sans-serif;
                font-weight: 900;
                font-size: 3rem;
                color: rgba(0, 102, 204, 0.3);
                line-height: 1;
                margin-bottom: 0.5rem;
            }

            .admin-section-dark .admin-step-number {
                color: rgba(0, 102, 204, 0.5);
            }

            /* Industry cards */
            .admin-industry-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
                margin-top: 1rem;
            }

            .admin-industry-card {
                background: white;
                border: 2px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 1.5rem;
                text-align: center;
                transition: all 0.2s ease;
            }

            .admin-industry-card:hover {
                border-color: var(--industrial-blue);
                background: rgba(0, 102, 204, 0.05);
            }

            .admin-industry-icon {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }

            /* Buttons */
            .admin-btn {
                background: var(--industrial-blue);
                color: white;
                font-family: 'Arial Black', sans-serif;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                padding: 0.75rem 2rem;
                border-radius: 0.25rem;
                border: none;
                box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .admin-btn:hover {
                background: var(--industrial-dark);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
            }

            .admin-btn-secondary {
                background: var(--industrial-light);
                color: var(--industrial-dark);
                border: 2px solid #e2e8f0;
                box-shadow: none;
            }

            .admin-btn-secondary:hover {
                background: #e2e8f0;
                border-color: var(--industrial-blue);
            }

            /* CTA Section styling */
            .admin-cta-section {
                background: var(--industrial-blue);
                color: white;
                text-align: center;
                border-left: none;
            }

            .admin-cta-section .admin-section-header {
                background: rgba(0, 0, 0, 0.1);
                border-left: none;
            }

            .admin-cta-section .admin-section-body {
                background: rgba(0, 0, 0, 0.05);
                color: white;
            }

            .admin-cta-section .admin-label {
                color: rgba(255, 255, 255, 0.9);
            }

            .admin-cta-section .admin-input,
            .admin-cta-section .admin-textarea {
                background: white;
                color: var(--industrial-dark);
            }

            /* Why Choose Us split layout */
            .admin-split-section {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                align-items: start;
            }

            @media (max-width: 768px) {
                .admin-split-section {
                    grid-template-columns: 1fr;
                }
            }

            .admin-image-preview {
                background: var(--industrial-light);
                border: 2px dashed #cbd5e1;
                border-radius: 0.75rem;
                padding: 2rem;
                text-align: center;
                min-height: 300px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Dropify styling */
            .dropify-wrapper {
                background: var(--industrial-light);
                border: 2px dashed #cbd5e1;
                border-radius: 0.75rem;
                transition: all 0.2s ease;
                overflow: hidden;
            }

            .dropify-wrapper:hover {
                border-color: var(--industrial-blue);
                background: rgba(0, 102, 204, 0.05);
            }

            .dropify-message {
                padding: 2rem 1rem;
                color: #64748b;
            }

            .dropify-message span {
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }

            .dropify-preview {
                background: var(--industrial-dark);
            }

            .dropify-clear {
                background: var(--industrial-red);
                color: white;
                border: none;
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .dropify-clear:hover {
                background: #b91c1c;
            }

            .dropify-error {
                background: rgba(220, 38, 38, 0.1);
                border-color: var(--industrial-red);
                color: #fca5a5;
            }
        </style>
    </x-slot:styles>

    <div class="services-solutions-admin">
        <!-- Hero Header Section -->
        <header class="admin-header">
            <div class="max-w-7xl mx-auto px-6 admin-header-content">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-px w-12 bg-[#0066CC]"></div>
                    <span class="admin-badge">CMS ADMINISTRATION</span>
                </div>
                <h1 class="admin-title">Services & Solutions Page</h1>
                <p class="text-slate-400 text-lg mt-4">
                    Manage page content, sections, and visual elements to match your frontend design
                </p>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-6 py-8">
            <form action="{{ route('admin.services-solutions-page.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Hero Section - Dark Theme -->
                <div class="admin-section admin-section-dark">
                    <div class="admin-section-header">
                        <h2 class="admin-section-title">Hero Section</h2>
                    </div>
                    <div class="admin-section-body">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-3">
                                <label for="hero_badge" class="admin-label">Badge Text</label>
                                <input type="text" name="hero_badge" id="hero_badge"
                                    value="{{ old('hero_badge', $pageItems['hero_badge_text']->section_content ?? 'What We Offer') }}"
                                    class="admin-input" placeholder="What We Offer">
                                <x-input-error :messages="$errors->get('hero_badge')" class="mt-2" />
                            </div>

                            <div class="lg:col-span-3">
                                <label for="hero_title" class="admin-label">Hero Title</label>
                                <input type="text" name="hero_title" id="hero_title"
                                    value="{{ old('hero_title', $pageItems['hero_title']->section_content ?? 'SERVICES & <span class=\'text-industrial-blue\'>SOLUTIONS</span>') }}"
                                    class="admin-input" placeholder="SERVICES & SOLUTIONS">
                                <x-input-error :messages="$errors->get('hero_title')" class="mt-2" />
                            </div>

                            <div class="lg:col-span-3">
                                <label for="hero_description" class="admin-label">Hero Description</label>
                                <textarea name="hero_description" id="hero_description" rows="4"
                                    class="admin-textarea">{{ old('hero_description', $pageItems['hero_description']->section_content ?? 'Comprehensive engineering services and tailored solutions from concept to commissioning, ensuring your power infrastructure operates at peak performance.') }}</textarea>
                                <x-input-error :messages="$errors->get('hero_description')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Section - Dark Theme -->
                <div class="admin-section admin-section-dark">
                    <div class="admin-section-header">
                        <h2 class="admin-section-title">Our Process Section</h2>
                    </div>
                    <div class="admin-section-body">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="process_title" class="admin-label">Process Title</label>
                                <input type="text" name="process_title" id="process_title"
                                    value="{{ old('process_title', $pageItems['process_title']->section_content ?? 'Our <span class=\'text-industrial-blue\'>Process</span>') }}"
                                    class="admin-input" placeholder="Our Process">
                                <x-input-error :messages="$errors->get('process_title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="process_description" class="admin-label">Process Description</label>
                                <input type="text" name="process_description" id="process_description"
                                    value="{{ old('process_description', $pageItems['process_description']->section_content ?? 'A systematic approach to delivering excellence in every project') }}"
                                    class="admin-input" placeholder="A systematic approach...">
                                <x-input-error :messages="$errors->get('process_description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="admin-label mb-4">Process Steps</div>
                        @php
                            $processSteps = json_decode($pageItems['process_steps']->section_content ?? '[]', true);
                            $defaultSteps = [
                                ['step' => '01', 'title' => 'Consultation', 'description' => 'Understanding your requirements and developing customized solutions'],
                                ['step' => '02', 'title' => 'Design', 'description' => 'Engineering detailed designs and specifications for optimal performance'],
                                ['step' => '03', 'title' => 'Implementation', 'description' => 'Executing projects with precision and adherence to timelines'],
                                ['step' => '04', 'title' => 'Support', 'description' => 'Providing ongoing maintenance and technical support throughout lifecycle']
                            ];
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @for($i = 1; $i <= 4; $i++)
                                <div class="admin-step-card text-center">
                                    <div class="admin-step-number">{{ old('step'.$i.'_number', $processSteps[$i-1]['step'] ?? $defaultSteps[$i-1]['step']) }}</div>
                                    <div class="mb-4">
                                        <input type="text" name="step{{ $i }}_title"
                                            value="{{ old('step'.$i.'_title', $processSteps[$i-1]['title'] ?? $defaultSteps[$i-1]['title']) }}"
                                            class="admin-input text-center font-bold" placeholder="Step {{ $i }} Title">
                                    </div>
                                    <div>
                                        <textarea name="step{{ $i }}_description" rows="3"
                                            class="admin-textarea text-sm">{{ old('step'.$i.'_description', $processSteps[$i-1]['description'] ?? $defaultSteps[$i-1]['description']) }}</textarea>
                                    </div>
                                    <input type="hidden" name="step{{ $i }}_number"
                                        value="{{ old('step'.$i.'_number', $processSteps[$i-1]['step'] ?? $defaultSteps[$i-1]['step']) }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Industries Section - Light Theme -->
                <div class="admin-section">
                    <div class="admin-section-header">
                        <h2 class="admin-section-title">Industries Section</h2>
                    </div>
                    <div class="admin-section-body">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="industries_title" class="admin-label">Industries Title</label>
                                <input type="text" name="industries_title" id="industries_title"
                                    value="{{ old('industries_title', $pageItems['industries_title']->section_content ?? 'Industries We <span class=\'text-industrial-blue\'>Serve</span>') }}"
                                    class="admin-input" placeholder="Industries We Serve">
                                <x-input-error :messages="$errors->get('industries_title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="industries_description" class="admin-label">Industries Description</label>
                                <input type="text" name="industries_description" id="industries_description"
                                    value="{{ old('industries_description', $pageItems['industries_description']->section_content ?? 'Delivering specialized solutions across diverse sectors') }}"
                                    class="admin-input" placeholder="Delivering specialized solutions...">
                                <x-input-error :messages="$errors->get('industries_description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="admin-label mb-4">Industries Grid ({{ preg_match('/[^0-9]/', $pageItems['industries_list']->section_content ?? '') ? '6' : '6' }} items)</div>
                        @php
                            $industriesList = json_decode($pageItems['industries_list']->section_content ?? '[]', true);
                            $defaultIndustries = [
                                ['name' => 'Power Generation', 'icon' => 'Zap'],
                                ['name' => 'Textile', 'icon' => 'Factory'],
                                ['name' => 'Pharmaceuticals', 'icon' => 'Building2'],
                                ['name' => 'Construction', 'icon' => 'Building2'],
                                ['name' => 'Food Processing', 'icon' => 'Factory'],
                                ['name' => 'Telecom', 'icon' => 'Zap']
                            ];
                        @endphp
                        <div class="admin-industry-grid">
                            @for($i = 1; $i <= 6; $i++)
                                <div class="admin-industry-card">
                                    <div class="admin-industry-icon">
                                        @if(($industriesList[$i-1]['icon'] ?? $defaultIndustries[$i-1]['icon']) === 'Zap') ⚡
                                        @elseif(($industriesList[$i-1]['icon'] ?? $defaultIndustries[$i-1]['icon']) === 'Factory') 🏭
                                        @elseif(($industriesList[$i-1]['icon'] ?? $defaultIndustries[$i-1]['icon']) === 'Building2') 🏢
                                        @else ⚙️
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="industry{{ $i }}_name"
                                            value="{{ old('industry'.$i.'_name', $industriesList[$i-1]['name'] ?? $defaultIndustries[$i-1]['name']) }}"
                                            class="admin-input text-center font-bold text-sm">
                                    </div>
                                    <div>
                                        <select name="industry{{ $i }}_icon" class="admin-input text-sm">
                                            <option value="">Select Icon</option>
                                            <option value="Zap" {{ ($industriesList[$i-1]['icon'] ?? $defaultIndustries[$i-1]['icon']) === 'Zap' ? 'selected' : '' }}>⚡ Zap</option>
                                            <option value="Factory" {{ ($industriesList[$i-1]['icon'] ?? $defaultIndustries[$i-1]['icon']) === 'Factory' ? 'selected' : '' }}>🏭 Factory</option>
                                            <option value="Building2" {{ ($industriesList[$i-1]['icon'] ?? $defaultIndustries[$i-1]['icon']) === 'Building2' ? 'selected' : '' }}>🏢 Building2</option>
                                            <option value="Users" {{ ($industriesList[$i-1]['icon'] ?? '') === 'Users' ? 'selected' : '' }}>👥 Users</option>
                                            <option value="Wrench" {{ ($industriesList[$i-1]['icon'] ?? '') === 'Wrench' ? 'selected' : '' }}>🔧 Wrench</option>
                                            <option value="Cog" {{ ($industriesList[$i-1]['icon'] ?? '') === 'Cog' ? 'selected' : '' }}>⚙️ Cog</option>
                                        </select>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Why Choose Us Section - Split Layout -->
                <div class="admin-section">
                    <div class="admin-section-header">
                        <h2 class="admin-section-title">Why Choose Us Section</h2>
                    </div>
                    <div class="admin-section-body">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="why_choose_us_title" class="admin-label">Section Title</label>
                                <input type="text" name="why_choose_us_title" id="why_choose_us_title"
                                    value="{{ old('why_choose_us_title', $pageItems['why_choose_us_title']->section_content ?? 'Why Choose <span class=\'text-industrial-blue\'>Influx Group?</span>') }}"
                                    class="admin-input" placeholder="Why Choose Influx Group?">
                                <x-input-error :messages="$errors->get('why_choose_us_title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="stat_number" class="admin-label">Stat Number</label>
                                <input type="text" name="stat_number" id="stat_number"
                                    value="{{ old('stat_number', $pageItems['stat_number']->section_content ?? '24/7') }}"
                                    class="admin-input" placeholder="24/7">
                                <x-input-error :messages="$errors->get('stat_number')" class="mt-2" />
                            </div>
                        </div>

                        <div class="admin-split-section">
                            <div>
                                <div class="admin-label mb-4">Key Points</div>
                                @php
                                    $whyChooseUsPoints = json_decode($pageItems['why_choose_us_points']->section_content ?? '[]', true);
                                    $defaultPoints = [
                                        ['title' => '45+ Years of Excellence', 'description' => 'Decades of experience in delivering power infrastructure solutions across Bangladesh.'],
                                        ['title' => 'Expert Engineering Team', 'description' => 'Highly skilled professionals with expertise in power systems and renewable energy.'],
                                        ['title' => 'Quality Assurance', 'description' => 'ISO 9001:2015 certified processes ensuring highest quality standards.'],
                                        ['title' => '24/7 Support', 'description' => 'Round-the-clock technical support and maintenance services.']
                                    ];
                                @endphp
                                @for($i = 1; $i <= 4; $i++)
                                    <div class="admin-step-card mb-4" style="border-left: 3px solid #0066CC;">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-[#0066CC] rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <input type="text" name="point{{ $i }}_title"
                                                    value="{{ old('point'.$i.'_title', $whyChooseUsPoints[$i-1]['title'] ?? $defaultPoints[$i-1]['title']) }}"
                                                    class="admin-input font-bold text-sm mb-2" placeholder="Point {{ $i }} Title">
                                                <textarea name="point{{ $i }}_description" rows="2"
                                                    class="admin-textarea text-sm">{{ old('point'.$i.'_description', $whyChooseUsPoints[$i-1]['description'] ?? $defaultPoints[$i-1]['description']) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div>
                                <div class="admin-label mb-4">Section Image</div>
                                <div class="admin-image-preview">
                                    <input type="file" name="why_choose_us_image" id="why_choose_us_image" class="dropify" accept="image/*" />
                                    @php
                                        $mediaFiles = json_decode($pageItems['why_choose_us_image']->media_files ?? '[]', true);
                                        $currentImage = $mediaFiles['source_file'] ?? null;
                                    @endphp
                                    @if($currentImage)
                                        <input type="hidden" name="why_choose_us_image" value="{{ $currentImage }}" />
                                    @endif
                                </div>
                                <x-input-error :messages="$errors->get('why_choose_us_image')" class="mt-2" />

                                <div class="mt-6">
                                    <label for="stat_label" class="admin-label">Stat Label</label>
                                    <input type="text" name="stat_label" id="stat_label"
                                        value="{{ old('stat_label', $pageItems['stat_label']->section_content ?? 'Support Available') }}"
                                        class="admin-input" placeholder="Support Available">
                                    <x-input-error :messages="$errors->get('stat_label')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Section - Blue Theme -->
                <div class="admin-section admin-cta-section">
                    <div class="admin-section-header">
                        <h2 class="admin-section-title">CTA Section</h2>
                    </div>
                    <div class="admin-section-body">
                        <div class="max-w-4xl mx-auto text-center">
                            <div class="mb-8">
                                <label for="cta_title" class="admin-label">CTA Title</label>
                                <input type="text" name="cta_title" id="cta_title"
                                    value="{{ old('cta_title', $pageItems['cta_title']->section_content ?? 'Ready to Get <span class=\'text-yellow-400\'>Started?</span>') }}"
                                    class="admin-input text-center text-xl font-bold" placeholder="Ready to Get Started?">
                                <x-input-error :messages="$errors->get('cta_title')" class="mt-2" />
                            </div>

                            <div class="mb-8">
                                <label for="cta_description" class="admin-label">CTA Description</label>
                                <input type="text" name="cta_description" id="cta_description"
                                    value="{{ old('cta_description', $pageItems['cta_description']->section_content ?? 'Contact our team to discuss your power infrastructure needs') }}"
                                    class="admin-input text-center" placeholder="Contact our team...">
                                <x-input-error :messages="$errors->get('cta_description')" class="mt-2" />
                            </div>

                            <div class="mb-8">
                                <label for="cta_button_text" class="admin-label">Button Text</label>
                                <input type="text" name="cta_button_text" id="cta_button_text"
                                    value="{{ old('cta_button_text', $pageItems['cta_button_text']->section_content ?? 'Request Consultation') }}"
                                    class="admin-input text-center font-bold" placeholder="Request Consultation">
                                <x-input-error :messages="$errors->get('cta_button_text')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center py-8">
                    <button type="submit" class="admin-btn">
                        Save Content Changes
                    </button>
                    <a href="{{ route('admin.cms-section.contact-section') }}" class="admin-btn admin-btn-secondary">
                        ← Back to CMS
                    </a>
                </div>
            </form>
        </div>
    </div>

    <x-slot:scripts>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for jQuery and Dropify to load
            var checkJQuery = setInterval(function() {
                if (typeof jQuery !== 'undefined') {
                    clearInterval(checkJQuery);
                    var $ = jQuery;

                    // Wait for Dropify to load
                    var checkDropify = setInterval(function() {
                        if (typeof $.fn.dropify !== 'undefined') {
                            clearInterval(checkDropify);
                            console.log('Dropify loaded! Initializing...');

                            // Initialize Dropify for file inputs with current image
                            @if($pageItems['why_choose_us_image'] ?? null)
                                @php
                                    $mediaFiles = json_decode($pageItems['why_choose_us_image']->media_files ?? '[]', true);
                                    $currentImage = $mediaFiles['source_file'] ?? null;
                                @endphp
                                @if($currentImage)
                                    var currentImageUrl = '{{ asset('uploads/services-solutions-page/' . basename($currentImage)) }}';
                                    $('#why_choose_us_image').dropify({
                                        showRemove: true,
                                        showErrors: true,
                                        errorsPosition: 'outside',
                                        defaultFile: currentImageUrl,
                                        messages: {
                                            'default': 'Drag and drop a file here or click',
                                            'replace': 'Drag and drop or click to replace',
                                            'remove': 'Remove',
                                            'error': 'Ooops, something wrong happened.'
                                        }
                                    });
                                @else
                                    $('#why_choose_us_image').dropify({
                                        showRemove: true,
                                        showErrors: true,
                                        errorsPosition: 'outside',
                                        messages: {
                                            'default': 'Drag and drop a file here or click',
                                            'replace': 'Drag and drop or click to replace',
                                            'remove': 'Remove',
                                            'error': 'Ooops, something wrong happened.'
                                        }
                                    });
                                @endif
                            @else
                                $('#why_choose_us_image').dropify({
                                    showRemove: true,
                                    showErrors: true,
                                    errorsPosition: 'outside',
                                    defaultFile: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                                    messages: {
                                        'default': 'Drag and drop a file here or click',
                                        'replace': 'Drag and drop or click to replace',
                                        'remove': 'Remove',
                                        'error': 'Ooops, something wrong happened.'
                                    }
                                });
                            @endif

                            console.log('Dropify initialized on services-solutions page form');
                        } else {
                            console.log('Waiting for Dropify to load...');
                        }
                    }, 200);
                } else {
                    console.log('Waiting for jQuery to load...');
                }
            }, 200);
        });
        </script>
    </x-slot:scripts>
</x-layouts.app>
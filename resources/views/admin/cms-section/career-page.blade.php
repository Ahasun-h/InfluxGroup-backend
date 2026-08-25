<x-layouts.cms_app title="CMS Admin - Career Opportunities Page" :cmsData="$cmsData">
    <x-slot:styles></x-slot:styles>

    <aside class="cms-sidebar">
        <div class="cms-sidebar-header">
            <div class="cms-sidebar-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                CMS Admin
            </div>
            <div class="cms-sidebar-subtitle">Career Page Sections</div>
        </div>

        <nav>
            <!-- Hero Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header active" onclick="toggleSection('hero')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Hero Section
                    </div>
                    <svg class="cms-nav-arrow expanded" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content active" id="hero-content">
                    <div class="alert alert-success" id="alert-hero-success">
                        <strong>Success!</strong> Hero section saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-hero-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="hero-form" class="cms-form" action="/admin/cms-section/career-page/hero" onsubmit="saveCareerSection(event, 'hero')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Badge / Subtitle Text</label>
                            <input type="text" name="badge" class="cms-form-input" value="{{ $cmsData['hero']['badge'] ?? 'Join Our Team' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title (HTML allowed for highlights)</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['hero']['title'] ?? 'Career <span class="text-industrial-blue">Opportunities</span>' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['hero']['description'] ?? 'Build your career with Bangladesh\'s leading engineering conglomerate. Join our team of professionals powering the nation\'s infrastructure development.' }}</textarea>
                        </div>

                        <div class="form-subtitle" style="margin-top: 1.5rem; margin-bottom: 0.75rem; font-weight: 700; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Quick Stat 1</div>
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div>
                                <label class="cms-form-label">Value</label>
                                <input type="text" name="stat1_value" class="cms-form-input" value="{{ $cmsData['hero']['stat1_value'] ?? '45+' }}">
                            </div>
                            <div>
                                <label class="cms-form-label">Label</label>
                                <input type="text" name="stat1_label" class="cms-form-input" value="{{ $cmsData['hero']['stat1_label'] ?? 'Years of Excellence' }}">
                            </div>
                        </div>

                        <div class="form-subtitle" style="margin-top: 1rem; margin-bottom: 0.75rem; font-weight: 700; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Quick Stat 2</div>
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div>
                                <label class="cms-form-label">Value</label>
                                <input type="text" name="stat2_value" class="cms-form-input" value="{{ $cmsData['hero']['stat2_value'] ?? '500+' }}">
                            </div>
                            <div>
                                <label class="cms-form-label">Label</label>
                                <input type="text" name="stat2_label" class="cms-form-input" value="{{ $cmsData['hero']['stat2_label'] ?? 'Technical Professionals' }}">
                            </div>
                        </div>

                        <div class="form-subtitle" style="margin-top: 1rem; margin-bottom: 0.75rem; font-weight: 700; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Quick Stat 3</div>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <label class="cms-form-label">Value</label>
                                <input type="text" name="stat3_value" class="cms-form-input" value="{{ $cmsData['hero']['stat3_value'] ?? '15+' }}">
                            </div>
                            <div>
                                <label class="cms-form-label">Label</label>
                                <input type="text" name="stat3_label" class="cms-form-input" value="{{ $cmsData['hero']['stat3_label'] ?? 'Current Openings' }}">
                            </div>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Hero Section</button>
                    </form>
                </div>
            </div>

            <!-- Contact CTA Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('contact-cta')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact CTA Section
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="contact-cta-content" style="display: none;">
                    <div class="alert alert-success" id="alert-contact-cta-success">
                        <strong>Success!</strong> Contact CTA section saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-contact-cta-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="contact-cta-form" class="cms-form" action="/admin/cms-section/career-page/contact-cta" onsubmit="saveCareerSection(event, 'contact-cta')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Badge / Subtitle Text</label>
                            <input type="text" name="badge" class="cms-form-input" value="{{ $cmsData['cta']['badge'] ?? 'Don\'t See a Matching Role?' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['cta']['title'] ?? 'Ready to <span class="text-industrial-blue">Apply?</span>' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['cta']['description'] ?? 'Send your CV and cover letter to our HR team. We review all applications and contact shortlisted candidates within 2 weeks.' }}</textarea>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Email Address</label>
                            <input type="text" name="email" class="cms-form-input" value="{{ $cmsData['cta']['email'] ?? 'careers@influxgroup.com' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Phone Number</label>
                            <input type="text" name="phone" class="cms-form-input" value="{{ $cmsData['cta']['phone'] ?? '+880 2 987 6543' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Address Text</label>
                            <input type="text" name="address" class="cms-form-input" value="{{ $cmsData['cta']['address'] ?? 'Head Office: Dhaka, Bangladesh' }}">
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Contact CTA Section</button>
                    </form>
                </div>
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
                    <span>Career Page CMS</span>
                </div>
                <h1 class="cms-page-title">Career Opportunities Live Preview</h1>
            </div>
        </div>

        <div class="browser-container">
            <div class="browser-card">
                <div class="browser-toolbar">
                    <div class="browser-buttons">
                        <button onclick="reloadPage()" class="browser-btn" title="Reload page">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                        <button onclick="goHome()" class="browser-btn" title="Go home">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="browser-address-bar">
                        <span class="browser-secure-icon">🔒</span>
                        <input type="text" value="http://localhost:5173/preview/career-opportunities/hero-section" id="url-input" placeholder="Enter preview URL...">
                        <span id="current-section-badge" class="browser-section-badge">Career Hero</span>
                    </div>
                    <button onclick="openInNewTab()" class="browser-btn" title="Open in new tab">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </button>
                </div>

                <div class="browser-content" style="flex:1; display:flex; flex-direction:column; min-height:650px;">
                    <div class="loading-overlay" id="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                    <iframe
                        src="http://localhost:5173/preview/career-opportunities/hero-section"
                        class="browser-iframe"
                        id="browser-iframe"
                        style="flex:1; width:100%; border:none;"
                        onload="hideLoading()"
                        onerror="handleError()">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <x-slot:scripts>
        <script>
            const PREVIEW_BASE_URL = 'http://localhost:5173';

            const sectionPreviewUrls = {
                'hero': PREVIEW_BASE_URL + '/preview/career-opportunities/hero-section',
                'contact-cta': PREVIEW_BASE_URL + '/preview/career-opportunities/contact-cta'
            };

            const sectionPreviewNames = {
                'hero': 'Career Hero',
                'contact-cta': 'Career Contact CTA'
            };

            function showLoading() {
                const overlay = document.getElementById('loading-overlay');
                if (overlay) overlay.style.display = 'flex';
            }

            function hideLoading() {
                const overlay = document.getElementById('loading-overlay');
                if (overlay) overlay.style.display = 'none';
            }

            function handleError() {
                hideLoading();
                console.error('Failed to load preview');
            }

            function toggleSection(sectionId) {
                const content = document.getElementById(sectionId + '-content');
                const header = content ? content.previousElementSibling : null;

                document.querySelectorAll('.cms-nav-header').forEach(h => {
                    h.classList.remove('active');
                    const a = h.querySelector('.cms-nav-arrow');
                    if (a) a.classList.remove('expanded');
                });
                document.querySelectorAll('.cms-nav-content').forEach(c => {
                    c.style.display = 'none';
                    c.classList.remove('active');
                });

                if (header) {
                    header.classList.add('active');
                    const arrow = header.querySelector('.cms-nav-arrow');
                    if (arrow) arrow.classList.add('expanded');
                }
                if (content) {
                    content.style.display = 'block';
                    content.classList.add('active');
                }

                const previewUrl = sectionPreviewUrls[sectionId] || (PREVIEW_BASE_URL + '/preview/career-opportunities/' + sectionId);
                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');

                showLoading();
                if (iframe) iframe.src = previewUrl;
                if (urlInput) urlInput.value = previewUrl;
                if (badge) badge.textContent = sectionPreviewNames[sectionId] || sectionId;
            }

            function reloadPage() {
                const iframe = document.getElementById('browser-iframe');
                showLoading();
                if (iframe) iframe.src = iframe.src;
            }

            function goHome() {
                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');
                showLoading();
                const defaultUrl = PREVIEW_BASE_URL + '/preview/career-opportunities/hero-section';
                if (iframe) iframe.src = defaultUrl;
                if (urlInput) urlInput.value = defaultUrl;
                if (badge) badge.textContent = 'Career Hero';
            }

            function openInNewTab() {
                const urlInput = document.getElementById('url-input');
                const url = urlInput ? urlInput.value : (PREVIEW_BASE_URL + '/preview/career-opportunities/hero-section');
                window.open(url, '_blank');
            }

            async function saveCareerSection(event, sectionId) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);

                const successAlert = document.getElementById(`alert-${sectionId}-success`);
                const errorAlert = document.getElementById(`alert-${sectionId}-error`);

                if (successAlert) successAlert.style.display = 'none';
                if (errorAlert) errorAlert.style.display = 'none';

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Saving...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch(`/admin/cms-section/career-page/${sectionId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        if (successAlert) {
                            successAlert.style.display = 'block';
                            setTimeout(() => { successAlert.style.display = 'none'; }, 3000);
                        }
                        reloadPage();
                    } else {
                        throw new Error(data.message || 'Failed to save section');
                    }
                } catch (err) {
                    console.error('Error saving section:', err);
                    if (errorAlert) {
                        errorAlert.textContent = err.message || 'An error occurred while saving';
                        errorAlert.style.display = 'block';
                    }
                } finally {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            }
        </script>
    </x-slot:scripts>
</x-layouts.cms_app>

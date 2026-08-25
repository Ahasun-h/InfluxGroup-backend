@props(['cmsData' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(file_exists(public_path('css/app.css')))
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <!-- Dropify CSS (Local) -->
    <link rel="stylesheet" href="{{ asset('libs/dropify/dist/css/dropify.min.css') }}">

    <!-- Vue frontend JavaScript removed to prevent console interception conflicts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f1f5f9;
            overflow: hidden;
        }

        .cms-container {
            display: flex;
            height: 100vh;
        }

        /* Left Sidebar Styles */
        .cms-sidebar {
            width: 380px;
            background: #1e293b;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .cms-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .cms-sidebar::-webkit-scrollbar-track {
            background: #0f172a;
        }

        .cms-sidebar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }

        .cms-sidebar-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-bottom: 1px solid #1e40af;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .cms-sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cms-sidebar-subtitle {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.25rem;
        }

        /* Collapsible Items */
        .cms-nav-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .cms-nav-header {
            padding: 1rem 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #e2e8f0;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }

        .cms-nav-header:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .cms-nav-header.active {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border-left: 3px solid #3b82f6;
        }

        .cms-nav-content {
            display: none;
            background: #0f172a;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .cms-nav-content.active {
            display: block;
        }

        .cms-nav-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cms-nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .cms-nav-arrow {
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .cms-nav-arrow.expanded {
            transform: rotate(180deg);
        }

        /* Form Styles in Sidebar */
        .cms-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .cms-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .cms-form-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .cms-form-input,
        .cms-form-textarea {
            width: 100%;
            padding: 0.625rem 0.875rem;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 0.5rem;
            color: #e2e8f0;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .cms-form-input:focus,
        .cms-form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .cms-form-textarea {
            min-height: 80px;
            resize: vertical;
            font-family: inherit;
        }

        .cms-btn {
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            width: 100%;
        }

        .cms-btn-success {
            background: #10b981;
            color: white;
        }

        .cms-btn-success:hover {
            background: #059669;
        }

        .cms-category-item {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 0.5rem;
            padding: 0.875rem;
            margin-bottom: 0.75rem;
        }

        /* Dropify custom styles for dark theme */
        .dropify-wrapper {
            background: #1e293b !important;
            border: 2px dashed #475569 !important;
            border-radius: 0.5rem !important;
            overflow: hidden;
        }

        .dropify-wrapper:hover {
            border-color: #3b82f6 !important;
        }

        .dropify-message {
            color: #94a3b8 !important;
        }

        .dropify-preview {
            background: #0f172a !important;
        }

        .dropify-clear {
            color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.1) !important;
        }

        .dropify-clear:hover {
            background: rgba(239, 68, 68, 0.2) !important;
        }

        .dropify-error {
            color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.1) !important;
        }

        /* Brand-specific Dropify styles */
        .dropify-wrapper.dropify-brand {
            margin-top: 0.5rem;
        }

        /* Partner-specific Dropify styles */
        .dropify-wrapper.dropify-partner {
            min-height: 120px !important;
        }

        .dropify-partner .dropify-preview {
            background: #0f172a !important;
        }

        .dropify-partner .dropify-render img {
            max-width: 100% !important;
            max-height: 100px !important;
            object-fit: contain !important;
        }

        .dropify-partner .dropify-message {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 80px !important;
        }

        /* Ensure Dropify preview images display properly */
        .dropify-preview img {
            width: 100% !important;
            height: auto !important;
            object-fit: contain !important;
        }

        /* Strategic Points Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cms-strategic-point-item {
            transition: all 0.2s ease;
        }

        .cms-strategic-point-item:hover {
            border-color: #3b82f6 !important;
        }

        /* Core Values Items */
        .cms-value-item {
            transition: all 0.2s ease;
            position: relative;
        }

        .cms-value-item:hover {
            border-color: #3b82f6 !important;
        }

        .cms-value-item .delete-button {
            transition: all 0.2s ease;
        }

        .cms-value-item .delete-button:hover {
            background: rgba(239, 68, 68, 0.4) !important;
        }

        /* Add button hover effects */
        button[onclick="addNewCoreValue()"]:hover {
            border-color: #3b82f6 !important;
            background: rgba(59, 130, 246, 0.1) !important;
        }

        button[onclick="addNewCoreValue()"]:hover svg {
            background: #3b82f6 !important;
        }

        button[onclick="addNewCoreValue()"]:hover span:first-child {
            color: #60a5fa !important;
        }

        /* Add button disabled state */
        button[onclick="addNewCoreValue()"]:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
        }

        button[onclick="addNewCoreValue()"]:disabled:hover {
            border-color: #334155 !important;
            background: #0f172a !important;
        }

        button[onclick="addNewCoreValue()"]:disabled:hover svg {
            background: #334155 !important;
        }

        button[onclick="addNewCoreValue()"]:disabled:hover span:first-child {
            color: #94a3b8 !important;
        }

        /* Alert messages styling */
        .cms-alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
        }

        .cms-alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
        }

        /* Value card hover effects */
        .cms-value-item:hover .cms-icon-preview {
            background: rgba(59, 130, 246, 0.2) !important;
        }

        /* Icon preview container */
        .cms-icon-preview {
            transition: all 0.2s ease;
        }

        /* Delete button positioning */
        .cms-value-item {
            position: relative;
        }

        .cms-category-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cms-icon-preview {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #334155;
            border-radius: 0.375rem;
            color: #60a5fa;
            flex-shrink: 0;
        }

        /* Main Content Area - Browser preview */
        .cms-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f8fafc;
        }

        .cms-header {
            background: white;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cms-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .cms-breadcrumb a {
            color: #3b82f6;
            text-decoration: none;
        }

        .cms-breadcrumb a:hover {
            text-decoration: underline;
        }

        .cms-page-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 0.25rem;
        }

        /* Browser Container */
        .browser-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f1f5f9;
            padding: 1.5rem;
        }

        .browser-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .browser-toolbar {
            background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .browser-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .browser-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #cbd5e1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #64748b;
        }

        .browser-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #1e293b;
        }

        .browser-btn:active {
            background: #f1f5f9;
        }

        .browser-address-bar {
            flex: 1;
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 1rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #1e293b;
        }

        .browser-address-bar input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.875rem;
            color: #1e293b;
        }

        .browser-secure-icon {
            color: #10b981;
            font-size: 0.875rem;
        }

        .browser-content,
        .browser-frame-container {
            flex: 1;
            background: white;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 500px;
        }

        .browser-iframe {
            width: 100%;
            height: 100%;
            flex: 1;
            border: none;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #e2e8f0;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.875rem;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #e2e8f0;
        }

        .form-subtitle {
            color: #60a5fa;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #334155;
        }

        /* Browser section badge */
        .browser-section-badge {
            font-size: 0.7rem;
            font-weight: 600;
            background: #3b82f6;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
            white-space: nowrap;
        }
    </style>

    {{ $styles ?? '' }}
</head>
<body>
    <div class="cms-container">
        {{ $slot }}
    </div>


    <script>
        // IMPORTANT: Define critical functions FIRST before any other JavaScript loads
        // This prevents Vue frontend console interception from breaking admin functions

        // Core Values functions - defined early to prevent conflicts

        // Set up nextValueId early
        window.nextValueId = window.nextValueId || 1;

        window.addNewCoreValue = function() {
            console.log('addNewCoreValue called');
            const container = document.getElementById('core-values-container') || document.getElementById('values-container');
            if (!container) {
                console.error('Core values container not found');
                return;
            }

            const addButton = document.querySelector('button[onclick="addNewCoreValue()"]');
            const currentValues = container.querySelectorAll('.cms-value-item:not([style*="display: none"])');
            const actualCount = currentValues.length;
            const maxValues = 4;

            console.log('Current core values count:', actualCount);

            if (actualCount >= maxValues) {
                alert('Maximum limit reached! You can only have up to 4 core values.');
                addButton.disabled = true;
                addButton.style.opacity = '0.5';
                addButton.style.cursor = 'not-allowed';
                return;
            }

            // Enable button if below limit
            if (actualCount < maxValues) {
                addButton.disabled = false;
                addButton.style.opacity = '1';
                addButton.style.cursor = 'pointer';
            }

            const valueId = nextValueId++;
            console.log('Creating new core value with ID:', valueId);

            const div = document.createElement('div');
            div.className = 'cms-value-item';
            div.style.cssText = 'background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative; animation: slideIn 0.3s ease-out;';

            // Build HTML using string concatenation for proper onclick handling
            div.innerHTML =
                '<!-- Delete Button -->' +
                '<button type="button" onclick="deleteCoreValue(' + valueId + ')" style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #ef4444; border: none; border-radius: 0.25rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">' +
                    '<svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' +
                    '</svg>' +
                '</button>' +

                '<input type="hidden" name="delete_value_' + valueId + '" id="delete_value_' + valueId + '" value="">' +

                '<!-- Icon Section -->' +
                '<div class="cms-form-group">' +
                    '<label class="cms-form-label">Icon (SVG)</label>' +
                    '<div style="display: flex; gap: 1rem; align-items: center;">' +
                        '<div class="cms-icon-preview" style="width: 48px; height: 48px; background: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; overflow: hidden;">' +
                            '<div id="icon-preview-' + valueId + '" style="width: 32px; height: 32px; color: #60a5fa;">' +
                                '<svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>' +
                                '</svg>' +
                            '</div>' +
                        '</div>' +
                        '<textarea name="values[' + valueId + '][icon]" id="icon-input-' + valueId + '" rows="4" class="cms-form-input" style="flex: 1; font-family: monospace; font-size: 0.75rem;" placeholder="Paste SVG code..." oninput="updateIconPreview(' + valueId + ', this.value)"></textarea>' +
                    '</div>' +
                '</div>' +

                '<!-- Title Input -->' +
                '<div class="cms-form-group">' +
                    '<label class="cms-form-label">Value Title</label>' +
                    '<input type="text" name="values[' + valueId + '][title]" class="cms-form-input" placeholder="Value Title">' +
                '</div>' +

                '<!-- Description Input -->' +
                '<div class="cms-form-group">' +
                    '<label class="cms-form-label">Value Description</label>' +
                    '<textarea name="values[' + valueId + '][description]" rows="3" class="cms-form-textarea" placeholder="Value description..."></textarea>' +
                '</div>';

            // Insert before the add button
            const addButtonElement = container.lastElementChild;
            if (addButtonElement) {
                container.insertBefore(div, addButtonElement);
            } else {
                container.appendChild(div);
            }

            console.log('New core value item added to DOM');

            // Focus on the first input
            setTimeout(() => {
                const firstInput = div.querySelector('input[name^="values"]');
                if (firstInput) firstInput.focus();
            }, 100);

            // Check limits after adding
            setTimeout(() => {
                if (typeof window.checkCoreValuesLimit === 'function') {
                    window.checkCoreValuesLimit();
                }
            }, 100);
        };

        // Skip duplicate deleteCoreValue definition - using the more complete version later

        window.checkCoreValuesLimit = function() {
            const container = document.getElementById('core-values-container') || document.getElementById('values-container');
            if (!container) return;
            const addButton = document.getElementById('add-core-value-btn') || document.getElementById('add-value-button');
            const statusSpan = document.getElementById('add-value-status') || document.getElementById('add-subtext');
            const counterSpan = document.getElementById('core-values-counter');
            const currentValues = container.querySelectorAll('.cms-value-item:not([style*="display: none"])');
            const maxValues = 4;

            const actualCount = currentValues.length;
            console.log('Core Values check:', actualCount, '/', maxValues);

            // Update counter display
            if (counterSpan) {
                counterSpan.textContent = `\${actualCount}/\${maxValues}`;

                // Change color based on count
                if (actualCount >= maxValues) {
                    counterSpan.style.background = 'rgba(239, 68, 68, 0.2)';
                    counterSpan.style.color = '#ef4444';
                } else {
                    counterSpan.style.background = 'rgba(59, 130, 246, 0.1)';
                    counterSpan.style.color = '#60a5fa';
                }
            }

            // Update button state based on current count
            if (actualCount >= maxValues) {
                addButton.disabled = true;
                addButton.style.opacity = '0.5';
                addButton.style.cursor = 'not-allowed';

                if (statusSpan) {
                    statusSpan.textContent = 'Maximum limit reached (4 values)';
                    statusSpan.style.color = '#ef4444';
                }
            } else {
                addButton.disabled = false;
                addButton.style.opacity = '1';
                addButton.style.cursor = 'pointer';

                const remaining = maxValues - actualCount;

                if (statusSpan) {
                    if (remaining === 1) {
                        statusSpan.textContent = '1 slot remaining';
                        statusSpan.style.color = '#64748b';
                    } else {
                        statusSpan.textContent = `\${remaining} slots remaining`;
                        statusSpan.style.color = '#64748b';
                    }
                }
            }

            console.log(`Core Values: \${actualCount}/\${maxValues} (\${maxValues - actualCount} remaining)`);
        };

        window.updateIconPreview = function(id, svgCode) {
            const previewContainer = document.getElementById(`icon-preview-${id}`);
            if (previewContainer && svgCode.trim()) {
                previewContainer.innerHTML = svgCode;
                console.log('Icon preview updated for ID:', id);
            }
        };

        window.addMissionPoint = function() {
            const container = document.getElementById('mission-points-container');
            if (!container) {
                console.error('Mission points container not found');
                return;
            }

            const div = document.createElement('div');
            div.className = 'cms-strategic-point-item';
            div.style.cssText = 'display: flex; align-items: center; gap: 0.75rem; background: #0f172a; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #334155; animation: slideIn 0.3s ease-out;';

            div.innerHTML = `
                <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <input type="text" name="mission[points][]" class="cms-form-input" placeholder="Add a strategic point..." style="flex: 1;">
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(div);
            div.querySelector('input').focus();
            console.log('Mission point added');
        };

        window.addVisionPoint = function() {
            const container = document.getElementById('vision-points-container');
            if (!container) {
                console.error('Vision points container not found');
                return;
            }

            const div = document.createElement('div');
            div.className = 'cms-strategic-point-item';
            div.style.cssText = 'display: flex; align-items: center; gap: 0.75rem; background: #0f172a; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #334155; animation: slideIn 0.3s ease-out;';

            div.innerHTML = `
                <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <input type="text" name="vision[points][]" class="cms-form-input" placeholder="Add a milestone..." style="flex: 1;">
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(div);
            div.querySelector('input').focus();
            console.log('Vision point added');
        };

        console.log('=== CMS Admin Functions Defined ===');
        console.log('addNewCoreValue:', typeof window.addNewCoreValue);
        console.log('deleteCoreValue:', typeof window.deleteCoreValue);

        // Debug: Script execution test
        console.log('=== CMS Layout Script Started ===');
        console.log('jQuery available:', typeof $ !== 'undefined');

        // Section navigation
        function toggleSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.cms-nav-content').forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all nav items
            document.querySelectorAll('.cms-nav-header').forEach(header => {
                header.classList.remove('active');
                const arrow = header.querySelector('.cms-nav-arrow');
                if (arrow) arrow.classList.remove('expanded');
            });

            // Show selected section
            const targetContent = document.getElementById(sectionId + '-content');
            if (targetContent) {
                targetContent.classList.add('active');
            }

            // Add active class to clicked nav item
            const clickedHeader = event.currentTarget;
            clickedHeader.classList.add('active');
            const arrow = clickedHeader.querySelector('.cms-nav-arrow');
            if (arrow) arrow.classList.add('expanded');
        }

        // Save section function
        function saveSection(event, sectionName) {
            event.preventDefault();

            const form = event.target;
            const alertSuccess = document.getElementById('alert-' + sectionName + '-success');
            const alertError = document.getElementById('alert-' + sectionName + '-error');

            // Hide alerts
            if (alertSuccess) alertSuccess.style.display = 'none';
            if (alertError) alertError.style.display = 'none';

            // Show loading on button
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Saving...';
            submitBtn.disabled = true;

            // Get the appropriate action URL based on section
            let actionUrl = form.getAttribute('action');
            if (!actionUrl) {
                const actionUrls = {
                    'hero': '/admin/hero',
                    'brand-statements': '/admin/brand-statements',
                    'mission-vision': '/admin/mission-vision',
                    'core-values': '/admin/core-values'
                };
                actionUrl = actionUrls[sectionName] || '/admin/hero';
            }

            // Prepare form data
            const formData = new FormData(form);

            // For hero section, handle file upload and additional fields properly
            if (sectionName === 'hero') {
                const fileInput = document.getElementById('background_image_dropify');
                const urlInput = document.getElementById('background_url_input');
                const seoInput = document.getElementById('seo_attributes_input');

                // If file is selected via Dropify, upload it
                if (fileInput && fileInput.files && fileInput.files[0]) {
                    formData.append('background_image_dropify', fileInput.files[0]);
                }
                // If URL is provided, use that
                else if (urlInput && urlInput.value) {
                    formData.append('background_image', urlInput.value);
                }

                // Add SEO attributes
                if (seoInput && seoInput.value) {
                    formData.append('seo_attributes', seoInput.value);
                }
            }

            // For brand-statements section, handle brand image upload properly
            if (sectionName === 'brand-statements') {
                const brandFileInput = document.getElementById('brand_image_dropify');
                const brandUrlInput = document.getElementById('brand_url_input');

                // If file is selected via Dropify, convert to base64 and upload
                if (brandFileInput && brandFileInput.files && brandFileInput.files[0]) {
                    const file = brandFileInput.files[0];

                    // Convert file to base64 data URL
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const base64DataUrl = e.target.result;

                        // Create a new FormData with the base64 data
                        const newFormData = new FormData();
                        // Copy all existing form data
                        for (let [key, value] of formData.entries()) {
                            newFormData.append(key, value);
                        }
                        // Add the base64 image data
                        newFormData.append('image_url', base64DataUrl);

                        // Submit the form with base64 data
                        return fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: newFormData
                        })
                        .then(response => {
                            // Check if response is OK
                            if (response.ok) {
                                // Try to parse as JSON first
                                return response.text().then(text => {
                                    try {
                                        const json = JSON.parse(text);
                                        if (json.success || json.message) {
                                            console.log('Success:', json.message || json.success);
                                        }
                                    } catch (e) {
                                        console.log('Response text:', text);
                                    }
                                    return { success: true, data: text };
                                });
                            } else {
                                // Error response - get the text to see what went wrong
                                return response.text().then(text => {
                                    console.error('Server error:', response.status, text);
                                    throw new Error('Save failed: ' + response.status);
                                });
                            }
                        })
                        .then(result => {
                            if (result.success) {
                                // Show success message
                                if (alertSuccess) {
                                    alertSuccess.style.display = 'block';
                                    setTimeout(() => {
                                        alertSuccess.style.display = 'none';
                                    }, 3000);
                                }

                                // Reload the page to show changes
                                reloadPage();
                            } else {
                                throw new Error('Save failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error saving section:', error);

                            // Show error message with details
                            if (alertError) {
                                alertError.style.display = 'block';
                                alertError.innerHTML = '<strong>Error!</strong> ' + error.message;
                                setTimeout(() => {
                                    alertError.style.display = 'none';
                                }, 5000);
                            }

                            // Reset button
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                        })
                        .finally(() => {
                            // Reset button
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                        });
                    };

                    reader.onerror = function() {
                        // Show error message
                        if (alertError) {
                            alertError.style.display = 'block';
                            alertError.innerHTML = '<strong>Error!</strong> Failed to read image file.';
                            setTimeout(() => {
                                alertError.style.display = 'none';
                            }, 3000);
                        }

                        // Reset button
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    };

                    // Read the file as data URL
                    reader.readAsDataURL(file);

                    // Return early since we're handling submission in the onload callback
                    return;
                }
                // If URL is provided, use that
                else if (brandUrlInput && brandUrlInput.value) {
                    formData.append('image_url', brandUrlInput.value);
                }
            }

            // Submit form using fetch
            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        // Show success message
                        if (alertSuccess) {
                            alertSuccess.style.display = 'block';
                            setTimeout(() => {
                                alertSuccess.style.display = 'none';
                            }, 3000);
                        }

                        // Reload the browser preview to show changes
                        reloadPage();
                    } else {
                        throw new Error('Save failed');
                    }
                })
                .catch(error => {
                    // Show error message
                    if (alertError) {
                        alertError.style.display = 'block';
                        setTimeout(() => {
                            alertError.style.display = 'none';
                        }, 3000);
                    }
                })
                .finally(() => {
                    // Reset button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        }

        // Browser functions
        function reloadPage() {
            const iframe = document.getElementById('browser-iframe');
            const overlay = document.getElementById('loading-overlay');

            // Show loading overlay
            overlay.classList.add('active');

            // Reload the iframe
            iframe.src = iframe.src;
        }

        function goHome() {
            const iframe = document.getElementById('browser-iframe');
            const overlay = document.getElementById('loading-overlay');

            // Show loading overlay
            overlay.classList.add('active');

            // Reset to preview home URL
            iframe.src = 'http://localhost:5173/preview/hero-section';
        }

        function openInNewTab() {
            const iframe = document.getElementById('browser-iframe');
            window.open(iframe.src, '_blank');
        }

        function hideLoading() {
            const overlay = document.getElementById('loading-overlay');
            overlay.classList.remove('active');
        }

        function handleError() {
            const overlay = document.getElementById('loading-overlay');
            overlay.classList.remove('active');

            // Show error message
            const iframe = document.getElementById('browser-iframe');
            iframe.style.display = 'none';

            const container = iframe.parentElement;
            container.innerHTML += `
                <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                    <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Unable to load website</h3>
                    <p class="text-gray-500 mb-4">The website couldn't be loaded in the preview.</p>
                    <button onclick="openInNewTab()" class="px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-all">
                        Open in New Tab
                    </button>
                </div>
            `;
        }

        // Show loading on page load
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('loading-overlay');
            const urlInput = document.getElementById('url-input');
            const iframe = document.getElementById('browser-iframe');
            const sectionBadge = document.getElementById('current-section-badge');

            // Set initial URL in address bar from iframe data-default-src if available
            const defaultPreviewUrl = iframe?.dataset?.defaultSrc || 'http://localhost:5173/preview/hero-section';
            if (urlInput && (!urlInput.value || urlInput.value === 'http://localhost:5173/preview/hero-section')) {
                urlInput.value = defaultPreviewUrl;
            }

            // Show loading overlay
            if (overlay) overlay.classList.add('active');

            // Initialize core values limit check (in case core-values is loaded first)
            setTimeout(() => {
                if (typeof checkCoreValuesLimit === 'function') {
                    checkCoreValuesLimit();
                }
            }, 1000);
        });

        // Handle manual URL input changes
        document.addEventListener('DOMContentLoaded', function() {
            const manualUrlInput = document.getElementById('url-input');
            if (manualUrlInput) {
                // Add event listener for manual URL changes
                manualUrlInput.addEventListener('change', function(e) {
                    const newUrl = e.target.value.trim();
                    if (newUrl && newUrl.startsWith('http://localhost:5173/preview/')) {
                        const iframe = document.getElementById('browser-iframe');
                        const overlay = document.getElementById('loading-overlay');

                        if (iframe && newUrl !== iframe.src) {
                            overlay.classList.add('active');
                            iframe.src = newUrl;
                            console.log('Manually loaded preview URL:', newUrl);
                        }
                    }
                });

                // Add Enter key support
                manualUrlInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.target.blur(); // Trigger change event
                    }
                });
            }

            // Handle Dropify events and URL input
            // Handle background URL input changes
            const urlInput = document.getElementById('background_url_input');
            if (urlInput) {
                urlInput.addEventListener('input', function(e) {
                    const url = e.target.value;
                    document.getElementById('background_image_url').value = url;

                    // Update Dropify preview if URL is provided and Dropify is initialized
                    if (url && typeof $ !== 'undefined' && $('.dropify').data('dropify')) {
                        const dropify = $('.dropify').data('dropify');
                        dropify.resetPreview();
                        dropify.setPreview(url);
                    }
                });
            }

            // Set up Dropify event listeners after jQuery and Dropify are loaded
            setTimeout(function() {
                if (typeof $ !== 'undefined' && typeof $.fn.dropify === 'function') {
                    // When file is selected via Dropify (hero section)
                    $(document).on('dropify.fileSelected', '.dropify', function(event, element) {
                        const input = element.input[0];
                        if (input.files && input.files[0]) {
                            const file = input.files[0];
                            // Update the hidden field with file name
                            document.getElementById('background_image_url').value = file.name;
                            console.log('File selected:', file.name);
                        }
                    });

                    // When file is cleared via Dropify (hero section)
                    $(document).on('dropify.afterClear', '.dropify', function(event, element) {
                        document.getElementById('background_image_url').value = '';
                        document.getElementById('background_url_input').value = '';
                        console.log('File cleared');
                    });

                    // When file is selected via Dropify (brand section)
                    $(document).on('dropify.fileSelected', '.dropify-brand', function(event, element) {
                        const input = element.input[0];
                        if (input.files && input.files[0]) {
                            const file = input.files[0];
                            // Update the hidden field with file name
                            document.getElementById('brand_image_url').value = file.name;
                            console.log('Brand file selected:', file.name);
                        }
                    });

                    // When file is cleared via Dropify (brand section)
                    $(document).on('dropify.afterClear', '.dropify-brand', function(event, element) {
                        document.getElementById('brand_image_url').value = '';
                        document.getElementById('brand_url_input').value = '';
                        console.log('Brand file cleared');
                    });

                    console.log('Dropify event handlers initialized');
                }
            }, 1000);

            // Handle brand URL input changes
            const brandUrlInput = document.getElementById('brand_url_input');
            if (brandUrlInput) {
                brandUrlInput.addEventListener('input', function(e) {
                    const url = e.target.value;
                    document.getElementById('brand_image_url').value = url;

                    // Update Dropify preview if URL is provided and Dropify is initialized
                    if (url && typeof $ !== 'undefined' && $('.dropify-brand').data('dropify')) {
                        const dropify = $('.dropify-brand').data('dropify');
                        dropify.resetPreview();
                        dropify.setPreview(url);
                    }
                });
            }
        });

        // Add Mission Point function
        window.addMissionPoint = function() {
            const container = document.getElementById('mission-points-container');
            const div = document.createElement('div');
            div.className = 'cms-strategic-point-item';
            div.style.cssText = 'display: flex; align-items: center; gap: 0.75rem; background: #0f172a; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #334155; animation: slideIn 0.3s ease-out;';
            div.innerHTML = `
                <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <input type="text" name="mission[points][]" class="cms-form-input" placeholder="Add a strategic point..." style="flex: 1;">
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Add Vision Point function
        window.addVisionPoint = function() {
            const container = document.getElementById('vision-points-container');
            const div = document.createElement('div');
            div.className = 'cms-strategic-point-item';
            div.style.cssText = 'display: flex; align-items: center; gap: 0.75rem; background: #0f172a; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #334155; animation: slideIn 0.3s ease-out;';
            div.innerHTML = `
                <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <input type="text" name="vision[points][]" class="cms-form-input" placeholder="Add a milestone..." style="flex: 1;">
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Core Values functions already defined at beginning of script
        // Skipping duplicate definitions to avoid conflicts

        // Make checkCoreValuesLimit available globally
        window.checkCoreValuesLimit = function() {
            const container = document.getElementById('core-values-container') || document.getElementById('values-container');
            if (!container) return;
            const addButton = document.getElementById('add-core-value-btn') || document.getElementById('add-value-button');
            const statusSpan = document.getElementById('add-value-status') || document.getElementById('add-subtext');
            const counterSpan = document.getElementById('core-values-counter');
            const currentValues = container.querySelectorAll('.cms-value-item:not([style*="display: none"])');
            const maxValues = 4;

            const actualCount = currentValues.length;

            // Update counter display
            if (counterSpan) {
                counterSpan.textContent = `\${actualCount}/\${maxValues}`;

                // Change color based on count
                if (actualCount >= maxValues) {
                    counterSpan.style.background = 'rgba(239, 68, 68, 0.2)';
                    counterSpan.style.color = '#ef4444';
                } else {
                    counterSpan.style.background = 'rgba(59, 130, 246, 0.1)';
                    counterSpan.style.color = '#60a5fa';
                }
            }

            // Update button state based on current count
            if (actualCount >= maxValues) {
                addButton.disabled = true;
                addButton.style.opacity = '0.5';
                addButton.style.cursor = 'not-allowed';

                if (statusSpan) {
                    statusSpan.textContent = 'Maximum limit reached (4 values)';
                    statusSpan.style.color = '#ef4444';
                }
            } else {
                addButton.disabled = false;
                addButton.style.opacity = '1';
                addButton.style.cursor = 'pointer';

                const remaining = maxValues - actualCount;

                if (statusSpan) {
                    if (remaining === 1) {
                        statusSpan.textContent = '1 slot remaining';
                        statusSpan.style.color = '#64748b';
                    } else {
                        statusSpan.textContent = `\${remaining} slots remaining`;
                        statusSpan.style.color = '#64748b';
                    }
                }
            }

            console.log(`Core Values check: \${actualCount}/\${maxValues} (\${maxValues - actualCount} remaining)`);
        }

        // Make deleteCoreValue available globally
        window.deleteCoreValue = function(id) {
            console.log('deleteCoreValue called for ID:', id);
            const deleteInput = document.getElementById('delete_value_' + id);
            if (deleteInput) {
                deleteInput.value = '1';

                // Remove the card from display
                const valueCard = deleteInput.closest('.cms-value-item');
                if (valueCard) {
                    valueCard.style.display = 'none';
                    valueCard.style.opacity = '0';
                }

                // Show success message
                const alertSuccess = document.getElementById('alert-core-values-success');
                if (alertSuccess) {
                    alertSuccess.style.display = 'block';
                    alertSuccess.innerHTML = '<strong>Value marked for deletion!</strong> Save to permanently remove.';
                    setTimeout(() => {
                        alertSuccess.style.display = 'none';
                    }, 3000);
                }

                // Re-enable the add button and update status
                setTimeout(() => {
                    if (typeof window.checkCoreValuesLimit === 'function') {
                        window.checkCoreValuesLimit();
                    }
                }, 100);
            } else {
                console.error('Delete input element not found for ID:', id);
            }
            console.log('Core Value ' + id + ' marked for deletion');
        }

        // Initialize Dropify when libraries are loaded
        let dropifyInitialized = false;

        function initializeDropify() {
            if (dropifyInitialized) {
                console.log('Dropify already initialized, re-initializing all instances...');
            }

            console.log('Layout: Attempting to initialize Dropify...');
            console.log('jQuery available:', typeof $ !== 'undefined');

            if (typeof $ === 'undefined') {
                console.log('Layout: jQuery not available yet, will retry...');
                return false;
            }

            console.log('jQuery version:', $.fn.jquery);
            console.log('Dropify available:', typeof $.fn.dropify !== 'undefined');

            if (typeof $.fn.dropify === 'function') {
                // Only initialize non-partner Dropify elements in the layout
                // Partner elements will be handled by page-specific initialization
                const $dropifyElements = $('.dropify, .dropify-brand').not('.dropify-partner');
                console.log('Layout: Non-partner Dropify elements found:', $dropifyElements.length);

                if ($dropifyElements.length) {
                    try {
                        // Initialize Dropify for layout elements only
                        $dropifyElements.each(function() {
                            const $this = $(this);

                            // Skip if already initialized - just re-setup
                            if ($this.data('dropify')) {
                                console.log('Layout: Destroying existing Dropify instance for:', $this.attr('id'));
                                try {
                                    $this.data('dropify').destroy();
                                } catch (e) {
                                    console.error('Layout: Error destroying Dropify:', e);
                                }
                            }

                            const dropifyConfig = {
                                messages: {
                                    'default': 'Drag & drop a file here or click',
                                    'replace': 'Drag & drop or click to replace',
                                    'remove': 'Remove',
                                    'error': 'Ooops, something wrong happened.'
                                },
                                error: {
                                    'fileSize': 'The file size is too big (3MB max).',
                                    'minWidth': 'The image width is too small (min 100px).',
                                    'maxWidth': 'The image width is too big (max 3000px).',
                                    'minHeight': 'The image height is too small (min 100px).',
                                    'maxHeight': 'The image height is too big (max 3000px).',
                                    'imageFormat': 'The image format is not allowed.'
                                },
                                tpl: {
                                    wrap: '<div class="dropify-wrapper"></div>',
                                    loader: '<div class="dropify-loader"></div>',
                                    message: '<div class="dropify-message"><span class="file-icon">📷</span><p>Drag & drop files here or click to browse</p></div>',
                                    preview: '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"></div></div></div>',
                                    filename: '<p class="dropify-filename"><span></span></p>',
                                    clearButton: '<button type="button" class="dropify-clear">Remove</button>',
                                    errorLine: '<p class="dropify-error">Error</p>',
                                    errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
                                }
                            };

                            $this.dropify(dropifyConfig);
                            console.log('✓ Layout: Dropify initialized for:', $this.attr('id'));
                        });

                        dropifyInitialized = true;
                        console.log('✓ Layout: Non-partner Dropify initialized successfully');

                        // Note: Partner Dropify events will be handled by page-specific functions
                        return true;
                    } catch (error) {
                        console.error('✗ Layout: Error initializing Dropify:', error);
                        return false;
                    }
                } else {
                    console.log('⊘ Layout: No non-partner Dropify elements found');
                }
            } else {
                console.log('⊘ Layout: Dropify not available yet');
            }
            return false;
        }

        // Fallback: Check periodically for jQuery/Dropify availability
        function checkForLibraries() {
            if (typeof $ === 'undefined' || $('.dropify, .dropify-brand').length === 0) {
                return; // Skip if jQuery is not loaded or no dropify elements on page
            }
            const maxAttempts = 20;
            let attempts = 0;

            const interval = setInterval(function() {
                attempts++;
                if (initializeDropify()) {
                    clearInterval(interval);
                    console.log('Dropify initialized via fallback');
                } else if (attempts >= maxAttempts) {
                    clearInterval(interval);
                    console.warn('Dropify not initialized (jQuery/Dropify library optional for this page)');
                }
            }, 500);
        }

        // Enhanced section toggle with Dropify initialization
        const originalToggleSection = toggleSection;
        toggleSection = function(sectionId) {
            // Call original function
            originalToggleSection.apply(this, arguments);

            // Update iframe to show corresponding preview
            updatePreviewForSection(sectionId);

            // Initialize Dropify when hero or brand-statements section is expanded
            if (sectionId === 'hero' || sectionId === 'brand-statements') {
                setTimeout(function() {
                    if (!dropifyInitialized) {
                        checkForLibraries();
                    } else {
                        console.log('Dropify already initialized, re-initializing...');
                        // Re-initialize Dropify for the section
                        initializeDropify();
                    }
                }, 300);
            }

            // Initialize core values when that section is expanded
            if (sectionId === 'core-values') {
                console.log('Core Values section expanded');
                setTimeout(() => {
                    checkCoreValuesLimit();
                }, 100);
            }
        };

        // Update preview iframe based on section
        function updatePreviewForSection(sectionId) {
            // If page defines its own preview map (e.g. About page), let the page handle it
            if (typeof sectionPreviewUrls !== 'undefined') {
                return;
            }

            const iframe = document.getElementById('browser-iframe');
            const overlay = document.getElementById('loading-overlay');
            const urlInput = document.getElementById('url-input');
            const sectionBadge = document.getElementById('current-section-badge');

            // Map section IDs to preview routes and display names
            const previewRoutes = {
                'hero': {
                    url: 'http://localhost:5173/preview/hero-section',
                    name: 'Hero Section'
                },
                'brand-statements': {
                    url: 'http://localhost:5173/preview/brand-statements',
                    name: 'Brand Statements'
                },
                'mission-vision': {
                    url: 'http://localhost:5173/preview/mission-vision',
                    name: 'Mission & Vision'
                },
                'core-values': {
                    url: 'http://localhost:5173/preview/core-values',
                    name: 'Core Values'
                }
            };

            const previewData = previewRoutes[sectionId];

            if (previewData && iframe) {
                // Show loading overlay
                overlay.classList.add('active');

                // Update iframe source only if URL is different
                if (iframe.src !== previewData.url && iframe.src !== previewData.url + '/') {
                    iframe.src = previewData.url;
                }

                // Update address bar
                if (urlInput) {
                    urlInput.value = previewData.url;
                }

                // Update section badge
                if (sectionBadge) {
                    sectionBadge.textContent = previewData.name;
                }

                console.log(`Preview updated for section: \${sectionId} -> \${previewData.url}`);

                // Hide loading overlay after a delay
                setTimeout(() => {
                    overlay.classList.remove('active');
                }, 1000);
            } else {
                console.warn(`No preview URL found for section: \${sectionId}`);
                // Hide loading overlay if no URL found
                overlay.classList.remove('active');
            }
        }

        // Start library check on page load
        checkForLibraries();
    </script>
    {{ $scripts ?? '' }}
</body>
</html>

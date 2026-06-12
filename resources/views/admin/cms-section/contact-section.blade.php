@extends('layouts.admin')

@section('title', 'Manage Contact Section')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Contact Information</h5>
                    <a href="{{ route('admin.cms-section.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to CMS
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms-section.contact-section.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Contact Information</h6>

                            <!-- Phone Numbers -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone Numbers</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text"
                                               class="form-control"
                                               name="phone_1"
                                               value="{{ $contactItems['contact_phone_1']->section_content ?? '' }}"
                                               placeholder="Phone Number 1">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text"
                                               class="form-control"
                                               name="phone_2"
                                               value="{{ $contactItems['contact_phone_2']->section_content ?? '' }}"
                                               placeholder="Phone Number 2">
                                    </div>
                                </div>
                            </div>

                            <!-- Email Addresses -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Addresses</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="email"
                                               class="form-control"
                                               name="email_1"
                                               value="{{ $contactItems['contact_email_1']->section_content ?? '' }}"
                                               placeholder="Email Address 1">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="email"
                                               class="form-control"
                                               name="email_2"
                                               value="{{ $contactItems['contact_email_2']->section_content ?? '' }}"
                                               placeholder="Email Address 2">
                                    </div>
                                </div>
                            </div>

                            <!-- Office Hours -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Office Hours</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text"
                                               class="form-control"
                                               name="office_hours_weekdays"
                                               value="{{ $contactItems['contact_office_hours_weekdays']->section_content ?? '' }}"
                                               placeholder="Saturday - Thursday: 9:00 AM - 6:00 PM">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text"
                                               class="form-control"
                                               name="office_hours_friday"
                                               value="{{ $contactItems['contact_office_hours_friday']->section_content ?? '' }}"
                                               placeholder="Friday: Closed">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Office Locations -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Office Locations</h6>

                            @for($i = 1; $i <= 2; $i++)
                                @php
                                    $officeKey = 'contact_office_' . $i;
                                    $officeData = isset($contactItems[$officeKey]) && $contactItems[$officeKey]->section_content
                                        ? json_decode($contactItems[$officeKey]->section_content, true)
                                        : [];
                                @endphp

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Office {{ $i }}</h6>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">City</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="office_{{ $i }}_city"
                                                       value="{{ $officeData['city'] ?? '' }}"
                                                       placeholder="e.g., Dhaka">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Office Type</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="office_{{ $i }}_type"
                                                       value="{{ $officeData['type'] ?? '' }}"
                                                       placeholder="e.g., Corporate Headquarters">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control"
                                                      name="office_{{ $i }}_address"
                                                      rows="2"
                                                      placeholder="Full office address">{{ $officeData['address'] ?? '' }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="office_{{ $i }}_phone"
                                                       value="{{ $officeData['phone'] ?? '' }}"
                                                       placeholder="Office phone number">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email"
                                                       class="form-control"
                                                       name="office_{{ $i }}_email"
                                                       value="{{ $officeData['email'] ?? '' }}"
                                                       placeholder="Office email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cms-section.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

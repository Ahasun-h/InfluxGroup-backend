<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .lead-details {
            background: #f9fafb;
            padding: 25px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #1e40af;
        }
        .detail-row {
            margin-bottom: 15px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #1e40af;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #374151;
            font-size: 15px;
            line-height: 1.5;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            margin-top: 10px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .badge-new {
            background: #dbeafe;
            color: #1e40af;
        }
        .button {
            display: inline-block;
            background: #1e40af;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background 0.3s;
        }
        .button:hover {
            background: #1e3a8a;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            color: #6b7280;
            font-size: 12px;
        }
        .timestamp {
            color: #9ca3af;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 New Contact Form Submission</h1>
            <p>A visitor has submitted an inquiry through your website</p>
        </div>

        <div class="content">
            <p style="font-size: 15px; color: #4b5563;">You have received a new message through the contact form on your website. Here are the details:</p>

            <div class="lead-details">
                <div class="detail-row">
                    <span class="label">Status</span>
                    <span class="value">
                        <span class="badge badge-new">New Lead</span>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">Name</span>
                    <span class="value">{{ $lead->name }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Email Address</span>
                    <span class="value">
                        <a href="mailto:{{ $lead->email }}" style="color: #1e40af; text-decoration: none;">{{ $lead->email }}</a>
                    </span>
                </div>

                @if($lead->phone)
                <div class="detail-row">
                    <span class="label">Phone Number</span>
                    <span class="value">{{ $lead->phone }}</span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="label">Subject</span>
                    <span class="value">
                        @php
                            $subjectLabels = [
                                'general' => 'General Inquiry',
                                'projects' => 'Project Inquiry',
                                'products' => 'Product Information',
                                'support' => 'Technical Support',
                                'careers' => 'Career Opportunities',
                                'other' => 'Other',
                            ];
                            $subjectLabel = $subjectLabels[$lead->subject] ?? ucfirst($lead->subject);
                        @endphp
                        {{ $subjectLabel }}
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">Message</span>
                    <div class="message-box">{{ $lead->message }}</div>
                </div>

                <div class="detail-row">
                    <span class="label">Submitted</span>
                    <span class="value timestamp">{{ $lead->created_at->format('F j, Y, g:i a') }}</span>
                </div>
            </div>

            <p style="text-align: center;">
                <a href="{{ config('app.url') }}/admin/leads/{{ $lead->id }}" class="button">
                    View in Admin Dashboard
                </a>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} InfluxGroup. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>

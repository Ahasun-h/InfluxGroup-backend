<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quote Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #1e40af;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .quote-details {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .label {
            font-weight: bold;
            color: #1e40af;
        }
        .button {
            display: inline-block;
            background: #1e40af;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Quote Request</h1>
    </div>

    <div class="content">
        <p>A new quote request has been submitted on the InfluxGroup website.</p>

        <div class="quote-details">
            <p><span class="label">Name:</span> {{ $quoteRequest->name }}</p>
            <p><span class="label">Email:</span> {{ $quoteRequest->email }}</p>
            @if($quoteRequest->phone)
            <p><span class="label">Phone:</span> {{ $quoteRequest->phone }}</p>
            @endif
            @if($quoteRequest->company)
            <p><span class="label">Company:</span> {{ $quoteRequest->company }}</p>
            @endif
            <p><span class="label">Requirements:</span></p>
            <p style="background: #f3f4f6; padding: 15px; border-radius: 5px; margin-top: 10px;">
                {{ $quoteRequest->requirements }}
            </p>
            <p><span class="label">Submitted:</span> {{ $quoteRequest->created_at->format('F j, Y, g:i a') }}</p>
        </div>

        <p style="text-align: center;">
            <a href="{{ config('app.url') }}/admin/quote-requests/{{ $quoteRequest->id }}" class="button">
                View Quote Request
            </a>
        </p>

        <p style="text-align: center;">
            <a href="{{ config('app.url') }}/admin/quote-requests/{{ $quoteRequest->id }}/convert" class="button" style="background: #059669;">
                Convert to Quotation
            </a>
        </p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} InfluxGroup. All rights reserved.</p>
    </div>
</body>
</html>
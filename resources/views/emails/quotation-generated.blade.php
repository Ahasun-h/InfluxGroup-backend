<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Quotation from InfluxGroup</title>
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
        .quotation-details {
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
        .highlight {
            background: #fef3c7;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #f59e0b;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Quotation is Ready!</h1>
    </div>

    <div class="content">
        <p>Dear {{ $quotation->client_name }},</p>

        <p>Thank you for your interest in InfluxGroup's products and services. We have prepared a quotation based on your requirements.</p>

        <div class="highlight">
            <strong>Quotation Number:</strong> {{ $quotation->quotation_number }}<br>
            <strong>Valid Until:</strong> {{ $quotation->valid_until ? $quotation->valid_until->format('F j, Y') : 'Not specified' }}
        </div>

        <div class="quotation-details">
            <p><span class="label">Quotation Number:</span> {{ $quotation->quotation_number }}</p>
            <p><span class="label">Date:</span> {{ $quotation->quotation_date->format('F j, Y') }}</p>
            @if($quotation->valid_until)
            <p><span class="label">Valid Until:</span> {{ $quotation->valid_until->format('F j, Y') }}</p>
            @endif
            <p><span class="label">Currency:</span> {{ $quotation->currency }}</p>

            @if($quotation->notes)
            <p><span class="label">Notes:</span><br>{{ $quotation->notes }}</p>
            @endif
        </div>

        <p>Please find the detailed quotation document attached to this email. The document includes:</p>

        <ul>
            <li>Detailed item descriptions and specifications</li>
            <li>Itemized pricing with quantities</li>
            <li>Tax and discount breakdowns</li>
            <li>Final total amount</li>
            <li>Terms and conditions</li>
        </ul>

        <p style="text-align: center;">
            <a href="{{ config('app.url') }}/contact" class="button">
                Contact Us for Questions
            </a>
        </p>

        <div class="highlight">
            <strong>Next Steps:</strong>
            <ol>
                <li>Review the attached quotation document</li>
                <li>If you have any questions, please contact us</li>
                <li>To proceed, simply reply to this email or contact our sales team</li>
            </ol>
        </div>

        <p>We look forward to serving you!</p>

        <p>Best regards,<br>
        The InfluxGroup Team</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} InfluxGroup. All rights reserved.</p>
        <p>Contact: info@influxgroup.com | +880 2 987 6543</p>
    </div>
</body>
</html>
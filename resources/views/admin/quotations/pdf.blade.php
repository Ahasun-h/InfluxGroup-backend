<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        @page {
            margin: 20px;
            size: A4;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0066CC;
        }

        .company-logo {
            max-width: 200px;
            max-height: 80px;
        }

        .quotation-info {
            text-align: right;
        }

        .quotation-number {
            font-size: 24px;
            font-weight: bold;
            color: #0066CC;
            margin-bottom: 5px;
        }

        .quotation-date {
            color: #666;
            font-size: 11px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0066CC;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }

        .client-info {
            margin-bottom: 30px;
        }

        .client-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .client-detail {
            color: #666;
            margin: 2px 0;
        }

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            background-color: #0066CC;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        .totals {
            width: 300px;
            margin: 20px 0 20px auto;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .total-row.grand-total {
            font-size: 14px;
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 12px;
            border-top: 2px solid #0066CC;
            border-bottom: none;
        }

        .notes-section {
            margin: 30px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 4px solid #0066CC;
        }

        .terms-section {
            margin: 30px 0;
            font-size: 11px;
            color: #666;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #999;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-draft {
            background-color: #f3f4f6;
            color: #374151;
        }

        .status-sent {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-accepted {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .valid-until {
            font-size: 11px;
            color: #dc2626;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="margin: 0; color: #0066CC; font-size: 28px;">INFLUX GROUP</h1>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 11px;">Powering Bangladesh Since 1980</p>
            </div>
            <div class="quotation-info">
                <div class="status-badge status-{{ $quotation->status }}">
                    {{ $quotation->status_label }}
                </div>
                <div class="quotation-number">{{ $quotation->quotation_number }}</div>
                <div class="quotation-date">
                    Date: {{ $quotation->quotation_date->format('F d, Y') }}<br>
                    @if($quotation->valid_until)
                        <span class="valid-until">Valid Until: {{ $quotation->valid_until->format('F d, Y') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Client Information -->
        <div class="section-title">Bill To</div>
        <div class="client-info">
            <div class="client-name">{{ $quotation->client_name }}</div>
            @if($quotation->client_company)
                <div class="client-detail"><strong>{{ $quotation->client_company }}</strong></div>
            @endif
            @if($quotation->client_address)
                <div class="client-detail">{{ nl2br($quotation->client_address) }}</div>
            @endif
            @if($quotation->client_email || $quotation->client_phone)
                <div class="client-detail">
                    @if($quotation->client_email)Email: {{ $quotation->client_email }}@endif
                    @if($quotation->client_email && $quotation->client_phone) | @endif
                    @if($quotation->client_phone)Phone: {{ $quotation->client_phone }}@endif
                </div>
            @endif
        </div>

        <!-- Line Items -->
        <div class="section-title">Quotation Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Description</th>
                    <th style="width: 80px;" class="text-center">Qty</th>
                    <th style="width: 100px;" class="text-right">Unit Price</th>
                    <th style="width: 100px;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->quotationItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div style="font-weight: bold;">{{ $item->description }}</div>
                            @if($item->specifications)
                                <div style="font-size: 10px; color: #666; margin-top: 3px;">
                                    {{ $item->specifications }}
                                </div>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>{{ $quotation->currency }} {{ number_format($quotation->subtotal, 2) }}</span>
            </div>

            @if($quotation->tax_percentage > 0)
                <div class="total-row">
                    <span>Tax ({{ $quotation->tax_percentage }}%):</span>
                    <span>{{ $quotation->currency }} {{ number_format($quotation->tax_amount, 2) }}</span>
                </div>
            @endif

            @if($quotation->discount_percentage > 0)
                <div class="total-row">
                    <span>Discount ({{ $quotation->discount_percentage }}%):</span>
                    <span>-{{ $quotation->currency }} {{ number_format($quotation->discount_amount, 2) }}</span>
                </div>
            @endif

            <div class="total-row grand-total">
                <span>Total:</span>
                <span>{{ $quotation->currency }} {{ number_format($quotation->total, 2) }}</span>
            </div>
        </div>

        <!-- Notes -->
        @if($quotation->notes)
            <div class="notes-section">
                <div style="font-weight: bold; margin-bottom: 10px;">Notes:</div>
                <div>{{ nl2br($quotation->notes) }}</div>
            </div>
        @endif

        <!-- Terms & Conditions -->
        @if($quotation->terms_and_conditions)
            <div class="terms-section">
                <div style="font-weight: bold; margin-bottom: 10px;">Terms & Conditions:</div>
                <div>{{ nl2br($quotation->terms_and_conditions) }}</div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This quotation is automatically generated and valid without signature.</p>
            <p>For inquiries, please contact us at info@influxgroup.com | +880 1234-567890</p>
            <p style="margin-top: 10px;">© {{ date('Y') }} Influx Group. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
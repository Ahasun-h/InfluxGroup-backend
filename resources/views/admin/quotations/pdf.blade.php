<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        @page {
            margin: 25px;
            size: A4;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #000000;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 30px;
        }

        /* Header Section */
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #000000;
            padding-bottom: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .logo-badge {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007BFF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #000000;
            margin: 0 0 5px 0;
        }

        .company-slogan {
            font-size: 12px;
            color: #666666;
            margin: 0;
        }

        .quotation-title {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #000000;
            margin-top: -40px;
        }

        /* Address Section */
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            gap: 40px;
        }

        .address-block {
            flex: 1;
        }

        .address-label {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            color: #000000;
        }

        .address-content {
            font-size: 11px;
            line-height: 1.6;
            color: #000000;
        }

        .address-line {
            margin: 2px 0;
        }

        /* Metadata Table */
        .metadata-table {
            width: 250px;
            margin: 0 0 25px auto;
            border-collapse: collapse;
        }

        .metadata-table td {
            border: 1px solid #E0E0E0;
            padding: 8px 12px;
            font-size: 11px;
        }

        .metadata-table td:first-child {
            font-weight: normal;
            color: #666666;
        }

        .metadata-table td:last-child {
            text-align: right;
            font-weight: bold;
            color: #000000;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .items-table th {
            background-color: #F8F8F8;
            border: 1px solid #E0E0E0;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            color: #000000;
        }

        .items-table th:first-child {
            width: 25%;
        }

        .items-table th:nth-child(2) {
            width: 25%;
        }

        .items-table th:nth-child(3),
        .items-table th:nth-child(4) {
            width: 15%;
            text-align: right;
        }

        .items-table th:last-child {
            width: 20%;
            text-align: right;
        }

        .items-table td {
            border: 1px solid #E0E0E0;
            padding: 10px 8px;
            font-size: 11px;
            vertical-align: top;
        }

        .items-table td:nth-child(3),
        .items-table td:nth-child(4),
        .items-table td:last-child {
            text-align: right;
        }

        .items-table tr:last-child td {
            border-bottom: 2px solid #000000;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 3px;
        }

        .item-spec {
            color: #666666;
            font-size: 10px;
            line-height: 1.4;
        }

        /* Financial Summary */
        .financial-summary {
            width: 300px;
            margin: 0 0 25px auto;
            border-collapse: collapse;
        }

        .financial-summary td {
            border: 1px solid #E0E0E0;
            padding: 10px 15px;
            font-size: 11px;
        }

        .financial-summary td:first-child {
            font-weight: normal;
            color: #000000;
        }

        .financial-summary td:last-child {
            text-align: right;
            font-weight: bold;
            color: #000000;
        }

        .financial-summary tr:last-child td {
            font-size: 14px;
            background-color: #F8F8F8;
            border-top: 2px solid #000000;
        }

        /* Terms Section */
        .terms-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #F9F9F9;
            border-left: 3px solid #E0E0E0;
        }

        .terms-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 10px;
            color: #000000;
        }

        .terms-list {
            margin: 0;
            padding-left: 20px;
            font-size: 11px;
            line-height: 1.6;
            color: #333333;
        }

        .terms-list li {
            margin-bottom: 5px;
        }

        /* Notes Section */
        .notes-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #F9F9F9;
            border: 1px solid #E0E0E0;
        }

        .notes-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            color: #000000;
        }

        .notes-content {
            font-size: 11px;
            line-height: 1.6;
            color: #333333;
        }

        /* Footer Section */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E0E0E0;
            text-align: center;
        }

        .acceptance-line {
            font-style: italic;
            font-size: 11px;
            color: #666666;
            margin-bottom: 15px;
        }

        .contact-info {
            font-size: 10px;
            color: #666666;
            margin-bottom: 10px;
        }

        .thank-you {
            font-weight: bold;
            font-size: 14px;
            color: #000000;
            margin-top: 10px;
        }

        .signature-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #E0E0E0;
        }

        .signature-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 100px;
            margin-top: 40px;
        }

        .signature-box {
            border: 1px solid #E0E0E0;
            width: 150px;
            height: 40px;
            margin-bottom: 5px;
        }

        .signature-label {
            font-size: 10px;
            color: #666666;
            text-align: center;
        }

        /* Company Info from Settings */
        .company-info-dynamic {
            margin-bottom: 15px;
        }

        .company-info-line {
            font-size: 11px;
            color: #333333;
            margin: 3px 0;
        }

        .company-info-line strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            @php
                // Fetch company settings dynamically
                $companySettings = \App\Models\ContentManagement::where('section_name', 'settings')
                    ->get()
                    ->keyBy('section_item_name');

                $companyName = $companySettings->get('company_name')->section_content ?? 'Influx Group Engineering';
                $companySlogan = $companySettings->get('tagline')->section_content ?? 'Power Infrastructure Solutions';
                $companyPhone = $companySettings->get('phone')->section_content ?? '+880 2 987 6543';
                $companyEmail = $companySettings->get('email')->section_content ?? 'info@influxgroup.com';
                $companyAddress = $companySettings->get('address')->section_content ?? 'Dhaka, Bangladesh';

                // Get header logo if exists
                $headerLogo = \App\Models\ContentManagement::where('section_name', 'settings')
                    ->where('section_item_name', 'header_logo')
                    ->where('section_content', '!=', '')
                    ->first();

                $logoPath = $headerLogo ? public_path('storage/' . $headerLogo->section_content) : null;
            @endphp

            @if($logoPath && file_exists($logoPath))
                <div class="logo-section">
                    <img src="{{ asset('storage/' . $headerLogo->section_content) }}"
                         alt="{{ $companyName }}"
                         style="max-width: 60px; max-height: 60px; object-fit: contain;">
                </div>
            @else
                <div class="logo-section">
                    <div class="logo-badge">IG</div>
                </div>
            @endif

            <h1 class="company-name">{{ $companyName }}</h1>
            @if($companySlogan)
                <p class="company-slogan">{{ $companySlogan }}</p>
            @endif

            <div class="quotation-title">QUOTATION</div>
        </div>

        <!-- Address Section -->
        <div class="address-section">
            <!-- From Address -->
            <div class="address-block">
                <div class="address-label">FROM:</div>
                <div class="address-content">
                    <div class="address-line"><strong>{{ $companyName }}</strong></div>
                    @if($companyAddress)
                        <div class="address-line">{{ $companyAddress }}</div>
                    @endif
                    @if($companyPhone)
                        <div class="address-line">Tel: {{ $companyPhone }}</div>
                    @endif
                    @if($companyEmail)
                        <div class="address-line">Email: {{ $companyEmail }}</div>
                    @endif
                </div>
            </div>

            <!-- To Address -->
            <div class="address-block">
                <div class="address-label">TO:</div>
                <div class="address-content">
                    @if($quotation->client_company)
                        <div class="address-line"><strong>{{ $quotation->client_company }}</strong></div>
                    @endif
                    @if($quotation->client_name)
                        <div class="address-line">{{ $quotation->client_name }}</div>
                    @endif
                    @if($quotation->client_address)
                        <div class="address-line">{{ nl2br($quotation->client_address) }}</div>
                    @endif
                    @if($quotation->client_phone)
                        <div class="address-line">Tel: {{ $quotation->client_phone }}</div>
                    @endif
                    @if($quotation->client_email)
                        <div class="address-line">Email: {{ $quotation->client_email }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Metadata Table -->
        <table class="metadata-table">
            <tr>
                <td>Date:</td>
                <td>{{ $quotation->quotation_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Quote No.:</td>
                <td>#{{ $quotation->quotation_number }}</td>
            </tr>
            @if($quotation->valid_until)
            <tr>
                <td>Expiration Date:</td>
                <td>{{ $quotation->valid_until->format('d/m/Y') }}</td>
            </tr>
            @endif
        </table>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>ITEMS</th>
                    <th>SPECIFICATION</th>
                    <th>UNIT PRICE</th>
                    <th>QUANTITY</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->quotationItems as $item)
                    <tr>
                        <td>
                            <div class="item-name">{{ $item->description }}</div>
                        </td>
                        <td>
                            @if($item->specifications)
                                <div class="item-spec">{{ $item->specifications }}</div>
                            @endif
                        </td>
                        <td>{{ $quotation->currency }} {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $quotation->currency }} {{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Financial Summary -->
        <table class="financial-summary">
            <tr>
                <td>SUB TOTAL</td>
                <td>{{ $quotation->currency }} {{ number_format($quotation->subtotal, 2) }}</td>
            </tr>
            @if($quotation->tax_percentage > 0)
            <tr>
                <td>TAX {{ $quotation->tax_percentage }}%</td>
                <td>{{ $quotation->currency }} {{ number_format($quotation->tax_amount, 2) }}</td>
            </tr>
            @endif
            @if($quotation->discount_percentage > 0)
            <tr>
                <td>DISCOUNT {{ $quotation->discount_percentage }}%</td>
                <td>-{{ $quotation->currency }} {{ number_format($quotation->discount_amount, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td>GRAND TOTAL</td>
                <td>{{ $quotation->currency }} {{ number_format($quotation->total, 2) }}</td>
            </tr>
        </table>

        <!-- Terms & Conditions -->
        @if($quotation->terms_and_conditions)
            <div class="terms-section">
                <div class="terms-title">TERMS AND CONDITIONS:</div>
                <ol class="terms-list">
                    @foreach(explode("\n", $quotation->terms_and_conditions) as $term)
                        @if(trim($term) !== '')
                        <li>{{ trim($term) }}</li>
                        @endif
                    @endforeach
                </ol>
            </div>
        @else
            <div class="terms-section">
                <div class="terms-title">TERMS AND CONDITIONS:</div>
                <ol class="terms-list">
                    <li>Customer will be billed after indicating acceptance of this quote.</li>
                    <li>Payment will be due prior to delivery of services and goods.</li>
                    <li>This quotation is valid for 30 days from the date of issue.</li>
                    <li>Prices are subject to change without prior notice.</li>
                </ol>
            </div>
        @endif

        <!-- Notes -->
        @if($quotation->notes)
            <div class="notes-section">
                <div class="notes-title">NOTES:</div>
                <div class="notes-content">{{ nl2br($quotation->notes) }}</div>
            </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-line">
                <div>
                    <div class="signature-box"></div>
                    <div class="signature-label">Authorized Signature</div>
                </div>
                <div>
                    <div class="signature-box"></div>
                    <div class="signature-label">Client Acceptance</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="acceptance-line">To accept this quotation, Please sign here and return</p>

            <p class="contact-info">
                If you have any questions about this quotation, Please contact us at
                @if($companyPhone) PH: {{ $companyPhone }} @endif
                @if($companyPhone && $companyEmail) | @endif
                @if($companyEmail) {{ $companyEmail }} @endif
            </p>

            <p class="thank-you">THANK YOU FOR YOUR BUSINESS!</p>
        </div>
    </div>
</body>
</html>
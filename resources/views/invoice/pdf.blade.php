<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_no }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .invoice-box table tr.payment td:nth-child(2) {
            font-weight: normal;
        }
        .paid {
            color: green;
        }
        .due {
            color: red;
        }
        .logo {
            width: 100%;
            max-width: 300px;
        }
        .bill-header {
            font-weight: bold;
            font-size: 18px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('images/logo.png') }}" class="logo">
                            </td>
                            <td>
                                Invoice #: {{ $invoice->invoice_no }}<br>
                                Created: {{ format_date($invoice->created_at) }}<br>
                                Payment: {{ $invoice->payment_date ? format_date($invoice->payment_date) : 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <div class="bill-header">Bill From:</div>
                                <strong>{{ $company->company_name }}</strong><br>
                                {{ $company->email }}<br>
                                {{ $company->phone }} <br>
                                {{ $company->address }}
                            </td>
                            <td>
                                <div class="bill-header">Bill To:</div>
                                <strong>{{ $invoice->customer->name }}</strong><br>
                                {{ $invoice->customer->email }}<br>
                                {{ $invoice->customer->phone }} <br>
                                {{ $invoice->customer->address }} <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Description</td>
                <td>Amount</td>
            </tr>
            
            <tr class="item">
                <td>{{ $invoice->title }}</td>
                <td>{{ number_format($invoice->total_amount, 2) }} Tk</td>
            </tr>
            
            <tr class="total">
                <td></td>
                <td>Total: {{ number_format($invoice->total_amount, 2) }} Tk</td>
            </tr>
            
            <tr class="payment">
                <td></td>
                <td>Paid: <span class="paid">{{ number_format($invoice->paid_amount, 2) }} Tk</span></td>
            </tr>
            
            <tr class="payment">
                <td></td>
                <td>Due: <span class="due">{{ number_format($invoice->due_amount, 2) }} Tk</span></td>
            </tr>
            
            <tr class="payment">
                <td></td>
                <td>
                    Status: 
                    @if($invoice->payment_status == '1')
                        <span class="paid">PAID</span>
                    @elseif($invoice->payment_status == '2')
                        <span style="color: orange;">PARTIAL</span>
                    @else
                        <span class="due">UNPAID</span>
                    @endif
                </td>
            </tr>
        </table>
        
        @if($invoice->invoice_note)
        <div style="margin-top: 30px;">
            <strong>Notes:</strong><br>
            {{ $invoice->invoice_note }}
        </div>
        @endif
        
        <div style="margin-top: 50px; text-align: center;">
            <p>Thank you for your business!</p>
            @if($company->signature_image)
                <img src="{{ public_path('storage/'.$company->signature_image) }}" style="height: 50px;">
                <p>Authorized Signature</p>
            @endif
        </div>
    </div>
</body>
</html>
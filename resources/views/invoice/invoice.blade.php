<div class="company-information">
    <div>Invoice No: {{ $invoice->invoice_no }}</div>
    <div>Customer Name: {{ $invoice->customer->name }}</div>
    <div>Title: {{ $invoice->title }}</div>
    <div>Total Amount: {{ $invoice->total_cost_price }}</div>
</div>
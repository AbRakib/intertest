<div class="card p-2">
    <div class="row">
        <div class="col-md-6">
            <div>Invoice No: <b>{{ $invoice->invoice_no }}</b></div>
            <div>Customer: <b>{{ $invoice->customer->name }}</b></div>
            <div>Invoice Date: <b>{{ format_date($invoice->invoice_date) }}</b></div>
        </div>
        <div class="col-md-6">
            <div>Inspection: <b>{{ format_date($invoice->invoice_date) }}</b></div>
            <div>Payment: <b>{{ format_date($invoice->invoice_date) }}</b></div>
            <div>Title: <b>{{ $invoice->title }}</b></div>
        </div>
    </div>
</div>
<div class="form-row mt-2">
    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
    <input type="hidden" name="customer_id" value="{{ $invoice->customer_id }}">
    <input type="hidden" name="payment_date" value="{{ $invoice->payment_date }}">
    <input type="hidden" name="payment_method" value="Cash">
    <input type="hidden" name="note" value="Invoice Payment">
    <div class="form-group col-md-6">
        <label for="total_amount">Total Amount</label>
        <input type="text" class="form-control" id="total_amount" placeholder="Total Amount"
            value="{{ $invoice->total_amount }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="inputPassword4">Due Amount</label>
        <input type="text" class="form-control" id="due_amount" placeholder="Total Amount"
            value="{{ $invoice->due_amount }}" readonly>
    </div>
    <div class="form-group col-md-12">
        <label for="payment">Payment Amount</label>
        <input type="number" class="form-control" name="payment" id="payment" placeholder="Payment Amount"
            value="{{ old('payment') }}" min="0" max="{{ $invoice->due_amount }}">
    </div>
</div>

<?php

if (! function_exists('generate_customer_id')) {
    /**
     * Generate a unique customer ID in CIDXXX format
     *
     * @return string
     */
    function generate_customer_id() {
        $lastCustomer = \App\Models\Customer::orderBy('id', 'desc')->first();
        $nextId       = $lastCustomer ? (int) substr($lastCustomer->customer_id, 3) + 1 : 1;
        return 'CID' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('format_date')) {
    function format_date($date, $format = 'd M, Y') {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (! function_exists('generate_invoice_number')) {
    function generate_invoice_number() {
        $lastInvoice = \App\Models\Invoice::orderBy('id', 'desc')->first();
        return $lastInvoice ? 'INV' . str_pad((int) str_replace('INV', '', $lastInvoice->invoice_no) + 1, 4, '0', STR_PAD_LEFT)
        : 'INV0001';
    }
}

@extends('layout')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">payments</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Payment History</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm payment-table small text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Invoice Id</th>
                            <th>Customer</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Invoice Id</th>
                            <th>Customer</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Created At</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->invoice->invoice_no }}</td>
                                <td>{{ $payment->customer->name }}</td>
                                <td>{{ format_date($payment->payment_date) }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->note }}</td>
                                <td>{{ format_date($payment->created_at) }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layout')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Invoices</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Unpaid Invoice List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm customer-table small" id="invoiceTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Customer Name</th>
                            <th>Invoice No</th>
                            <th>Invoice Value</th>
                            <th>Received</th>
                            <th>Due Amount</th>
                            <th>Ref Invoice</th>
                            <th>Invoice Title</th>
                            <th>Payment Status</th>
                            <th>Download</th>
                            <th>Inspection Date</th>
                            <th>Delivery Date</th>
                            <th>Next Inspection</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="text-center">
                            <th>Customer Name</th>
                            <th>Invoice No</th>
                            <th>Invoice Value</th>
                            <th>Received</th>
                            <th>Due Amount</th>
                            <th>Ref Invoice</th>
                            <th>Invoice Title</th>
                            <th>Payment Status</th>
                            <th>Download</th>
                            <th>Inspection Date</th>
                            <th>Delivery Date</th>
                            <th>Next Inspection</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($invoices as $invoice)
                            <tr class="text-center">
                                <td>{{ $invoice->customer->name }}</td>
                                <td>{{ $invoice->invoice_no }}</td>
                                <td>
                                    ৳
                                    <span class="text-warning">
                                        {{ $invoice->total_amount }}
                                    </span>
                                </td>
                                <td>
                                    ৳
                                    <span class="text-success">
                                        {{ $invoice->paid_amount }}
                                    </span>
                                </td>
                                <td>
                                    ৳
                                    <span class="text-danger">
                                        {{ $invoice->due_amount }}
                                    </span>
                                </td>
                                <td>{{ $invoice->invoice?->invoice_no ?? 'No Invoice' }}</td>
                                <td>{{ $invoice->title }}</td>
                                <td>
                                    @if ($invoice->due_amount == 0)
                                        Paid
                                    @else
                                        Unpaid
                                    @endif
                                </td>
                                <td>
                                    @if ($invoice->due_amount == 0)
                                        @if ($invoice->report)
                                            <a href="{{ asset('storage/reports/' . $invoice->report) }}" download>Download
                                                Report</a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#payment">Make
                                            Payment</a>
                                    @endif
                                </td>
                                <td>{{ format_date($invoice->inspection_date) }}</td>
                                <td>{{ format_date($invoice->delivery_date) }}</td>
                                <td>{{ format_date($invoice->delivery_date) }}</td>

                                <td class="text-center mt-2">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('admin.invoice.show', $invoice->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.invoice.edit', $invoice->id) }}"
                                            class="btn btn-sm btn-secondary">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.invoice.destroy', $invoice->id) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            No Data Found!!
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="paymentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layout')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Invoices</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Invoice List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm customer-table small" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Customer Name</th>
                            <th>Invoice No</th>
                            <th>Invoice Value</th>
                            <th>Received</th>
                            <th>Due Amount</th>
                            <th>Invoice Title</th>
                            <th>Payment Status</th>
                            <th>Download</th>
                            <th>Inspection Date</th>
                            <th>Delivery Date</th>
                            <th>Next Inspection</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="text-center">
                            <th>Customer Name</th>
                            <th>Invoice No</th>
                            <th>Invoice Value</th>
                            <th>Received</th>
                            <th>Due Amount</th>
                            <th>Invoice Title</th>
                            <th>Payment Status</th>
                            <th>Download</th>
                            <th>Inspection Date</th>
                            <th>Delivery Date</th>
                            <th>Next Inspection</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr class="text-center">
                                <td>{{ $report->customer->name }}</td>
                                <td>{{ $report->invoice_no }}</td>
                                <td>
                                    ৳
                                    <span class="text-warning">
                                        {{ $report->total_amount }}
                                    </span>
                                </td>
                                <td>
                                    ৳
                                    <span class="text-success">
                                        {{ $report->paid_amount }}
                                    </span>
                                </td>
                                <td>
                                    ৳
                                    <span class="text-danger">
                                        {{ $report->due_amount }}
                                    </span>
                                </td>
                                <td>{{ $report->title }}</td>
                                <td>
                                    @if ($report->due_amount == 0)
                                        <span class="text-success">Paid</span>
                                    @else
                                        <span class="text-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($report->due_amount == 0)
                                        @if ($report->report)
                                            <a href="{{ asset('storage/reports/' . $report->report) }}" download>Download
                                                Report</a>
                                        @endif
                                    @else
                                        Pending...
                                    @endif
                                </td>
                                <td>{{ format_date($report->inspection_date) }}</td>
                                <td>{{ format_date($report->delivery_date) }}</td>
                                <td>{{ format_date($report->delivery_date) }}</td>
                            </tr>
                        @empty
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
                <form method="POST" action="{{ route('admin.payment') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentLabel">Invoice Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="getInvoice">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function getInvoice(id) {
            var url = "{{ route('admin.payment.invoice') }}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('#getInvoice').html(response.view);
                    }
                }
            });
        }
    </script>
@endsection

@extends('layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">Create New Invoice</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.invoice.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Invoice Header -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="invoice_no">Invoice No.</label>
                                                <input type="text"
                                                    class="form-control @error('invoice_no') is-invalid @enderror"
                                                    id="invoice_no" name="invoice_no"
                                                    value="{{ generate_invoice_number() }}" readonly>
                                                @error('invoice_no')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="invoice_date">Invoice Date</label>
                                                <input type="date"
                                                    class="form-control @error('invoice_date') is-invalid @enderror"
                                                    id="invoice_date" name="invoice_date" value="{{ date('Y-m-d') }}"
                                                    readonly>
                                                @error('invoice_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="invoice_date">Payment Date</label>
                                                <input type="date"
                                                    class="form-control @error('payment_date') is-invalid @enderror"
                                                    id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}">
                                                @error('payment_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="delivery_date">Delivery Date</label>
                                                <input type="date"
                                                    class="form-control @error('delivery_date') is-invalid @enderror"
                                                    id="delivery_date" name="delivery_date" value="{{ date('Y-m-d') }}">
                                                @error('delivery_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="inspection_date">Inspection Date</label>
                                                <input type="date"
                                                    class="form-control @error('inspection_date') is-invalid @enderror"
                                                    id="inspection_date" name="inspection_date">
                                                @error('inspection_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="next_inspection_date">Next Inspection</label>
                                                <input type="date"
                                                    class="form-control @error('next_inspection_date') is-invalid @enderror"
                                                    id="next_inspection_date" name="next_inspection_date">
                                                @error('next_inspection_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6 text-md-end">
                                    <div class="company-logo">
                                        <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
                                    </div>
                                    <div class="company-information">
                                        <div>Name: {{ $company->company_name }}</div>
                                        <div>Email: {{ $company->email }}</div>
                                        <div>Phone: {{ $company->phone }}</div>
                                        <div>Address: {{ $company->address }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bill From/To Sections -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Reference Invoice</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Select your reference invoice</label>
                                                <select
                                                    class="form-select form-control js-example-basic-single @error('refer_invoice_id') is-invalid @enderror"
                                                    name="refer_invoice_id">
                                                    <option value="">Select Invoice</option>
                                                    @foreach ($invoices as $inv)
                                                        <option value="{{ $inv->id }}">{{ $inv->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('refer_invoice_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <span id="getInvoice"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Bill To</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Who is this invoice to?</label>
                                                <select
                                                    class="form-select form-control js-example-basic-single @error('customer_id') is-invalid @enderror"
                                                    name="customer_id" required>
                                                    <option value="">Select Customer</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('customer_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <span id="getCustomer"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h5 class="text-center my-4">
                                <span class="border p-1 rounded shadow-sm">Invoice Information</span>
                            </h5>
                            <div class="row">
                                <div class="col-md-7">
                                    <input type="text"
                                        class="form-control item-name @error('description') is-invalid @enderror"
                                        name="title" placeholder="Item name" required>
                                    <textarea class="form-control mt-2 item-desc" name="description" placeholder="Description" rows="2"></textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-2 row">
                                        <label for="total" class="col-sm-6 col-form-label">Total Amount</label>
                                        <div class="col-sm-6">
                                            <input type="number"
                                                class="form-control text-right @error('total_amount') is-invalid @enderror"
                                                value="0.00" id="total" name="total_amount">
                                            @error('total_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="paid" class="col-sm-6 col-form-label">Total Paid</label>
                                        <div class="col-sm-6">
                                            <input type="number"
                                                class="form-control text-right @error('paid_amount') is-invalid @enderror"
                                                value="0.00" id="paid" name="paid_amount">
                                            @error('paid_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="due" class="col-sm-6 col-form-label">Total Due</label>
                                        <div class="col-sm-6">
                                            <input type="number"
                                                class="form-control text-right @error('due_amount') is-invalid @enderror"
                                                id="due" value="0.00" name="due_amount" readonly>
                                            @error('due_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Report -->
                            <div class="mb-4">
                                <label class="form-label">Report <span class="text-danger">*</span></label>
                                <input type="file" name="report" class="form-control @error('report') is-invalid @enderror" required>
                                @error('report')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control @error('invoice_note') is-invalid @enderror" name="invoice_note" rows="3"
                                    placeholder="Thanks for your business!">Thanks for your business!</textarea>
                                @error('invoice_note')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
                                    <i class="fas fa-arrow-left me-1"></i> Back
                                </button>
                                <div>
                                    <button type="reset" class="btn btn-light me-2">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i> Save Invoice
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        // JavaScript/jQuery code
        $(document).ready(function() {
            // Initialize Select2 (if using Select2)
            $('.js-example-basic-single').select2();

            // Listen for change event on the select element
            $('select[name="customer_id"]').on('change', function() {
                var customerId = $(this).val(); // Get the selected customer ID

                // Check if a valid customer is selected
                if (customerId) {
                    // Make AJAX request
                    $.ajax({
                        url: "{{ route('admin.get.customer') }}", // Laravel route
                        type: 'GET',
                        data: {
                            customer_id: customerId
                        },
                        success: function(response) {
                            console.log(response);
                            $('#getCustomer').html(response.view);
                        },
                        error: function(xhr) {
                            // Handle errors
                            console.error('Error fetching customer data:', xhr);
                            alert('Failed to fetch customer data.');
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            $('select[name="invoice_id"]').on('change', function() {
                var invoiceId = $(this).val();

                if (invoiceId) {
                    $.ajax({
                        url: "{{ route('admin.get.invoice') }}",
                        type: 'GET',
                        data: {
                            invoice_id: invoiceId
                        },
                        success: function(response) {
                            console.log(response);
                            $('#getInvoice').html(response.view);
                        },
                        error: function(xhr) {
                            console.error('Error fetching customer data:', xhr);
                            alert('Failed to fetch customer data.');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize with example values
            $('#total').val(0);
            $('#paid').val(0);
            updateInvoice();

            // Listen for input changes on Total Amount and Total Paid
            $('#total, #paid').on('input', function() {
                updateInvoice();
            });

            function updateInvoice() {
                // Get values
                let total = parseFloat($('#total').val()) || 0;
                let paid = parseFloat($('#paid').val()) || 0;

                // Prevent negative values
                if (total < 0) {
                    $('#total').val(0);
                    total = 0;
                }
                if (paid < 0) {
                    $('#paid').val(0);
                    paid = 0;
                }

                // Ensure paid <= total
                if (paid > total) {
                    $('#paid').val(total); // Set paid to total
                    paid = total;
                }

                // Calculate due
                let due = total - paid;

                // Update Total Due input
                $('#due').val(due.toFixed(2));

                // Update Total display
                $('#invoice_total').text(total.toFixed(2));
            }
        });
    </script>
@endsection

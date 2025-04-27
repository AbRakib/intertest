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
                                                <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                                                    value="{{ generate_invoice_number() }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="invoice_date">Invoice Date</label>
                                                <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                                    value="{{ date('Y-m-d') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="invoice_date">Payment Date</label>
                                                <input type="date" class="form-control" id="payment_date" name="payment_date"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="delivery_date">Delivery Date</label>
                                                <input type="date" class="form-control" id="delivery_date" name="delivery_date"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="inspection_date">Inspection Date</label>
                                                <input type="date" class="form-control" id="inspection_date" name="inspection_date">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating mb-2">
                                                <label for="next_inspection_date">Next Inspection</label>
                                                <input type="date" class="form-control" id="next_inspection_date" name="next_inspection_date">
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
                                                <select class="form-select form-control js-example-basic-single"
                                                    name="refer_invoice_id">
                                                    <option value="">Select Invoice</option>
                                                    @foreach ($invoices as $inv)
                                                        <option value="{{ $inv->id }}">{{ $inv->title }}</option>
                                                    @endforeach
                                                </select>
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
                                                <select class="form-select form-control js-example-basic-single"
                                                    name="customer_id" required>
                                                    <option value="">Select Customer</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
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
                                    <input type="text" class="form-control item-name" name="title"
                                        placeholder="Item name" required>
                                    <textarea class="form-control mt-2 item-desc" name="description" placeholder="Description" rows="2"></textarea>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-2 row">
                                        <label for="total" class="col-sm-6 col-form-label">Total Amount</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control text-right" value="0.00"
                                                id="total" name="total_amount">
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="paid" class="col-sm-6 col-form-label">Total Paid</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control text-right" value="0.00"
                                                id="paid" name="paid_amount">
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="due" class="col-sm-6 col-form-label">Total Due</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control text-right" id="due"
                                                value="0.00" name="due_amount" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Report -->
                            <div class="mb-4">
                                <label class="form-label">Report</label>
                                <input type="file" class="form-control">
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="invoice_note" rows="3" placeholder="Thanks for your business!">Thanks for your business!</textarea>
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
                                    <button type="submit" class="btn btn-primary">
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

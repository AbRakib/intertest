<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $invoices = Invoice::where('deleted', Invoice::DELETED_NO)
            ->orderByDesc('created_at')
            ->get();
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $customers = Customer::where('status', Customer::STATUS_ACTIVE)
            ->where('deleted', Customer::DELETED_NO)
            ->get();

        $company = Company::where('status', Company::STATUS_ACTIVE)
            ->where('deleted', Company::DELETED_NO)
            ->first();

        $invoices = Invoice::where('status', Company::STATUS_ACTIVE)
            ->where('deleted', Company::DELETED_NO)
            ->get();
        return view('invoice.create', compact('customers', 'company', 'invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $validatedData = $request->validate([
            'invoice_no'      => 'required|unique:invoices',
            'customer_id'     => 'required|exists:customers,id',
            'invoice_date'    => 'required|date',
            'inspection_date' => 'required|date',
            'payment_date'    => 'nullable|date',
            'delivery_date'   => 'nullable|date',
            'title'           => 'required|string|max:255',
            'total_amount'    => 'required|numeric|min:0',
            'paid_amount'     => 'required|numeric|min:0',
            'due_amount'      => 'required|numeric',
            'invoice_note'    => 'nullable|string',
            'report'          => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $invoice = new Invoice();

            // Upload report file
            if ($request->hasFile('report')) {
                $file     = $request->file('report');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('reports', $filename, 'public');
                $invoice->report = $filename;
            }

            $invoice->invoice_no           = $validatedData['invoice_no'];
            $invoice->customer_id          = $validatedData['customer_id'];
            $invoice->user_id              = Auth::user()->id;
            $invoice->invoice_date         = $validatedData['invoice_date'];
            $invoice->inspection_date      = $validatedData['inspection_date'];
            $invoice->next_inspection_date = $request->next_inspection_date;
            $invoice->payment_date         = $validatedData['payment_date'];
            $invoice->delivery_date        = $validatedData['delivery_date'];
            $invoice->total_amount         = $validatedData['total_amount'];
            $invoice->paid_amount          = $validatedData['paid_amount'];
            $invoice->due_amount           = $validatedData['due_amount'];
            $invoice->title                = $validatedData['title'];
            $invoice->description          = $request->description;
            $invoice->invoice_note         = $validatedData['invoice_note'];
            $invoice->refer_invoice_id     = $request->refer_invoice_id ?? 0;

            if ($invoice->due_amount >= 0) {
                $invoice->payment_status = Invoice::PAYMENT_PARTIAL;
            } elseif ($invoice->due_amount == 0) {
                $invoice->payment_status = Invoice::PAYMENT_PAID;
            } else {
                $invoice->payment_status = Invoice::PAYMENT_UNPAID;
            }

            if ($request->due_amount == 0) {
                $invoice->payment_status = Invoice::PAYMENT_PAID;
            } elseif ($invoice->due_amount == $invoice->total_amount) {
                $invoice->payment_status = Invoice::PAYMENT_PARTIAL;
            } else {
                $invoice->payment_status = Invoice::PAYMENT_UNPAID;
            }

            $invoice->status     = Invoice::STATUS_ACTIVE;
            $invoice->created_at = now();
            $invoice->created_by = Auth::user()->id;
            $invoice->save();

            // payment store code here
            if ($invoice->paid_amount > 0) {
                $payment                 = new Payment();
                $payment->invoice_id     = $invoice->id;
                $payment->customer_id    = $invoice->customer_id;
                $payment->payment_date   = $invoice->payment_date;
                $payment->payment_method = 'Cash';
                $payment->amount         = $invoice->total_amount;
                $payment->note           = 'Invoice Payment';
                $payment->status         = Payment::STATUS_ACTIVE;
                $payment->created_at     = now();
                $payment->created_by     = Auth::user()->id;
                $payment->save();
            }

            DB::commit();

            return redirect()->route('admin.invoice.list')
                ->with('success', 'Invoice created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice, $id) {
        $invoice = Invoice::where('id', $id)
            ->first();

        $customers = Customer::where('status', Customer::STATUS_ACTIVE)
            ->where('deleted', Customer::DELETED_NO)
            ->get();

        $company = Company::where('status', Company::STATUS_ACTIVE)
            ->where('deleted', Company::DELETED_NO)
            ->first();

        $invoices = Invoice::where('status', Company::STATUS_ACTIVE)
            ->where('deleted', Company::DELETED_NO)
            ->get();

        return view('invoice.edit', compact('invoice', 'customers', 'company', 'invoices'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $invoice = Invoice::where('id', $id)
            ->first();
        $validatedData = $request->validate([
            'invoice_no'      => 'required|unique:invoices,invoice_no,' . $id,
            'customer_id'     => 'required|exists:customers,id',
            'invoice_date'    => 'required|date',
            'inspection_date' => 'required|date',
            'payment_date'    => 'nullable|date',
            'delivery_date'   => 'nullable|date',
            'title'           => 'required|string|max:255',
            'total_amount'    => 'required|numeric|min:0',
            'paid_amount'     => 'required|numeric|min:0',
            'due_amount'      => 'required|numeric',
            'invoice_note'    => 'nullable|string',
            'report'          => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // Update report file if new one is uploaded
            if ($request->hasFile('report')) {
                // Delete old file if exists
                if ($invoice->report && Storage::disk('public')->exists('reports/' . $invoice->report)) {
                    Storage::disk('public')->delete('reports/' . $invoice->report);
                }

                $file     = $request->file('report');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('reports', $filename, 'public');
                $invoice->report = $filename;
            }

            $invoice->invoice_no           = $validatedData['invoice_no'];
            $invoice->customer_id          = $validatedData['customer_id'];
            $invoice->user_id              = Auth::user()->id;
            $invoice->invoice_date         = $validatedData['invoice_date'];
            $invoice->inspection_date      = $validatedData['inspection_date'];
            $invoice->next_inspection_date = $request->next_inspection_date;
            $invoice->payment_date         = $validatedData['payment_date'];
            $invoice->delivery_date        = $validatedData['delivery_date'];
            $invoice->total_amount         = $validatedData['total_amount'];
            $invoice->paid_amount          = $validatedData['paid_amount'];
            $invoice->due_amount           = $validatedData['due_amount'];
            $invoice->title                = $validatedData['title'];
            $invoice->description          = $request->description;
            $invoice->invoice_note         = $validatedData['invoice_note'];
            $invoice->refer_invoice_id     = $request->refer_invoice_id ?? 0;

            // Update payment status
            if ($validatedData['due_amount'] == 0) {
                $invoice->payment_status = Invoice::PAYMENT_PAID;
            } elseif ($validatedData['due_amount'] == $validatedData['total_amount']) {
                $invoice->payment_status = Invoice::PAYMENT_UNPAID;
            } else {
                $invoice->payment_status = Invoice::PAYMENT_PARTIAL;
            }

            $invoice->updated_at = now();
            $invoice->updated_by = Auth::user()->id;
            $invoice->save();

            // Update or create payment record if paid_amount changed
            if ($validatedData['paid_amount'] > 0) {
                $payment = Payment::where('invoice_id', $invoice->id)->first();

                if (! $payment) {
                    $payment              = new Payment();
                    $payment->invoice_id  = $invoice->id;
                    $payment->customer_id = $invoice->customer_id;
                    $payment->note        = 'Invoice Payment';
                    $payment->status      = Payment::STATUS_ACTIVE;
                    $payment->created_at  = now();
                    $payment->created_by  = Auth::user()->id;
                }

                $payment->payment_date   = $invoice->payment_date;
                $payment->payment_method = 'Cash'; // You might want to make this dynamic
                $payment->amount         = $validatedData['paid_amount'];
                $payment->updated_at     = now();
                $payment->updated_by     = Auth::user()->id;
                $payment->save();
            }

            DB::commit();

            return redirect()->route('admin.invoice.list')
                ->with('success', 'Invoice updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice) {
        //
    }

    public function getCustomer(Request $request) {
        $customer = Customer::where('id', $request->customer_id)
            ->where('status', Customer::STATUS_ACTIVE)
            ->where('deleted', Customer::DELETED_NO)
            ->first();

        $view = view('invoice.customer', compact('customer'))->render();

        return response()->json([
            'status' => 200,
            'view'   => $view,
        ]);
    }

    public function getInvoice(Request $request) {
        $invoice = Invoice::where('id', $request->customer_id)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->first();

        $view = view('invoice.invoice', compact('invoice'))->render();

        return response()->json([
            'status' => 200,
            'view'   => $view,
        ]);
    }

    public function paymentInvoice(Request $request) {
        $invoice = Invoice::where('id', $request->id)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->first();

        $view = view('invoice.payment_invoice', compact('invoice'))->render();

        return response()->json([
            'status' => 200,
            'view'   => $view,
        ]);
    }

    public function paid() {
        $invoices = Invoice::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->where('payment_status', Invoice::PAYMENT_PAID)
            ->get();
        return view('invoice.paid', compact('invoices'));
    }

    public function unpaid() {
        $invoices = Invoice::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->where('payment_status', '!=', Invoice::PAYMENT_PAID)
            ->get();
        return view('invoice.unpaid', compact('invoices'));
    }

    public function report() {
        $customer = Customer::where('email', Auth::user()->email)->first();
        $reports  = Invoice::where('customer_id', $customer->id)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->get();

        return view('report.index', compact('reports'));
    }

    public function paymentHistory() {
        $customer = Customer::where('email', Auth::user()->email)->first();
        $payments = Payment::where('customer_id', $customer->id)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->get();

        return view('report.payment_history', compact('payments'));
    }

    public function download($id) {
        $company = Company::where('status', Company::STATUS_ACTIVE)->where('deleted', Company::DELETED_NO)->first();
        $invoice = Invoice::with('customer')->findOrFail($id);
        $pdf = Pdf::loadView('invoice.pdf', compact('invoice', 'company'));
        return $pdf->download('invoice-' . $invoice->invoice_no . '.pdf');
    }
}

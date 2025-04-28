<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $payments = Payment::where('deleted', PAYMENT::DELETED_NO)
            ->get();
        
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'payment' => 'required|numeric',
        ]);

        try {
            $payment                 = new Payment();
            $payment->invoice_id     = $request->invoice_id;
            $payment->customer_id    = $request->customer_id;
            $payment->payment_date   = $request->payment_date;
            $payment->payment_method = $request->payment_method;
            $payment->note           = $request->note;
            $payment->amount         = $request->payment;
            $payment->created_at     = now();
            $payment->created_by     = Auth::user()->id;
            $payment->save();

            $invoice = Invoice::where('id', $request->invoice_id)
                ->where('status', Invoice::STATUS_ACTIVE)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();

            $invoice->payment_date = now();
            $invoice->paid_amount  = $invoice->paid_amount + $payment->amount;
            $invoice->due_amount   = ($invoice->due_amount) - ($payment->amount);
            if ($invoice->due_amount == 0) {
                $invoice->payment_status = Invoice::PAYMENT_PAID;
            } elseif ($invoice->due_amount > 0 && $invoice->due_amount < $invoice->total_amount) {
                $invoice->payment_status = Invoice::PAYMENT_PARTIAL;
            } else {
                $invoice->payment_status = Invoice::PAYMENT_UNPAID;
            }
            $invoice->save();

            flash()->success('Invoice Payment Complete');
            return redirect()->route('admin.invoice.list');
        } catch (\Exception $err) {
            flash()->error($err->getMessage());
            return redirect()->back();
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment) {
        //
    }

    
}

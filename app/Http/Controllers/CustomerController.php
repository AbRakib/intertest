<?php
namespace App\Http\Controllers;

use App\Mail\CustomerCredentialMail;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $customers = Customer::where('deleted', Customer::DELETED_NO)
            ->with('user')
            ->get();

        return view("customer.index", compact("customers"));
    }

    public function active() {
        $customers = Customer::where('deleted', Customer::DELETED_NO)
            ->where('status', Customer::STATUS_ACTIVE)
            ->with('user')
            ->get();

        return view("customer.active", compact("customers"));
    }

    public function inactive() {
        $customers = Customer::where('deleted', Customer::DELETED_NO)
            ->where('status', Customer::STATUS_INACTIVE)
            ->with('user')
            ->get();

        return view("customer.inactive", compact("customers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view("customer.create");
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'nullable|string|unique:customers,phone',
            'password' => 'required|string|min:6',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address'  => 'nullable|string|max:500',
        ]);

        // Generate customer ID
        $lastCustomer                 = Customer::orderBy('id', 'desc')->first();
        $nextId                       = $lastCustomer ? intval(substr($lastCustomer->customer_id, 3)) + 1 : 1;
        $validatedData['customer_id'] = 'CID' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Handle file upload if photo exists
        if ($request->hasFile('photo')) {
            $photoPath              = $request->file('photo')->store('customer_photos', 'public');
            $validatedData['photo'] = $photoPath;
        }

        $plainPassword = $validatedData['password'];
        // Hash the password before saving
        $validatedData['password']   = Hash::make($validatedData['password']);
        $validatedData['created_by'] = Auth::user()->id;
        

        try {
            // Create the customer record
            $customer = Customer::create($validatedData);
            // Create the admin record
            $user = User::create($validatedData);

            // Send email with credentials
            Mail::to($customer->email)->send(new CustomerCredentialMail($customer->email, $plainPassword));

            // Redirect with success message
            return redirect()->route('admin.customer.list')
                ->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating customer. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $customer = Customer::where('id', $id)->first();
        return view("customer.view", compact('customer'));
    }

    public function status($id) {
        $customer = Customer::where('id', $id)->first();
        if ($customer->status == Customer::STATUS_ACTIVE) {
            $customer->status = Customer::STATUS_INACTIVE;
        } else {
            $customer->status = Customer::STATUS_ACTIVE;
        }

        $customer->updated_at = now();
        $customer->updated_by = Auth::user()->id;
        $customer->save();

        return redirect()->back()->with('success', 'Customer Status Updated');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $customer = Customer::where('id', $id)->first();
        return view("customer.edit", compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        $id            = $request->id;
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $id,
            'phone'   => 'nullable|string|unique:customers,phone,' . $id,
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $customer = Customer::where('id', $id)
                ->first();

            $customer->name       = $request->name;
            $customer->phone      = $request->phone;
            $customer->email      = $request->email;
            $customer->address    = $request->address;
            $customer->updated_at = now();
            $customer->updated_by = Auth::user()->id;
            $customer->save();

            return redirect()->route('admin.customer.list')->with('success', 'Customer Update Successful');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating customer: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $customer = Customer::where('id', $id)
            ->first();

        $customer->deleted    = Customer::DELETED_YES;
        $customer->deleted_at = now();
        $customer->deleted_by = Auth::user()->id;
        $customer->save();

        return redirect()->route('admin.customer.list')->with('success', 'Customer Deleted Successful');
    }
}

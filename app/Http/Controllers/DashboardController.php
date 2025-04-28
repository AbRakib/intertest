<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller {
    public function dashboard() {
        $invoices = Invoice::where('status', Invoice::STATUS_ACTIVE)->where('deleted', Invoice::DELETED_NO)->count();
        $complete = Invoice::where('payment_status', Invoice::PAYMENT_PAID)->where('status', Invoice::STATUS_ACTIVE)->where('deleted', Invoice::DELETED_NO)->count();
        $pending = Invoice::where('payment_status', '!=', Invoice::PAYMENT_PAID)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->count();
            
        $customers = Customer::where('status', Invoice::STATUS_ACTIVE)
            ->where('deleted', Invoice::DELETED_NO)
            ->count();

        return view("dashboard", compact('invoices', 'complete', 'pending', 'customers'));
    }

    public function profile() {
        $user = User::where('id', Auth::user()->id)
            ->where('status', User::STATUS_ACTIVE)
            ->where('deleted', User::DELETED_NO)
            ->first();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request) {
        try {
            $user = User::where('email', $request->email)
                ->where('status', User::STATUS_ACTIVE)
                ->where('deleted', User::DELETED_NO)
                ->first();

            $customer = Customer::where('email', $request->email)
                ->where('status', User::STATUS_ACTIVE)
                ->where('deleted', User::DELETED_NO)
                ->first();

            if ($customer) {
                $customer->name       = $request->name;
                $customer->email      = $request->email;
                $customer->phone      = $request->phone;
                $customer->address    = $request->address;
                $customer->updated_at = now();
                $customer->updated_by = Auth::user()->id;
                $customer->save();
            }

            if ($user) {
                $user->name       = $request->name;
                $user->email      = $request->email;
                $user->phone      = $request->phone;
                $user->address    = $request->address;
                $user->updated_at = now();
                $user->updated_by = Auth::user()->id;
                $user->save();
            }

            flash()->success('User Profile Updated!!');
            return redirect()->back();
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function changePassword() {
        $user = User::where('id', Auth::user()->id)
            ->first();

        return view('profile.change_password', compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'password'     => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Verify current password
        if (! Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}

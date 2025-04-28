<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function login() {
        return view("auth.login");
    }

    public function adminLogin() {
        return view("auth.admin-login");
    }

    public function checkLogin(Request $request) {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'role'     => 0,
            'is_admin' => 0,
            'email'    => $request->email,
            'password' => $request->password,
        ])) {
            flash()->success('Customer Login Successfully');
            return redirect()->route('admin.dashboard');
        } else {
            flash()->error('Failed to customer login');
            return redirect()->back();
        }
    }

    public function adminCheckLogin(Request $request) {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ])) {
            flash()->success('Admin Login Successfully');
            return redirect()->route('admin.dashboard');
        } else {
            flash()->error('Failed to admin login');
            return redirect()->back();
        }
    }

    public function logout(Request $request) {
        $user = Auth::user();
        if ($user->role == User::ROLE_ADMIN) {
            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                flash()->success('Admin logged out successfully.');
                return redirect()->route('admin.login'); // 🛠️ admin login route
            }
        } else {
            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                flash()->success('Customer logged out successfully.');
                return redirect()->route('login'); // 🛠️ customer login route
            }
        }

        flash()->error('No authenticated user found.');
        return redirect()->back();
    }

}

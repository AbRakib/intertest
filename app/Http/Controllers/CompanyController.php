<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $company = Company::where('status', Company::STATUS_ACTIVE)
            ->first();

        return view('company.index', compact('company'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company) {
        $validated = $request->validate([
            'company_name' => 'required',
            'email'        => 'required',
            'phone'        => 'required',
            'address'      => 'required',
        ]);

        try {
            $company = Company::where('id', $request->id)
                ->where('status', Company::STATUS_ACTIVE)
                ->where('deleted', Company::DELETED_NO)
                ->first();
            $company->company_name    = $request->company_name;
            $company->email           = $request->email;
            $company->phone           = $request->phone;
            $company->address         = $request->address;
            $company->company_details = $request->company_details;
            $company->created_at      = now();
            $company->created_by      = Auth::user()->id;
            $company->updated_at      = now();
            $company->updated_by      = Auth::user()->id;
            $company->save();

            return redirect()->back()->with('success', 'Company Information Updated');
        } catch (\Exception $error) {
            return redirect()->back()->with('warning', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company) {
        //
    }
}

<ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-text mx-3">
        <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
    </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">


<!-- Nav Item - Pages Collapse Menu -->
@if (Auth::user()->role == 1 && Auth::user()->is_admin == 1)
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-users"></i>
        <span>Customers</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.customer.list') }}">All Customers</a>
            <a class="collapse-item" href="{{ route('admin.customer.create') }}">Add New</a>
            <a class="collapse-item" href="{{ route('admin.customer.active') }}">Active Customers</a>
            <a class="collapse-item" href="{{ route('admin.customer.inactive') }}">Inactive Customers</a>
        </div>
    </div>
</li>
@endif

<!-- Nav Item - Utilities Collapse Menu -->
@if (Auth::user()->role == 1 && Auth::user()->is_admin == 1)
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice"
        aria-expanded="true" aria-controls="collapseInvoice">
        <i class="fas fa-file-invoice"></i>
        <span>Invoices</span>
    </a>
    <div id="collapseInvoice" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.invoice.list') }}">All Invoices</a>
            <a class="collapse-item" href="{{ route('admin.invoice.create') }}">Create Invoice</a>
            <a class="collapse-item" href="{{ route('admin.invoice.unpaid') }}">Unpaid Invoices</a>
            <a class="collapse-item" href="{{ route('admin.invoice.paid') }}">Paid Invoices</a>
        </div>
    </div>
</li>
@endif

@if (Auth::user()->role == 0 && Auth::user()->is_admin == 0)
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-users"></i>
        <span>Reports</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.report.list') }}">All Report</a>
        </div>
    </div>
</li>
@endif

@if (Auth::user()->role == 1 && Auth::user()->is_admin == 1)
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.payment.list') }}">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Payment History</span></a>
</li>
@endif

@if (Auth::user()->role == 0 && Auth::user()->is_admin == 0)
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.payment.list') }}">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Payment History</span></a>
</li>
@endif


{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction"
        aria-expanded="true" aria-controls="collapseTransaction">
        <i class="fas fa-hand-holding-usd"></i>
        <span>Transactions</span>
    </a>
    <div id="collapseTransaction" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Transaction Utilities:</h6>
            <a class="collapse-item" href="#">All Transactions</a>
        </div>
    </div>
</li> --}}

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Settings
</div>

@if (Auth::user()->role == 1 && Auth::user()->is_admin == 1)
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.company.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Company Setting</span></a>
</li>
@endif


<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-id-card-alt"></i>
        <span>Profile</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.profile') }}">My Profile</a>
            <a class="collapse-item" href="{{ route('admin.change.password') }}">Change Password</a>
        </div>
    </div>
</li>

<!-- Nav Item - Tables -->
{{-- <li class="nav-item">
    <a class="nav-link" href="tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li> --}}

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>


</ul>
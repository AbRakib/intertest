@extends('layout')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customer</h1>

    <div class="row justify-content-center">
        <div class="col-md-4 col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-white d-flex justify-content-between">
                    <h4 class="mb-0">Customer Profile</h4>
                    @if ($customer->status == 1)
                        <a class="btn btn-sm btn-success" href="{{ route('admin.customer.status', $customer->id) }}">Active</a>
                    @else
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.customer.status', $customer->id) }}">Inactive</a>
                    @endif


                </div>
                <div class="card-body">
                    <div class="text-center">
                        @if ($customer->photo)
                            <img class="img-fluid customer-profile-img" src="{{ asset('storage/' . $customer->photo) }}"
                                width="50" class="img-thumbnail">
                        @else
                            <img class="img-fluid customer-profile-img" src="{{ asset('images/icon.jpeg') }}"
                                alt="demo user">
                        @endif
                        <div> {{ $customer->name }} </div>
                        <div> {{ $customer->email }} </div>
                        <div> {{ $customer->phone }} </div>
                        <div> {{ $customer->address }} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

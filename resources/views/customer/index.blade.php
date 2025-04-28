@extends('layout')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customers</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Customer List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm customer-table small" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 10%">Customer Id</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 20%">Email/Phone</th>
                            <th style="width: 20%">Address</th>
                            <th style="width: 10%">Created At</th>
                            <th style="width: 10%">Created By</th>
                            <th style="width: 5%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="width: 10%">Customer Id</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 20%">Email/Phone</th>
                            <th style="width: 20%">Address</th>
                            <th style="width: 10%">Created At</th>
                            <th style="width: 10%">Created By</th>
                            <th style="width: 5%" class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->customer_id }}</td>
                                <td class="d-flex align-items-center">
                                    <div>
                                        @if ($customer->photo)
                                            <img class="img-fluid customer-profile-img"
                                                src="{{ asset('storage/' . $customer->photo) }}" width="50"
                                                class="img-thumbnail">
                                        @else
                                            <img class="img-fluid customer-profile-img"
                                                src="{{ asset('images/icon.jpeg') }}" alt="demo user">
                                        @endif
                                    </div>
                                    <div class="ml-2">
                                        {{ $customer->name }}
                                        <br>
                                        @if ($customer->status == 1)
                                            <span class="badge text-white bg-success">Active</span>
                                        @else
                                            <span class="badge text-white bg-secondary">Inactive</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $customer->email }}
                                    <br>
                                    {{ $customer->phone }}
                                </td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ format_date($customer->created_at) }}</td>
                                <td>{{ $customer->user->name }}</td>
                                {{-- <td class="text-center mt-2">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('admin.customer.show', $customer->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customer.edit', $customer->id) }}"
                                            class="btn btn-sm btn-secondary">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.customer.destroy', $customer->id) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td> --}}
                                <td class="text-center mt-2">
                                    <div class="dropdown">
                                        <button class="btn btn-sm" type="button" id="actionDropdown{{ $customer->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu text-center" aria-labelledby="actionDropdown{{ $customer->id }}">
                                            <a href="{{ route('admin.customer.show', $customer->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.customer.edit', $customer->id) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.customer.destroy', $customer->id) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

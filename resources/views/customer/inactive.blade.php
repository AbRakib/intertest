@extends('layout')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customers</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Inactive Customer List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm customer-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Customer Id</th>
                            <th>Name</th>
                            <th>Email/Phone</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Customer Id</th>
                            <th>Name</th>
                            <th>Email/Phone</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th class="text-center">Action</th>
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
                                <td>{{ format_data($customer->created_at) }}</td>
                                <td>{{ $customer->user->name }}</td>
                                <td class="text-center mt-2">
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

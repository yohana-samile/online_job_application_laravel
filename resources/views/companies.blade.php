@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card bg-glass">
            <div class="card-header">
                <div class="row">
                    <div class="float-left col-md-6">
                        <h4>Companies Registered</h4>
                    </div>
                    <div class="float-right col-md-6">
                        <a href="{{ url('register_new_company')}}" class="btn primaryColor text-white text-center float-right">Register New Company <i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered text-capitalize">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($companies as $company)
                            @php
                                $sn = 1;
                            @endphp
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->created_at }}</td>
                                <td hidden><a href="{{ Storage::url($company->id) }}" class="text-danger">Delete <i class="fa fa-trash text-danger"></i></a></td>
                                <td><a href="javascript::void(0)" class="text-danger">Delete <i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

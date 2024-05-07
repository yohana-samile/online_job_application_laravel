@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card bg-glass">
            <div class="card-body">
                <table class="table table-hover table-bordered text-capitalize">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Applicant Name</th>
                            <th>Email Id</th>
                            <th>nationality</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Applicant Name</th>
                            <th>Email Id</th>
                            <th>nationality</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($applicants as $applicant)
                            @php
                                $sn = 1;
                            @endphp
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $applicant->first_name }}</td>
                                <td>{{ $applicant->email }}</td>
                                <td>{{ $applicant->nationality }}</td>
                                <td>{{ $applicant->gender }}</td>
                                <td><a href="{{ Storage::url($applicant->job_seeker_cv) }}" target="_blank">View Cv <i class="fa fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

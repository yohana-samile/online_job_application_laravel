@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card bg-glass">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table class="table table-hover table-bordered text-capitalize">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Date Time Applied</th>
                            <th>Applicant Name</th>
                            <th colspan="3" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Date Time Applied</th>
                            <th>Applicant Name</th>
                            <th colspan="3" class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($applications as $application)
                            @php
                                $sn = 1;
                            @endphp
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $application->jobTitle }}</td>
                                <td>{{ $application->date_applied }}</td>
                                <td>{{ $application->name }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="{{ asset($application->job_seeker_cv) }}" target="_blank" class="primaryColor btn-sm text-white">View Cv <i class="fa fa-eye"></i></a>
                                        </div>
                                        <div class="col-md-4">
                                            @if ($application->interview_date == null)
                                                @if ($application->application_status != 'deny')
                                                    <a href="{{ url('interview_invitation', ['id' => $application->id]) }}" class="primaryColor btn-sm text-white">Invite Interview <i class="fa fa-eye"></i></a>
                                                @endif
                                            @else
                                                <p class="alert alert-success">{{ $application->interview_date }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if ($application->application_status == "pending")
                                                <form action="{{ route('deny_this_application', ['id' => $application->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="submit" value="Deny" class="text-white bg-danger form-control">
                                                </form>
                                            @else
                                                <p class="alert alert-danger">Denied <i class="fa fa-mark"></i></p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

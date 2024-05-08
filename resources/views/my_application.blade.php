@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card bg-glass">
            <div class="card-body">
                <table class="table table-hover table-bordered text-capitalize">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Date Applied</th>
                            <th>Interview</th>
                            <th colspan="3" class="text-center">Result</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Date Applied</th>
                            <th>Interview</th>
                            <th colspan="3" class="text-center">Result</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($my_applications as $my_application)
                            @php
                                $sn = 1;
                            @endphp
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $my_application->jobTitle }}</td>
                                <td>{{ $my_application->date_applied }}</td>
                                <td>
                                    @if ($my_application->interview_date == null)
                                        <p class="alert alert-danger">Not Located</p>
                                    @else
                                        <p class="alert alert-success">{{ $my_application->interview_date }}</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <a href="{{ Storage::url($my_application->job_seeker_cv) }}" target="_blank" class="primaryColor btn-sm text-white"> Cv <i class="fa fa-eye"></i></a>
                                        </div>
                                        <div class="col-md-7">
                                            @if ($my_application->application_status == "pending")
                                                <p class="alert alert-primary">Pending</p>
                                            @elseif ($my_application->application_status == "accepted")
                                                <p class="alert alert-success">Accepted</p>
                                            @else
                                                <p class="alert alert-danger">Denied</p>
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

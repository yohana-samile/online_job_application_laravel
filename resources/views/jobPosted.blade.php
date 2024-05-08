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
                            <th>Salary</th>
                            <th>Posted</th>
                            <th>Application End</th>
                            <th>Status</th>
                            <th colspan="3" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Salary</th>
                            <th>Posted</th>
                            <th>Application End</th>
                            <th>Status</th>
                            <th colspan="3" class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($jobs as $job)
                            @php
                                $sn = 1;
                            @endphp
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $job->jobTitle }}</td>
                                <td>{{ $job->jobSalary }}</td>
                                <td>{{ $job->datePosted }}</td>
                                <td>{{ $job->endOfApllication }}</td>
                                <td>
                                    @if ($job->status == 'closed')
                                        <p class="alert alert-danger">{{ $job->status }}</p>
                                    @elseif ($job->status == 'extended')
                                        <p class="alert alert-success">{{ $job->status }}</p>
                                    @else
                                        <p class="alert alert-success">{{ $job->status }}</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2">
                                            @if ($job->pdf_description != null)
                                                <a href="{{ Storage::url($job->pdf_description) }}" target="_blank" class="primaryColor btn-sm text-white"><i class="fa fa-eye"></i></a>
                                            @endif
                                        </div>
                                        <div class="col-md-5">
                                            @if ($job->status == 'closed')
                                                <a href="{{ url('extend_job_application', ['id' => $job->id]) }}" class="primaryColor btn-sm text-white">Extend <i class="fa fa-plus"></i></a>
                                            @endif
                                        </div>
                                        <div class="col-md-5">
                                            @if ($job->status == "unclosed" || $job->status == "extended")
                                                <form action="{{ route('close_job_application', ['id' => $job->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="submit" value="Close Application" class="text-white bg-danger form-control">
                                                </form>
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

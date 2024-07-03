@extends('layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    $userId = Auth::user()->id;
    $userRole = DB::select("SELECT roles.name as role_name, users.id from roles, users where users.role_id = roles.id and users.id = '$userId' ");
    $userRole = $userRole[0];
    $jobs = DB::select("SELECT * from jobs where status != 'closed' ");
    $profile = DB::select("SELECT * from applicants where cv_uploaded = 1 and user_id = '$userId' ");
    $today_date = \Carbon\Carbon::now()->format('Y-m-d');

    // sumary
    $applicants = DB::select("SELECT COUNT(id) as count FROM applicants ");
    $jobs = DB::select("SELECT COUNT(id) as count FROM jobs WHERE status = 'unclosed' ");
    $companies = DB::select("SELECT COUNT(id) as count FROM users WHERE role_id = 2 ");
    $applicants = $applicants[0]->count ?? 0;
    $jobs = $jobs[0]->count ?? 0;
    $companies = $companies[0]->count ?? 0;
@endphp
    <div class="container">
        @if ($userRole->role_name === 'is_applicant')
            @if (!empty($profile))
                <div class="row">
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
                    @if (empty($jobs))
                        <p class="alert alert-danger">No Job Posted At The Moment</p>
                    @endif
                    @foreach ($jobs as $index => $job)
                        @if($index % 3 == 0 && $index > 0)
                            </div><div class="row">
                        @endif
                        <div class="col-md-4 col-sm-6 my-2">
                            <div class="card m-auto job" style="width: 20rem;">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $job->jobTitle }}</h4>
                                    <p class="card-text">{{ $job->jobDiscription; }}</p>
                                    <p class="card-text">{{__('Job Salary:')}} {{ $job->jobSalary; }}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <td><a href="{{ Storage::url($job->pdf_description) }}" target="_blank">Job Desc <i class="fa fa-eye"></i></a></td>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="card-text badge badge-primary company"  style="background-color: #525f7f;">Deadline {{ $job->endOfApllication; }}</p>
                                        </div>
                                    </div>


                                    @if($job->endOfApllication < $today_date )
                                        <div class="alert alert-danger">
                                            <p>Application Closed</p>
                                        </div>
                                    @else
                                        <!-- Button apply jobs -->
                                        <form method="POST" action="{{ route('apply_for_a_job') }}" enctype="multipart/form-data">
                                            @csrf
                                                <input type="hidden" id="date_applied" name="date_applied" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" />
                                                <input type="hidden" id="user_id" name="user_id" value="{{$userId}}" class="form-control" />
                                                <input type="hidden" id="job_id" name="job_id" value="{{$job->id}}" class="form-control" />
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="submit" name="submit" value="Apply For A Job" class="text-white form-control primaryColor">
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card bg-glass">
                    <div class="card-body px-4 py-5 px-md-5">
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
                        <form method="POST" action="{{ route('complite_registration') }}" enctype="multipart/form-data">
                            @csrf
                            <div data-mdb-input-init class="form-outline">
                                <input type="text" id="nationality" name="nationality" class="form-control" />
                                <input type="hidden" id="user_id" name="user_id" value="{{$userId}}" class="form-control" />
                                <label class="form-label" for="nationality">{{__('Enter nationality')}}</label>
                            </div>
                            <div data-mdb-input-init class="form-outline">
                                <select name="gender" class="form-control" id="gender">
                                    <option selected hidden disabled>Choose Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <label class="form-label" for="gender">{{__('Choose Gender')}}</label>
                            </div>
                            <div data-mdb-input-init class="form-outline">
                                <input type="file" name="job_seeker_cv" id="job_seeker_cv" class="form-control">
                                <label class="form-label" for="gender">{{__('Upload Your Cv (pdf only)')}}</label>
                            </div>
                            <div data-mdb-input-init class="form-outline">
                                <input type="submit" name="submit" value="Complite Your Registration" class="text-white form-control primaryColor">
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @else
            <!-- Content Row -->
            <div class="row">
                <!-- jobs -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Job Posted</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jobs }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-database fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- jobs -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Applicants</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $applicants }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Companies</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $companies }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-recycle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

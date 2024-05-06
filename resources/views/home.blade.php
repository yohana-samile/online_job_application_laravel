@extends('layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\DB;
    $userId = Auth::user()->id;
    $userRole = DB::select("SELECT roles.name as role_name, users.id from roles, users where users.role_id = roles.id and users.id = '$userId' ");
    $userRole = $userRole[0];
    $jobs = DB::select("SELECT * from jobs where status = 'unclosed' ");
    $profile = DB::select("SELECT * from applicants where cv_uploaded = 1 and user_id = '$userId' ");
    $today_date = \Carbon\Carbon::now()->format('Y-m-d');
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
                @foreach ($jobs as $index => $job)
                    @if($index % 3 == 0 && $index > 0)
                        </div><div class="row">
                    @endif
                    <div class="col-md-4 col-sm-6 my-2">
                        <div class="card m-auto job" style="width: 20rem;">
                            <div class="card-body">
                                <h4 class="card-title">{{ $job->jobTitle }}</h4>
                                <p class="card-text">{{ $job->jobDiscription; }}</p>
                                <p class="card-text badge badge-primary company"  style="background-color: #525f7f;">Deadline {{ $job->endOfApllication; }}</p>

                                @if($job->endOfApllication < $today_date )
                                    <div class="alert alert-danger">
                                        <p>Application Closed</p>
                                    </div>
                                @else
                                    <!-- Button apply jobs -->
                                    {{-- <a href="{{ url('login') }}" class="btn btn-light text-white float-right">Apply For A Job </a> --}}
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
        {{-- post new job --}}
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
                <form method="POST" action="{{ route('store_job') }}">
                    @csrf
                    <!-- 2 column grid layout with text inputs for the first and last names -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <input type="text" id="jobTitle" name="jobTitle" class="form-control" />
                                <input type="hidden" id="datePosted" name="datePosted" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" />
                                <label class="form-label" for="jobTitle">{{__('Enter Job Title')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <input type="text" id="jobDiscription" name="jobDiscription" class="form-control" />
                                <label class="form-label" for="jobDiscription">{{__('Enter Job Discription (optional)')}}</label>
                            </div>
                        </div>
                    </div>

                    <!-- jobSalary input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="number" id="jobSalary" class="form-control" name="jobSalary">
                        <label class="form-label" for="jobSalary">{{__('Job Salaray (optional)')}}</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="date" id="endOfApllication" class="form-control" name="endOfApllication" required>
                        <label class="form-label" for="endOfApllication">{{__('Job End Of Application')}}</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="file" id="pdf_description" class="form-control" name="pdf_description">
                        <label class="form-label" for="pdf_description">{{__('Attach PDF For Job Disc (optional)')}}</label>
                    </div>
                    <!-- Submit button -->
                    <input type="submit" class="form-control text-white mb-4" value="Post" style="background-color: #006F8b">
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

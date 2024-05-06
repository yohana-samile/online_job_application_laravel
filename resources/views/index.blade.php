<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
           background-color: #fbfbfb;
        }
        .primaryColor {
            background-color: #006F8b;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark primaryColor p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Online Job Application</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class=" collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item">
                        <a class="nav-link mx-2 active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="#job_announced">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="#">Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="#">Contact</a>
                    </li>
                </ul>
                <a class="btn btn-light text-dark" href="{{ url('login') }}">Log In</a>
            </div>
        </div>
    </nav>

    {{-- jobs --}}
    @php
        use Illuminate\Support\Facades\DB;
        $jobs = DB::select("SELECT * from jobs where status = 'unclosed' ");
        $today_date = \Carbon\Carbon::now()->format('Y-m-d');
    @endphp
    <div class="container">
        <div class="row">
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
                                <a href="{{ url('login') }}" class="btn btn-light float-right">Login Apply </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
{{-- footer --}}

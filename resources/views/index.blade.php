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
            @if (empty($jobs))
                <p class="alert alert-danger my-4">No Job Posted At The Moment, Visit This Page Onother time</p>
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
                                <a href="{{ url('login') }}" class="btn btn-light float-right">Login Apply </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
{{-- footer --}}
<footer class="text-center text-lg-start text-white text-muted primaryColor">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom primaryColor text-white">
        <!-- Left -->
        <div class="me-5 d-none d-lg-block">
            <span>Get connected with us on social networks:</span>
        </div>

        <div>
            <a href="https://github.com/yohana-samile" class="text-decoration-none me-4 text-reset">
                <i class="fa fa-facebook-f"></i>
            </a>
            <a href="https://github.com/yohana-samile" class="text-decoration-none me-4 text-reset">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="https://github.com/yohana-samile" class="text-decoration-none me-4 text-reset">
                <i class="fa fa-google"></i>
            </a>
            <a href="https://github.com/yohana-samile" class="me-4 text-reset">
                <i class="fa fa-instagram"></i>
            </a>
            <a href="https://github.com/yohana-samile" class="me-4 text-reset">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>
    </section>

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5 text-white">
            <div class="row mt-3">
                <div class="col-md-6 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                    <i class="fa fa-grass me-3"></i>Online Job Application
                    </h6>
                    <p>
                    Fulfil your dream by getting dream job with us, enjoy our service to reach your dream.
                    </p>
                </div>

                <div class="col-md-6 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4"> Useful links </h6>
                    <p>
                        <a href="#!" class="text-reset">Jobs</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Announcements</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">About Us</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Contact Us</a>
                    </p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="fa fa-home me-3"></i> P.o.box 1 Mzumbe</p>
                    <p>
                    <i class="fa fa-envelope me-3"></i>
                    yohanasamile@gmail.com
                    </p>
                    <p><i class="fa fa-phone me-3"></i> + 255 620 350 083</p>
                    <p><i class="fa fa-print me-3"></i> + 255 745 668 527</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Links  -->

    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2024 Copyright:
    <a class="text-reset fw-bold" href="https://github.com/yohana-samile">Online Job Application</a>
    </div>
</footer>

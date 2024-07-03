<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Online Job Application') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <style>
        .btn, .bg, .primaryColor{
            background-color: #006F8b;
        }
        #btn, #sidebar{
            background-color: #006F8b;
        }
    </style>
</head>
<body>
    @php
        use Illuminate\Support\Facades\DB;
        $userId = Auth::user()->id;
        $userRole = DB::select("SELECT roles.name as role_name, users.id from roles, users where users.role_id = roles.id and users.id = '$userId' ");
        $userRole = $userRole[0];
    @endphp
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar" class="active">
            <p> <a href="{{url('home')}}" class="logo">Online Job</a></p>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="{{url('home')}}"><span class="fa fa-home"></span> Home</a>
                </li>
                @if ($userRole->role_name === 'is_applicant')
                    <li>
                        <a class="nav-link" href="{{ url('my_application')}}"><span class="fa fa-database"></span> My Application</i></a>
                    </li>
                @else
                    <li>
                        <a href="{{ url('users/applicant') }}"><span class="fa fa-user"></span> Applicant</a>
                    </li>
                    <li>
                        <a href="{{ url('jobApplication')}}"><span class="fa fa-envelope"></span> Application</a>
                    </li>
                    <li>
                        <a href="{{ url('jobPosted') }}"><span class="fa fa-database"></span> Jobs</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('home')}}"><span class="fa fa-database"></span> Post New Job</i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="javascript::void(0)"><span class="fa fa-phone"></span>About Us</i></a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('companies')}}"><span class="fa fa-user"></span>Companies</i></a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span>{{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>

            <div class="footer">
                <p> &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved. <br> Online Job Application </p>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light">
                        <i class="fa fa-bars text-white"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button> <p> Welcome Dear <b>{{ Auth::user()->name }}</b>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto" hidden>
                            <li class="nav-item">
                                <a class="nav-link" href="" data-toggle="modal" data-darget="#feedAboutUs"><i class="fa-fa-pencil-square-ot">Feed About Us</i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" data-toggle="modal" data-darget="#feedContactUs"><i class="fa-fa-pencil-square-ot">Feed Contact Us </i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="app">
                <main class="">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</body>
</html>

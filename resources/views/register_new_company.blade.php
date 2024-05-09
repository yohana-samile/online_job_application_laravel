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
                <form method="POST" action="{{ route('store_company') }}">
                    @csrf
                    <div data-mdb-input-init class="form-outline">
                        <input type="text" id="name" name="name" class="form-control" />
                        <input type="hidden" value="2" id="role_id" name="role_id" class="form-control" />
                        <label class="form-label" for="name">{{__('Enter Company Name')}}</label>
                    </div>
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="email" class="form-control"  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <label class="form-label" for="email">{{__('Email address')}}</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <label class="form-label" for="form3Example4">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <label for="password-confirm" class="text-md-end">{{ __('Confirm Password') }}</label>
                    </div>
                    <!-- Submit button -->
                    <input type="submit" class="form-control text-white mb-4" value="Post" style="background-color: #006F8b">
                </form>
            </div>
        </div>
    </div>
@endsection

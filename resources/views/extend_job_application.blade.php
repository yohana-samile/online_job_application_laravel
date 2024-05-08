@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card bg-glass">
            <div class="card-body">
                @if ($job_id->status == 'extended')
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
                    <a href="{{ url('jobPosted') }}" class="primaryColor btn-sm text-white"><i class="fa fa-home"></i> Back To Job Posted</i></a>
                @else
                    <form method="POST" action="{{ route('store_extended_job_application') }}">
                        @csrf
                        <div data-mdb-input-init class="form-outline">
                            <input type="hidden" id="id" name="id" value="{{$job_id->id}}" class="form-control" />
                            <input type="date" id="endOfApllication" name="endOfApllication" class="form-control" />
                            <label for="endOfApllication">Enter Date To End Application</label>
                        </div>
                        <div data-mdb-input-init class="form-outline my-4">
                            <input type="submit" name="submit" value="Extend Application" class="text-white form-control primaryColor">
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

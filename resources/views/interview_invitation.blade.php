@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card bg-glass">
            <div class="card-body">
                @if ($application_id->status == 'accepted')
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
                    <a href="{{ url('jobApplication') }}" class="primaryColor btn-sm text-white"><i class="fa fa-home"></i> Back To Application</i></a>
                @else
                    <form method="POST" action="{{ route('store_interview_date') }}">
                        @csrf
                        <div data-mdb-input-init class="form-outline">
                            <input type="hidden" id="id" name="id" value="{{$application_id->id}}" class="form-control" />
                            <input type="hidden" id="status" name="status" value="accepted" class="form-control" />
                            <input type="date" id="interview_date" name="interview_date" class="form-control" />
                            <label for="interview_date">Enter Date For Interview</label>
                        </div>
                        <div data-mdb-input-init class="form-outline my-4">
                            <input type="submit" name="submit" value="Send Invitation" class="text-white form-control primaryColor">
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

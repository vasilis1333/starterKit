@extends('layouts.master')

@section('title') @lang('translation.Create_New') @endsection

@section('css')
    <!-- bootstrap datepicker -->
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- dropzone css -->
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Users @endslot
        @slot('title') Update @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Update {{$user->name}}</h4>
                    <form method="post" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <label for="username" class="col-form-label col-lg-2">Username</label>
                            <div class="col-lg-6">

                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name',$user->name) }}" id="username" name="name" autofocus required
                                       placeholder="Enter username">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="user_email" class="col-form-label col-lg-2">Email</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail"
                                       value="{{ old('email',$user->email) }}" name="email"  autofocus required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="password" class="col-form-label col-lg-2">Password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" name="password"
                                       placeholder="Enter password" autofocus >
                                @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="confirm-password" class="col-form-label col-lg-2">Confirm Password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="confirmpassword"
                                       name="password_confirmation" placeholder="Enter Confirm password" autofocus >
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Birth Date</label>
                            <div class="col-lg-6">
                                <div class="input-group" id="datepicker1">
                                    <input type="text" class="form-control @error('dob') is-invalid @enderror" placeholder="dd-mm-yyyy"
                                           data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' data-date-end-date="0d" value="{{ old('dob',$user->dob) }}"
                                           data-provide="datepicker" name="dob" autofocus required>
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

{{--                        <div class="row mb-4">--}}
{{--                            <label for="projectbudget" class="col-form-label col-lg-2">Budget</label>--}}
{{--                            <div class="col-lg-10">--}}
{{--                                <input id="projectbudget" name="projectbudget" type="text"--}}
{{--                                       placeholder="Enter Project Budget..." class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Profile Photo</label>
                            <div class="col-lg-1">
                                <div>
                                    <img class="rounded-circle avatar-md" src="{{asset($user->avatar)}}"
                                         alt="'.$row->name.'">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="inputGroupFile02" name="avatar" autofocus >
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="{{url()->previous()}}" class="btn btn-primary">Cancel</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- dropzone plugin -->
    <script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
@endsection

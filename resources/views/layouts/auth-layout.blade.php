@extends('layouts.main')
@section('layout')
    <div class="row shadow-sm px-4 py-3">
        <div class="col-6 col-lg-2 d-flex align-items-center">
            <a class="m-0 h2 text-decoration-none text-black" href="{{ route('frontend.dashboard') }}">Shortlinker</a>
        </div>
        <div class="col-1 col-lg-8 d-flex align-items-center">
            <a class="m-0 h6 text-decoration-none text-black d-none d-lg-block nav-link" href="{{ route('frontend.dashboard') }}">Dashboard</a>
        </div>
        <div class="col-5 col-lg-2 d-flex gap-2 justify-content-end align-items-center position-relative">
            <button type="button" class="border-0 btn p-0" data-bs-toggle="collapse" href="#userdropdown">
                Hi, {{ auth()->user()->name }}!
            </button>
            <div class="position-absolute top-100 collapse" id="userdropdown">
                <div class="card card-body p-0">
                    <a class="text-black text-decoration-none border border-bottom-1 border-start-0 border-top-0 border-end-0 py-1 px-2 d-lg-none"
                        href="{{ route('frontend.dashboard') }}">Dashboard</a>
                    <a class="text-danger text-decoration-none py-1 px-2" href="{{ route('frontend.logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
@endsection

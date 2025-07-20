@extends('layouts.main')
@section('layout')
    <div class="row shadow-sm px-4 py-3">
        <div class="col-6 col-lg-2 d-flex align-items-center">
             <a class="m-0 h2 text-decoration-none text-black" href="{{ route('frontend.login') }}">Shortlinker</a>
        </div>
        <div class="col-1 col-lg-8"></div>
        <div class="col-5 col-lg-2 d-flex d-lg-none gap-2 justify-content-end align-items-center position-relative">
            <button type="button" class="border-0 btn p-0" data-bs-toggle="collapse" href="#guestdropdown">
                <svg viewBox="0 0 24 24" width="35" height="35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M4 18L20 18" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                        <path d="M4 12L20 12" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                        <path d="M4 6L20 6" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                    </g>
                </svg>
            </button>
            <div class="position-absolute top-100 collapse" id="guestdropdown">
                <div class="card card-body p-0">
                    <a class="text-black text-decoration-none border border-bottom-1 border-start-0 border-top-0 border-end-0 py-1 px-2"
                        href="{{ route('frontend.login') }}">Login</a>
                    <a class="text-black text-decoration-none border border-bottom-1 border-start-0 border-top-0 border-end-0 py-1 px-2"
                        href="{{ route('frontend.register') }}">Register</a>
                </div>
            </div>
        </div>
        <div class="col-5 col-lg-2 d-none d-lg-flex gap-2 justify-content-between align-items-center">
            <a href="{{ route('frontend.view-login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('frontend.view-register') }}" class="btn btn-secondary">Register</a>
        </div>
    </div>
    @yield('content')
@endsection

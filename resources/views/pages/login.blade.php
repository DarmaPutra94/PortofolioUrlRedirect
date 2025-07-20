@extends('layouts.guest-layout')
@section('content')
    <div class="row px-4 py-3">
        <div class="col-0 col-lg-4"></div>
        <form action="{{ route('frontend.login') }}" method="POST" class="col-12 col-lg-4">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="youremail@address..."
                    autocomplete="email">
                <x-input-error :messages="$errors->get('email')"></x-input-error>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <x-input-password id='password'></x-input-password>
                <x-input-error :messages="$errors->get('password')"></x-input-error>
                <small>Forget your password? <a href="{{ route('frontend.view-request-reset-password') }}">Request reset link</a></small>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
@endsection

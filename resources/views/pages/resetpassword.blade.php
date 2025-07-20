@extends('layouts.guest-layout')
@section('content')
    <div class="row px-4 py-3">
        <div class="col-0 col-lg-4"></div>
        <form action="{{ route('frontend.reset-password', ['token' => $token, 'user_id' => $user_id]) }}" method="POST"
            class="col-12 col-lg-4">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <x-input-password id='password'></x-input-password>
                <x-input-error :messages="$errors->get('password')"></x-input-error>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <x-input-password id='password_confirmation'></x-input-password>
                <x-input-error :messages="$errors->get('password_confirmation')"></x-input-error>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>
@endsection

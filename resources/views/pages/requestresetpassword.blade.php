@extends('layouts.guest-layout')
@section('content')
    <div class="row px-4 py-3">
        <div class="col-0 col-lg-4"></div>
        <form action="{{ route('frontend.request-reset-password') }}" method="POST" class="col-12 col-lg-4">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="youremail@address..."
                    autocomplete="email">
                <x-input-error :messages="$errors->get('email')"></x-input-error>
            </div>
            <button type="submit" class="btn btn-primary w-100">Request Reset Password</button>
        </form>
    </div>
@endsection

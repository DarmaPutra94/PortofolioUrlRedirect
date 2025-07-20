@extends('layouts.auth-layout')
@section('content')
    <div class="row px-4 py-3">
        <div class="col-0 col-lg-4"></div>
        <form action="{{ route('frontend.store') }}" method="POST" class="col-12 col-lg-4">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="url">Url</label>
                <input id="url" type="text" class="form-control" name="url" placeholder="yoururl..."
                    autocomplete="url">
                <x-input-error :messages="$errors->get('url')"></x-input-error>
            </div>
            @session('shortUrl')
                <div class="mb-3">
                    <label class="form-label" for="shorturl">Short Url</label>
                    <a tabindex="0" data-bs-trigger="focus" data-bs-container="body" data-bs-toggle="popover"
                        data-bs-content="Link copied!">
                        <input id="shorturl" type="text" class="form-control" name="shorturl" value="{{ $value }}"
                            readonly>
                    </a>
                </div>
            @endsession
            <button type="submit" class="btn btn-primary w-100">Shortify</button>
        </form>
    </div>
@endsection
@session('shortUrl')
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("shorturl").addEventListener('click', function(event) {
                    navigator.clipboard.writeText(event.currentTarget.value);
                })
                const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
                const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(
                    popoverTriggerEl))
                const popover = new bootstrap.Popover('.popover-dismiss', {
                    trigger: 'focus'
                })
            });
        </script>
    @endpush
@endsession

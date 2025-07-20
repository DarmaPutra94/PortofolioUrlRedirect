@props(['message', 'mode'])
<div class="{{ $mode == 'success' ? 'alert-success' : 'alert-danger' }} alert d-flex align-items-center alert-message w-75 position-fixed bottom-0 end-15px w-lg-25"
    role="alert">
    <svg width="25px" height="25px" class="bi flex-shrink-0 me-2" role="img"
        aria-label="{{ $mode == 'success' ? 'Success:' : 'Danger:' }}">
        <use xlink:href="{{ $mode == 'success' ? '#check-circle-fill' : '#exclamation-triangle-fill' }}" />
    </svg>
    <div>
        {{ $message }}
    </div>
</div>

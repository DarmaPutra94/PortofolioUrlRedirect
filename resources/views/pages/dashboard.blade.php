@extends('layouts.auth-layout')
@section('content')
    <div class="row px-4 py-3 justify-content-center" x-data="shorturllist">
        <div class="col-12 col-lg-10 shadow rounded px-3 py-2 mb-4 mb-lg-0">
            <div class="d-flex flex-column flex-lg-row gap-0 gap-lg-3 justify-content-between w-100">
                <form class="d-flex flex-column flex-lg-row" action="{{ route('frontend.dashboard') }}" method="GET">
                    <input class="form-control my-2 w-100 me-2 w-lg-25" value="{{ request()->get('short_url') }}"
                        name="short_url" type="text" id="short_url" placeholder="shortlink..." style="min-width: 250px">
                    <button class="btn btn-primary my-2" type="submit">Search</button>
                </form>
                <a href="{{ route('frontend.create') }}" class="btn btn-primary my-2 text-decoration-none">+ New Link</a>
            </div>
            <div class="overflow-auto d-none d-lg-block">
                <table class="table" style="min-width: max-content">
                    <thead>
                        <tr>
                            <th scope="col" style="width:5%">#</th>
                            <th scope="col" style="width:50%">Link</th>
                            <th scope="col" style="width:20%">Short Link</th>
                            <th scope="col" style="width:10%">Clicks</th>
                            <th scope="col" style="width:15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="short_url_list.length === 0">
                            <td colspan="5">
                                <p class="m-0 text-center fw-bold">No shortlink is found.</p>
                            </td>
                        </template>
                        <template x-for="(short_url, index) in short_url_list">
                            <tr x-data="{ edit_mode: false }">
                                <th scope="row" x-text="index+1"></th>
                                <td>
                                    <p class="text-break" x-show="!edit_mode" class="m-0" x-text="short_url.url"></p>
                                    <input x-cloak x-show="edit_mode" type="text" class="form-control"
                                        x-model="short_url.url">
                                </td>
                                <td x-text="short_url.short_code"></td>
                                <td x-text="short_url.access_count"></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button x-show="!edit_mode" x-on:click="edit_mode = true" class="btn btn-primary"
                                            type="button">
                                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </path>
                                                    <path
                                                        d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </path>
                                                </g>
                                            </svg>
                                        </button>
                                        <button x-cloak x-show="edit_mode"
                                            x-on:click="async ()=>{
                                            await update_short_url(short_url);
                                            edit_mode=false;
                                        }"
                                            class="btn btn-primary" type="button">
                                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z"
                                                        fill="currentColor"></path>
                                                </g>
                                            </svg>
                                        </button>
                                        <button class="btn btn-danger" type="button"
                                            x-on:click="async ()=>show_delete_modal(short_url)">
                                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M3 3L21 21M18 6L17.6 12M17.2498 17.2527L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6H4M16 6L15.4559 4.36754C15.1837 3.55086 14.4194 3 13.5585 3H10.4416C9.94243 3 9.47576 3.18519 9.11865 3.5M11.6133 6H20M14 14V17M10 10V17"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="d-none d-lg-block">
                {{ $shortUrls->links() }}
            </div>
        </div>
        <template x-if="short_url_list.length === 0">
             <div class="d-lg-none shadow rounded px-3 py-2 mb-3">
                <p class="m-0 text-center fw-bold">No shortlink is found.</p>
             </div>
        </template>
        <template x-for="(short_url, index) in short_url_list">
            <div class="d-lg-none shadow rounded px-3 py-2 mb-3" x-data="{ edit_mode: false }">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="m-0 fw-bold w-50">#</h6>
                    <h6 class="m-0 w-50" x-text="index+1"></h6>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="m-0 fw-bold w-50">Link</h6>
                    <h6 class="text-break m-0 w-50" x-show="!edit_mode" class="m-0" x-text="short_url.url"></h6>
                    <textarea rows="4" x-cloak x-show="edit_mode" class="form-control w-50" x-model="short_url.url"></textarea>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="m-0 fw-bold w-50">Short Link</h6>
                    <h6 class="text-break m-0 w-50" class="m-0" x-text="short_url.short_code"></h6>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="m-0 fw-bold w-50">Access Count</h6>
                    <h6 class="text-break m-0 w-50" class="m-0" x-text="short_url.access_count"></h6>
                </div>
                <button x-show="!edit_mode" x-on:click="edit_mode = true" class="btn btn-primary mb-2 w-100"
                    type="button">
                    EDIT
                </button>
                <button x-cloak x-show="edit_mode"
                    x-on:click="async ()=>{
                                            await update_short_url(short_url);
                                            edit_mode=false;
                                        }"
                    class="btn btn-primary mb-2 w-100" type="button">
                    SAVE
                </button>
                <button class="btn btn-danger w-100" type="button" x-on:click="async ()=>show_delete_modal(short_url)">
                    DELETE
                </button>
            </div>
        </template>
        <div class="d-lg-none mt-3">
            {{ $shortUrls->links() }}
        </div>
        <div x-cloak x-show="success.show">
            <div class="alert alert-success d-flex align-items-center w-75 w-lg-25 position-fixed bottom-0 end-15px"
                role="alert">
                <svg width="25px" height="25px" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div x-text="success.message"></div>
            </div>
        </div>
        <div x-cloak x-show="error.show">
            <div class="alert alert-danger d-flex align-items-center w-75 w-lg-25 position-fixed bottom-0 end-15px"
                role="alert">
                <svg width="25px" height="25px" class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div x-text="error.message"></div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Are you sure you want to delete <span x-text="deleted_shortcode">?</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            x-on:click="deleted_shortcode = null"></button>
                    </div>
                    <div class="modal-body">
                        <p>This action cannot be redone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            x-on:click="deleted_shortcode = null">No</button>
                        <button type="button" class="btn btn-danger"
                            x-on:click="async ()=> delete_short_url()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('alpine:init', function() {
            const delete_modal = new bootstrap.Modal(document.getElementById(
                'delete-modal'));
            Alpine.data('shorturllist', () => ({
                short_url_list: @js($shortUrls->items()),
                success: {
                    show: false,
                    message: ''
                },
                error: {
                    show: false,
                    message: ''
                },
                deleted_shortcode: null,
                async show_delete_modal(short_url) {

                    this.deleted_shortcode = short_url.short_code;
                    delete_modal.show()
                },
                async delete_short_url() {
                    try {
                        const response = await fetch('{{ url('/') }}/' + this
                            .deleted_shortcode, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },

                            });
                        if (response.ok) {
                            this.short_url_list = this.short_url_list.filter((short_url) =>
                                short_url.short_code !== this.deleted_shortcode)
                            this.success.show = true;
                            this.success.message = "Success updating shortlink " + this
                                .deleted_shortcode
                        } else {
                            throw new Error('Failed updating shortlink ' + this.deleted_shortcode)
                        }
                    } catch (e) {
                        this.error.show = true;
                        this.error.message = e;
                    } finally {
                        this.deleted_shortcode = null;
                        delete_modal.hide()
                        setTimeout(() => {
                            this.success.show = false;
                            this.success.message = '';
                            this.error.show = false;
                            this.error.message = '';
                        }, 2000);
                    }
                },
                async update_short_url(short_url) {
                    try {
                        const response = await fetch('{{ url('/') }}/' + short_url
                            .short_code, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    url: short_url.url
                                })
                            });
                        if (response.ok) {
                            this.success.show = true;
                            this.success.message = "Success updating shortlink " + short_url
                                .short_code
                        } else {
                            throw new Error('Failed updating shortlink ' + short_url.short_code)
                        }
                    } catch (e) {
                        this.error.show = true;
                        this.error.message = e;
                    } finally {
                        setTimeout(() => {
                            this.success.show = false;
                            this.success.message = '';
                            this.error.show = false;
                            this.error.message = '';
                        }, 2000);
                    }
                }
            }));
        })
    </script>
@endpush

@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0 justify-content-center">
        <div class="col-xl-9">
            <div class="auth-full-page-content d-flex p-sm-5 p-4">
                <div class="w-100">
                    <div class="d-flex flex-column h-100">
                        <div class="mb-4 mb-md-5 text-center">
                            <a href="/" class="d-block auth-logo">
                                <img src="{{ asset('assets/images/logo-sm.svg') }}" alt="" height="28"> <span class="logo-txt">Olian</span>
                            </a>
                        </div>
                        <div class="auth-content my-auto">
                            <div class="text-center">
                                <h5 class="mb-0">{{ __('Verify Your Email Address') }}</h5>
                                <p class="text-muted mt-2">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                            </div>

                            @if (session('resent'))
                                <div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <form class="custom-form mt-4" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">{{ __('Resend Verification Email') }}</button>
                                </div>
                            </form>

                            <div class="mt-5 text-center">
                                <p class="text-muted mb-0">{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="text-primary fw-semibold"> {{ __('click here to request another') }}</a></p>
                            </div>
                        </div>
                        <div class="mt-4 mt-md-5 text-center">
                            <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Olian. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<div class="sidebar">
    <!-- Start Logobar -->
    <div class="logobar">
        <a href="{{route('admin.dashboard')}}" class="logo logo-large"><img src="{{asset('assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
        <a href="{{route('admin.dashboard')}}" class="logo logo-small"><img src="{{asset('assets/images/small_logo.svg')}}" class="img-fluid" alt="logo"></a>
    </div>
    <!-- End Logobar -->
    <!-- Start Navigationbar -->
    <div class="navigationbar">
        @if (auth()->user()->role == 'admin')
            @include('layouts.aside.admin')
        @elseif (auth()->user()->role == 'agent')
            @include('layouts.aside.agent')
        @elseif (auth()->user()->role == 'client')
            @include('layouts.aside.client')
        @endif
    </div>
    <!-- End Navigationbar -->
</div>
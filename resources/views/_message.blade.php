@if (!empty(session('success')))
    <div class="alert alert-success mb-3 alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn btn-close"  data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('error')))
    <div class="alert alert-danger mb-3 alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('payment-error')))
    <div class="alert alert-error mb-3 alert-dismissible fade show" role="alert">
        {{ session('payment-error') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('warning')))
    <div class="alert alert-warning mb-3 alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('info')))
        <div class="alert alert-info mb-3 alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('secondary')))
    <div class="alert alert-secondary mb-3  alert-dismissible fade show" role="alert">
        {{ session('secondary') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('primary')))
        <div class="alert alert-primary mb-3  alert-dismissible fade show" role="alert">
        {{ session('primary') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

@if (!empty(session('light')))
    <div class="alert alert-light mb-3  alert-dismissible fade show" role="alert">
        {{ session('light') }}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'"><i class="ri-close-fill"></i></button>
    </div>
@endif

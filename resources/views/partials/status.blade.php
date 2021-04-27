@if (session('success'))
    <div class="alert alert-success fade show" role="alert" id="alert" data-dismiss="alert">
        <span class="alert-icon">
            <i class="fas fa-check-circle fa-lg fa-fw" aria-hidden="true"></i>
        </span>
        <h5 class="d-inline"><strong>Success!</strong></h5><hr>
        {{ session('success') }}
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning fade show" role="alert" id="alert" data-dismiss="alert">
        <span class="alert-icon">
            <i class="fas fa-check-circle fa-lg fa-fw" aria-hidden="true"></i>
        </span>
        <h5 class="d-inline"><strong>Warning!</strong></h5><hr>
        {{ session('warning') }}
    </div>
@endif

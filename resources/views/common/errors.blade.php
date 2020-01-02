@if(session()->has('success'))
<div class="alert alert-success fade show" role="alert">
    <h6 class="alert-heading">Well done!</h6>
    <hr>
    <p class="mb-0">{{ session('success') }}</p>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger fade show" role="alert">
    <h6 class="alert-heading">Whoops! There were errors!</h6>
    <hr>
    <p class="mb-0">{{ session('error') }}</p>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger fade show" role="alert">
    <h6 class="alert-heading">Whoops! There were errors!</h6>
    <hr>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
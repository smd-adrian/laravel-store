@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div> 
@endif
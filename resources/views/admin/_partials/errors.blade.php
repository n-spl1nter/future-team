@if($errors->any() || session('error'))
    <div class="alert-danger alert">
        <ul>
            @if(session('error'))
            <li>{{ session('error') }}</li>
            @endif
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div style="padding-top: 40px;">
        <div class="alert alert-success">{{ session('success') }}</div>
    </div>
@endif

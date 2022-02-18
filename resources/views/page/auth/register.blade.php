@extends('layouts.auth.main')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>TODO</b>-LIST</a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger p-3 mb-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li class="lead"><span class="text-sm">{{ $error }}</span></li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full name" name="name" value="{{ old('name') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-8">
                        <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
@endsection

@push('js-auth')

    <script>

        
        $(document).ready(function(){
            let register_success = "{{ session('register_success') }}"
            if(register_success){
                alert(register_success);
                $(location).prop('href', "{{ route('login') }}")
            }
        })
    </script>

@endpush
@extends('layouts.base')
@section('title','EN DIARY login')
@section('main')
    

<body>
    @if(Auth::check())
        {{ View('home.home') }}
    @endif

<div class="register">
    <h2>--- ログイン ---</h2>

    <div class="register-form">
        <form action="{{ url('/login/after') }}" method="post">
            <p><label for="email">E-mail</label></p>
            <p><input class="register-form01" type="email" id="email" name="email" value="{{ old('email') }}"></p>
            <div class="register-errmsg">
                @if(count($errors) > 0)
                    <ul>
                        @foreach($errors->get('email') as $err)  
                        <li class="text-danger">※{{ $err }}</li>
                        @endforeach
                    </ul>
                    @endif
            </div>
            
            <label for="password">Password</label>
            <p><input class="register-form01" type="password" id="password" name="password" value="{{ old('password') }}"></p>
            <div class="register-errmsg">
                @if(count($errors) > 0)
                    <ul>
                        @foreach($errors->get('password') as $err)  
                        <li class="text-danger">※{{ $err }}</li>
                        @endforeach
                    </ul>
                    @endif
            </div>
            <p><input class="submit-btn" type="submit" value="Login"></p>
            {{ csrf_field() }}
        </form>

    </div>


</div>
</body>
@endsection
@extends('layouts.base')
@section('title','EN DIARY register')
@section('main')
    

<body>
<div class="register">
    <h2>--- 新規登録 ---</h2>
    
    <form action="{{ route('after_register') }}" method="POST" class="register-form" enctype="multipart/form-data">
        @csrf

        <label for="InputName">Nickname</label><br>
        <input class="register-form01" type="text" name="name" value="{{ old('name') }}"><br>
        <div class="register-errmsg">
        @if(count($errors) > 0)
            <ul>
                @foreach($errors->get('name') as $err)  
                <li class="text-danger">※{{ $err }}</li>
                @endforeach
            </ul>
            @endif
        </div>

        <label >E-mail</label><br>
        <input class="register-form01" type="email" name="email" value="{{ old('email') }}"><br>
        <div class="register-errmsg">
        @if(count($errors) > 0)
            <ul>
                @foreach($errors->get('email') as $err)  
                <li class="text-danger">※{{ $err }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    
        <label for="InputPassword">Password</label><br>
        <input class="register-form01" type="password" name="password" value="{{ old('password') }}"><br>
        <div class="register-errmsg">
        @if(count($errors) > 0)
            <ul>
                @foreach($errors->get('password') as $err)  
                <li class="text-danger">※{{ $err }}</li>
                @endforeach
            </ul>
            @endif
        </div>

        <label for="InputImage">Profile image  ※任意</label><br>
        <input type="file" class="register-form02" name="image_file">
        <hr>

        <p><input class="submit-btn" type="submit" value="register"></p>

    </form>
</div>
</body>
@endsection
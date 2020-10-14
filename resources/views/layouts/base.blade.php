<!DOCTYPE html>
<html lang="“ja”">
  <head>
    <meta http-equiv="content-language" content="ja" />
    <meta name="robots" content="noindex,nofollow" />
    <meta charset="UTF-8" />
    <!-- view port -->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
        
    <title>@yield('title')</title>
    <style type="text/css">
    </style>

    <!--style-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}" />

    <!--fontawesome-->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <!-- CSS only bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />

   {{-- jquery.min.js --}}
   <script src="{{asset('/js/jquery.min.js')}}"></script>   
   {{-- jquery.validate.min.js --}}
   <script src="{{asset('/js/jquery.validate.min.js')}}"></script>   
   {{-- jquery infinitescroll --}}
   <script src="/js/jquery.infinitescroll.min.js"></script>
   {{-- Java Script --}}
   <script src="{{asset('/js/scripts.js')}}"></script>


  </head>
<body>
    <header>
    <div class="header">
        @if(Request::is('after_register'))
        <div class="header-left">
          <a href="/"><i class="fas fa-book-open"></i> En Diary</a>
        </div>
        
        <div class="header-right">
        </div>
  
        @else
        @if(Auth::check())
        <div class="header-left">
          <a href="{{ asset('/posts') }}"><i class="fas fa-book-open"></i> En Diary</a>
        </div>

        <div class="header-right">
            <p class="header-right-txt">Welcome, <span>{{ Auth::user()->name }}</span> |</p>
            <a href="{{ asset('/logout') }}" id="logout" >LOGOUT</a>
        </div>
        @else

        <div class="header-left">
          <a href="/"><i class="fas fa-book-open"></i> En Diary</a>
        </div>

        <div class="header-right">
          <div class="header-right01">
            <a href="{{ asset('/register') }}">新規登録</a>
          </div>          
          <div class="header-right02">
            <a href="{{ asset('/login') }}">ログイン</a>
          </div>          
        </div>

        @endif
        @endif
    </div>

  </header>

    {{-- main contents --}}
    @section('main')
    @show

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <base href="/gfcare/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>DIGIAFYA: mHealth Suite</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    
    <!-- Fonts -->
    <link href="{{ asset('css/font-awesome.min.css') }}"  rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/google-fonts.css') }}" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset(elixir('css/app.css')) }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">


    <!-- Spark Globals -->
    @include('scripts.globals')

    <!-- Injected Scripts -->
    @yield('scripts', '')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="spark-layout">
<!-- Vue App For Spark Screens -->
<div id="spark-app" v-cloak>   
    <!-- Navigation -->
    @if (Auth::check())
    @include('nav.authenticated')
    @else
    @include('nav.guest')
    @endif

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('common.footer')

    <!-- JavaScript Application -->
    <script src="{{ asset(elixir('js/app.js')) }}"></script>
</div>
</body>
</html>

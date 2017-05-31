<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    <title>GF+Care: mHealth Suite</title>

    <!-- Fonts -->
    <link href="{{ asset('css/font-awesome.min.css') }}"  rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/google-fonts.css') }}" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset(elixir('css/app.css')) }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Main Content -->
<div class="container spark-splash-screen">
    <!-- Branding / Navigation -->
    <div class="row splash-nav">
        <div class="col-md-10 col-md-offset-1">
            <div class="pull-left splash-brand">

                <i class="fa fa-btn fa-medkit"></i>DIGIAFYA

            </div>

            <div class="navbar-header">
                <button type="button" class="splash-nav-toggle navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#primary-nav" aria-expanded="false" aria-controls="primary-nav">
                    <span class="sr-only">Toggle navigation</span>
                    MENU
                </button>
            </div>

            <div id="primary-nav" class="navbar-collapse collapse splash-nav-list">
                <ul class="nav navbar-nav navbar-right inline-list">
                    <!--
                        <li class="splash-nav-link active"><a href="/features">Features</a></li>
                        <li class="splash-nav-link"><a href="/support">Support</a></li>
                    -->
                    @if(Auth::guest())
                        <li class="splash-nav-link splash-nav-link-highlight-border"><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="splash-nav-link splash-nav-link-highlight-border"><a href="{{ url('/home') }}">Dashboard</a></li>
                    @endif
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <!-- Inspiration -->
    <div class="row splash-inspiration-row">
        <div class="col-md-12 col-md-offset-1">
            <div id="splash-inspiration-heading">
                Increasing your Impact.
            </div>

            <div id="splash-inspiration-text">
                DigiAfya provides the perfect starting point for integrating mHealth into your programs.
            </div>
            
            <!-- Call To Action Button -->
            <div style="margin-top: 20px; margin-bottom: 40px;">
                    <a href="{{ url('/login') }}">
                        <button class="btn btn-primary btn-sm splash-get-started-btn">
                            Get Started!
                        </button>
                    </a>
            </div>
        </div>        
    </div>

    <!-- Footer -->
    <div class="row">
            <!-- Company Information -->
            <div class="col-md-10 col-md-offset-1 splash-footer">
                <div class="pull-left splash-footer-company">
                    Copyright © {{ Spark::company() }} - <a href="{{ url('terms') }}">Terms Of Service</a>
                </div>

                <!-- Social Icons -->
                <div class="pull-right splash-footer-social-icons">
                    <!--
                    <a href="http://facebook.com">
                        <i class="fa fa-btn fa-facebook-square"></i>
                    </a>
                    <a href="http://twitter.com">
                        <i class="fa fa-btn fa-twitter-square"></i>
                    </a>
                    -->
                    <a href="http://github.com">
                        <i class="fa fa-github-square"></i>
                    </a>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
</div>

<!-- Footer Scripts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap2-toggle.min.js') }}"></script>

</body>
</html>

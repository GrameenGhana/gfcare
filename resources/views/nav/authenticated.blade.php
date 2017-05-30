<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#spark-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
<<<<<<< HEAD
               <i class="fa fa-btn fa-medkit"></i> DIGIAFYA
=======
               <i class="fa fa-btn fa-medkit"></i> GF+Care 
>>>>>>> 7221f69a66e4223a16ad6208730fbcfff74f742d
            </a>
        </div>

        <div class="collapse navbar-collapse" id="spark-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <spark-nav-bar-topbar inline-template>
                <ul class="nav navbar-nav" v-for="l in activeModulesList">
                    <li><a href="@{{l.link}}" class="@{{l.class}}">@{{ l.name }} </a></li>
                </ul>
            </spark-nav-bar-topbar>    

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @include('nav.settings')
            </ul>
        </div>
        <notifications></notifications>
    </div>
</nav>

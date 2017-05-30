@extends('layouts.app')

@section('content')

<!-- Main Content -->
<div class="container spark-screen">
    @if (Spark::usingTeams() && ! Auth::user()->hasTeams())

        <!-- Teams Are Enabled, But The User Doesn't Have One -->
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">You Need A Project!</div>

                    <div class="panel-body bg-warning">
                        It looks like you haven't created a project!
                        You can create one in your <a href="{{ url('/settings?tab=teams') }}">account settings</a>.
                    </div>
                </div>
            </div>
        </div>

    @else

        <!-- Teams Are Disabled Or User Is On Team -->
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
<<<<<<< HEAD
                        Your Dashboard.I am here
=======
                        Your Dashboard.
>>>>>>> 7221f69a66e4223a16ad6208730fbcfff74f742d
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
@endsection

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
      <!--  <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        Your Dashboard.
                    </div>
                </div>
            </div>
        </div>-->
<div class="row">
<div class="panel panel-default">
    <div class="panel-heading"> Introduction</div>
    <div class="panel-body">
        <div class="pull-left">
          <p style="text-align:justify">Digi Suite hosts programmes and apps that target mothers, nurses and community health workers.  This platform provides a versatile system that enables deployment and analysis of information to relevant stakeholders.  This combination of apps and programmes provides an avenue for using digital means to share for behaviour change communication messages and reach communities that may have otherwise been unreached.</p>
         <p><b>The application consists of four major modules which are described in detail below </b></p>
       </div>
    </div>
</div>
</div>
<div class="row">

<div class="col-md-3 panel panel-default">
    <div class="panel-heading">Digiafya</div>
    <div class="panel-body">
        <div class="pull-left">
          <p>This is a platform for scheduling and sending messages for pregnant and mothers of new borns.The system enables community health workers to register women to enable them receive messages that are linked to the specific week of pregnancy.After delivery mothers continue to receive messages for post-natal care.</p>
       </div>
    </div>
</div>

<div class="col-md-3 panel panel-default">
    <div class="panel-heading">Digimlezi</div>
    <div class="panel-body">
        <div class="pull-left">
          <p>Digimlezi is a mobile phone app.The app provides a platform for an easy to access decision support tool for patient diagnosis and care,a distance learning module to help nurses develop their capacity and a tool for enabling supervisors monitor nurses performance.This app supports nurses in the MCNH..</p>
       </div>
    </div>
</div>

<div class="col-md-3 panel panel-default">
    <div class="panel-heading">Digitunza</div>
    <div class="panel-body">
        <div class="pull-left">
           <p>Digitunza is an app that provides Community Health Volunteers with resources to use in reaching out to mothers in the pre-and post-natal period with critical MCHN messages.The app is used to disseminate information to various community members to improve health care.</p>
       </div>
    </div>
</div>

<div class="col-md-3 panel panel-default">
    <div class="panel-heading">DigiKijana</div>
    <div class="panel-body">
        <div class="pull-left">
            <p>Digikijana app provides the youth with a platform to access sexual and reproductive health messages directly on their phones.  The application runs on simple smart phones.This application enables the youth to access sexual and reproductive health information at their convenience, any time anywhere.</p>
       </div>
    </div>
</div>

</div>

    @endif
</div>
@endsection

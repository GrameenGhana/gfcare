@extends('layouts.app')

<!-- Scripts -->
@section('scripts')
    <script src="{{ asset('js/URI.min.js') }}"></script>
@append

<!-- Main Content -->
@section('content')
<spark-team-settings-screen :team-id="{{ $team->id }}" inline-template>
    <div id="spark-team-settings-screen" class="container spark-screen">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-3">
                <div class="panel panel-default panel-flush">
                    <div class="panel-heading" v-if="team">
                        Project Settings
                    </div>

                    <div class="panel-heading" v-else>
                        Loading &nbsp;&nbsp; <i class="fa fa-spinner fa-spin"></i>
                    </div>

                    <div class="panel-body">
                        <div class="spark-settings-tabs">
                            <ul class="nav spark-settings-tabs-stacked" role="tablist">
                                @foreach (Spark::teamSettingsTabs()->displayable($team, Auth::user()) as $tab)
                                    <li role="presentation"{!! $tab->key === $activeTab ? ' class="active"' : '' !!}>
                                        <a href="#{{ $tab->key }}" aria-controls="{{ $tab->key }}" role="tab" data-toggle="tab">
                                            <i class="fa fa-btn fa-fw {{ $tab->icon }}"></i>&nbsp;{{ $tab->name }}
                                        </a>
                                    </li>
                                @endforeach

                               @if (Auth::user()->isSuperAdmin())
                                <li role="presentation" role="tab">
                                    <a href="{{ url('/settings?tab=projects') }}">
                                        <i class="fa fa-btn fa-fw fa-search"></i>&nbsp;<strong>View All Projects</strong>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Panes -->
            <div class="col-md-9">
                <div class="tab-content">
                    @foreach (Spark::teamSettingsTabs()->displayable($team, Auth::user()) as $tab)
                        <div role="tabpanel" class="tab-pane{{ $tab->key == $activeTab ? ' active' : '' }}" id="{{ $tab->key }}">
                            @include($tab->view)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</spark-team-settings-screen>
@endsection

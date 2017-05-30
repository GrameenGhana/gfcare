@extends('layouts.app')

<!-- Scripts -->
@section('scripts')
    <script src="{{ asset('js/URI.min.js') }}"></script>
@append

<!-- Main Content -->
@section('content')
<gfcare-noyawa-screen :team-id="{{ $team->id }}" inline-template>
    <div id="spark-team-settings-screen" class="container spark-screen">
        <div class="row">
           
            <!-- Tabs -->
            <div class="col-md-3">
                <div class="panel panel-default panel-flush">
                    <div class="panel-heading" v-if="team">
                        NoYawa
                    </div>
                    <div class="panel-heading" v-else>
                        Loading &nbsp;&nbsp; <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <div class="panel-body">
                        <div class="spark-settings-tabs">
                            <ul class="nav spark-settings-tabs-stacked" role="tablist">
                                @foreach ($tabs->displayable($team, Auth::user()) as $tab)
                                   @if ($tab->group=='')
                                    <li role="presentation"{!! $tab->key === $activeTab ? ' class="active"' : '' !!}>
                                        <a href="#{{ $tab->key }}" aria-controls="{{ $tab->key }}" role="tab" data-toggle="tab">
                                            <i class="fa fa-btn fa-fw {{ $tab->icon }}"></i>&nbsp;{{ $tab->name }}
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                
                @foreach ($tabgroups as $tabgroup)
                @if ($tabgroup->canShow(Auth::user()))
                <div class="panel panel-default panel-flush" v-if="team">
                    <div class="panel-heading">
                        {{ $tabgroup->name }}
                    </div>
                    <div class="panel-body">
                        <div class="spark-settings-tabs">
                            <ul class="nav spark-settings-tabs-stacked" role="tablist">
                                @foreach ($tabs->displayable($team, Auth::user()) as $tab)
                                   @if ($tab->group==$tabgroup->name)
                                    <li role="presentation"{!! $tab->key === $activeTab ? ' class="active"' : '' !!}>
                                        <a href="#{{ $tab->key }}" aria-controls="{{ $tab->key }}" role="tab" data-toggle="tab">
                                            <i class="fa fa-btn fa-fw {{ $tab->icon }}"></i>&nbsp;{{ $tab->name }}
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <!-- Tab Panes -->
            <div class="col-md-9">
                <div class="tab-content">
                    @foreach ($tabs->displayable($team, Auth::user()) as $tab)
                        <div role="tabpanel" class="tab-pane{{ $tab->key == $activeTab ? ' active' : '' }}" id="{{ $tab->key }}">
                            @include($tab->view)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</gfcare-noyawa-screen>
@endsection

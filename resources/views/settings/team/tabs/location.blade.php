<!-- Main Content -->
<spark-team-settings-location-screen inline-template>
    <div id="spark-settings-team-screen">
        <div v-if="everythingIsLoaded">    
       
           <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <ul class="nav nav-pills nav-justified">
                           <li role="presentation" class="active">
                                <a href="#facs" aria-controls="facs" role="tab" data-toggle="tab">
                                    <i class="fa fa-btn fa-fw fa-hospital-o"></i>&nbsp;Facilities
                                </a>
                            </li>

                           <li role="presentation">
                                <a href="#facgroups" aria-controls="facgroups" role="tab" data-toggle="tab">
                                    <i class="fa fa-btn fa-fw fa-sitemap"></i>&nbsp;Facility Groups
                                </a>
                            </li>
                            
                            <li role="presentation" class="">
                                <a href="#location" aria-controls="location" role="tab" data-toggle="tab">
                                    <i class="fa fa-btn fa-fw fa-map-marker"></i>&nbsp;Locations
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
             
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                                               
                         <!-- Facilities -->
                        <div role="tabpanel" class="tab-pane active" id="facs">
                            @include('settings.team.tabs.location.facility')
                            @include('settings.team.tabs.location.modals.add-team-facility')
                            @include('settings.team.tabs.location.modals.edit-team-facility')
                        </div>

                         <!-- Facilities Groups -->
                        <div role="tabpanel" class="tab-pane" id="facgroups">
                            @include('settings.team.tabs.location.facilitygroup')
                            @include('settings.team.tabs.location.modals.add-team-facilitygroup')
                            @include('settings.team.tabs.location.modals.edit-team-facilitygroup')
                        </div>
                        
                         <!-- Locations -->
                        <div role="tabpanel" class="tab-pane" id="location">
                            @include('settings.team.tabs.location.geopolitical')
                            @include('settings.team.tabs.location.modals.add-team-location')
                            @include('settings.team.tabs.location.modals.edit-team-location')
                        </div>
                    </div>
                </div>
            </div>
            

            
        </div>
    </div>
</spark-team-settings-location-screen>

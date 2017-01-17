<gfcare-mobi-content-screen inline-template>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-justified">
                   <li role="presentation" class="active">
                        <a href="#pregnancy" aria-controls="pages" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Pregnancy Messages
                        </a>
                    </li>

                   <li role="presentation">
                        <a href="#firstyear" aria-controls="sections" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;FYL Messages
                        </a>
                    </li>

                   <li role="presentation">
                        <a href="#noyawa" aria-controls="sections" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;NoYawa Messages
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
             
    <div class="row">
        <div class="col-md-12">
            <div class="tab-content">

                 <!-- Pregnancy -->
                <div role="tabpanel" class="tab-pane active" id="pregnancy">
                    @include('MobiHealth::content.pregnancy')
                </div>

                 <!-- FYL -->
                <div role="tabpanel" class="tab-pane" id="firstyear">
                    @include('MobiHealth::content.firstyear')
                </div>

                 <!-- No Yawa -->
                <div role="tabpanel" class="tab-pane" id="noyawa">
                    @include('MobiHealth::content.noyawa')
                </div>
            </div>
        </div>
    </div>
            

</gfcare-mobi-content-screen>

<gfcare-cch-content-screen inline-template>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-justified">
                   <li role="presentation" class="active">
                        <a href="#pages" aria-controls="pages" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Pages
                        </a>
                    </li>

                   <li role="presentation">
                        <a href="#sections" aria-controls="sections" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Sections
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
             
    <div class="row">
        <div class="col-md-12">
            <div class="tab-content">

                 <!-- Pages -->
                <div role="tabpanel" class="tab-pane active" id="pages">
                    @include('CCH::content.page')
                </div>

                 <!-- Sections -->
                <div role="tabpanel" class="tab-pane" id="sections">
                    @include('CCH::content.section')
                </div>
            </div>
        </div>
    </div>
            

</gfcare-cch-content-screen>

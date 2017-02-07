<gfcare-cch-content-screen inline-template>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-justified">
                   <li role="presentation" class="active">
                        <a href="#sections" aria-controls="sections" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Sections
                        </a>
                    </li>

                   <li role="presentation">
                        <a href="#subsections" aria-controls="subsections" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Sub Sections
                        </a>
                    </li>

                   <li role="presentation">
                        <a href="#topics" aria-controls="topics" role="tab" data-toggle="tab">
                            <i class="fa fa-btn fa-fw fa-text-o"></i>&nbsp;Topics
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
             
    <div class="row">
        <div class="col-md-12">
            <div class="tab-content">

                 <!-- Sections -->
                <div role="tabpanel" class="tab-pane active" id="sections">
                    @include('CCH::content.section')
                </div>

                 <!-- Sub Sections -->
                <div role="tabpanel" class="tab-pane" id="subsections">
                    @include('CCH::content.subsection')
                </div>

                 <!-- Topics -->
                <div role="tabpanel" class="tab-pane active" id="topics">
                    @include('CCH::content.topic')
                </div>

            </div>
        </div>
    </div>
            

</gfcare-cch-content-screen>

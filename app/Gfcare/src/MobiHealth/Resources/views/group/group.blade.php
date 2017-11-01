<gfcare-mobi-group-screen  :team-id="{{ $team->id }}" inline-template>

<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
        <div class="panel-body">
                  <gfcare-mm-mobihealth-dropdown></gfcare-mm-mobihealth-dropdown>
        </div>
            </div>
        </div>
</div>
<div class="row">
<div class="panel panel-default">
       <div class="col-md-12">
                
            <!-- Content -->
            <div class="panel panel-default">
                <div class="panel-heading">Meeting Attendance</div>
                    
        <div class="panel-body" v-if="attendees.length > 0">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Person</th>
                            <th>Contact</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in attendees">
                            <td class="spark-table-pad">@{{ i.firstname }} @{{ i.lastname }}</td>
                            <td class="spark-table-pad">@{{ i.phonenumber }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <div v-else class="panel-body">
                No content found.
            </div>

            </div>

        </div>

  </div>
  </div>

</gfcare-mm-campaign-screen inline-template>
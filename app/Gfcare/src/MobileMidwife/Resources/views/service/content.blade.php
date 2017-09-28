<gfcare-mm-service-content-screen :team-id="{{ $team->id }}" inline-template>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
				<div class="panel-body">
                	<gfcare-mm-content-dropdown></gfcare-mm-content-dropdown>
				</div>
            </div>
        </div>
    </div>
             
    <div class="row">
        <div class="col-md-12">
                
            <!-- Content -->
            <div class="panel panel-default">
                <div class="panel-heading">Content
                  <button class="btn btn-default pull-right" @click.prevent="addContent()">
                <i class="fa fa-btn fa-plus"></i>Add Content
                 </button>
               
                </div>
                    
 				<div class="panel-body" v-if="content.length > 0">
            		<table class="table table-responsive">
		                <thead>
		                    <tr>
		                        <th>Name</th>
		                        <th>Week</th>
		                        <th>Message</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr v-for="i in content">
		                        <td class="spark-table-pad">@{{ i.name }}</td>
		                        <td class="spark-table-pad">@{{ i.week }}</td>
		                        <td class="spark-table-pad">@{{ i.sms_message }} </td>
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

</gfcare-mm-service-content-screen>

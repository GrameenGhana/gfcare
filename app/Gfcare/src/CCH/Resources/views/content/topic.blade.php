<gfcare-cch-content-screen inline-template>

    <!-- Topics -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Topics
            
            <button class="btn btn-default pull-right" @click.prevent="addTopic()">
                <i class="fa fa-btn fa-plus"></i>Add Topic
            </button> 
        </div>

        <div class="panel-body" v-if="user && topics.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Sub Section</th>
                        <th>Uploaded Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="topic in topics">
                        <td class="spark-table-pad">@{{ topic.name }}</td>
                        <td class="spark-table-pad">@{{ topic.section }}</td>
                        <td class="spark-table-pad">@{{ topic.sub_section }}</td>
						<td class="spark-table-pad">
                            <div v-if="topic.upload_status=='Uploaded'">
                                Uploaded
                            </div>
                            <div v-else>
                                <button class="btn btn-success btn-circle" style="margin-right: 10px" @click.prevent="editTopic(topic)"> 
									<i class="fa fa-upload"></i>
                                </button>
                            </div>
                        </td>

                        <td class="spark-table-pad">
                           
                             <button class="btn btn-warning btn-circle btn-xs" @click.prevent="editTopic(topic)">
                                 <i class="fa fa-pencil"></i>
                            </button>
                            
                            <button class="btn btn-danger btn-circle pull-right btn-xs" @click.prevent="removeTopic(topic)" :disabled="removingTopic(topic.id)">
                                <span v-if="removingTopic(topic.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No topics found.
        </div>
    </div>
         
    
</gfcare-cch-content-screen>

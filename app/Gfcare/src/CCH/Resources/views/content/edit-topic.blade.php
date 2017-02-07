    <div class="modal fade" id="modal-edit-topic" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Edit Topic</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateTopic"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-text :display="'Name*'"
                            :form="forms.updateTopic"
                            :name="'name'"
                            :input.sync="forms.updateTopic.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.updateTopic"
                            :name="'shortname'"
                            :source.sync="forms.updateTopic.name"
                            :input.sync="forms.updateTopic.shortname">
                        </spark-shortname>   
                                                                      
                         <spark-select :display="'Sub Topic*'"
                                       :form="forms.updateTopic"
                                       :name="'sub_topic'"
                                       :items="subTopicOptions"
                                       :input.sync="forms.updateTopic.sub_topic">
                        </spark-select>                 

                        <spark-text :display="'Description*'"
                            :form="forms.updateTopic"
                            :name="'description'"
                            :input.sync="forms.updateTopic.description">
                        </spark-text>
                            
                        <spark-file :display="'Upload file'"
                            :form="forms.updateTopic"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :input.sync="forms.updateTopic.reference_file">
                        </spark-file>           
                    </form>

                    <fieldset>
                       <legend>Uploads</legend> 
                        <div class="panel-body" v-if="editingTopic.upload!=null">
                            File name: @{{ editingTopic.upload.file_url }}
                        </div>
                        <div v-else class="panel-body">
                            No uploads found.
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updateTopic" :disabled="forms.updateTopic.busy">
                        <span v-if="forms.updateTopic.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

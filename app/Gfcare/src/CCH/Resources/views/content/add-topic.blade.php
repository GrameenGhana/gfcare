    <div class="modal fade" id="modal-add-topic" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Topic</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addTopic"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-select :display="'Sub Section*'"
                                       :form="forms.addTopic"
                                       :name="'sub_section_id'"
                                       :items="subSectionOptions"
                                       :input.sync="forms.addTopic.sub_section_id">
                        </spark-select>   
                       
                        <spark-text :display="'Name*'"
                            :form="forms.addTopic"
                            :name="'name'"
                            :input.sync="forms.addTopic.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.addTopic"
                            :name="'shortname'"
                            :source.sync="forms.addTopic.name"
                            :input.sync="forms.addTopic.shortname">
                        </spark-shortname>   
                                                                      
                        <spark-text :display="'Description*'"
                            :form="forms.addTopic"
                            :name="'description'"
                            :input.sync="forms.addTopic.description">
                        </spark-text>
                            
                        <spark-file :display="'Upload file'"
                            :form="forms.addTopic"
                            :name="'upload_file'"
                            :warning="'File must be less than 20MB. Must be in xml format'"
                            :filename.sync="forms.addTopic.file_name"
                            :input.sync="forms.addTopic.upload_file">
                        </spark-file>           
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewTopic" :disabled="forms.addTopic.busy">
                        <span v-if="forms.addTopic.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

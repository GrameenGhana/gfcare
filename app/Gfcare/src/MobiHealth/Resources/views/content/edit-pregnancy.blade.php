    <div class="modal fade" id="modal-edit-pregnancy" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Update Edit Pregnancy File</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updatePregnancyFile"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-hidden 
                            :form="forms.updatePregnancyFile"
                            :name="'week'"
                            :input.sync="forms.updatePregancyFile.week">
                        </spark-hidden>
                        <spark-hidden 
                            :form="forms.updatePregnancyFile"
                            :name="'trimester'"
                            :input.sync="forms.updatePregancyFile.trimester">
                        </spark-hidden>

                        <spark-text :display="'Name'"
                            :form="forms.updatePregnancyFile"
                            :name="'name'"
                            :input.sync="forms.updatePregancyFile.name">
                        </spark-text>
                        
                        <spark-file :display="'Upload file'"
                            :form="forms.updatePregnancyFile"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in MP3 format'"
                            :input.sync="forms.updatePregnancyFile.file_url">
                        </spark-file>
                                                
                        <spark-shortname :display="'File Name'"
                            :form="forms.addPregnancyFile"
                            :name="'filename'"
                            :source.sync="forms.updatePregnancyFile.name"
                            :input.sync="forms.updatePregnancyFile.filename">
                        </spark-shortname>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updatePregnancyFile" :disabled="forms.updatePregnancyFile.busy">
                        <span v-if="forms.updatePregnancyFile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

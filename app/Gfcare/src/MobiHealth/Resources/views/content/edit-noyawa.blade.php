    <div class="modal fade" id="modal-edit-noyawa" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Update Edit No Yawa File</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateNoyawaFile"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-hidden 
                            :form="forms.updateNoyawaFile"
                            :name="'week'"
                            :input.sync="forms.updateNoyawaFile.week">
                        </spark-hidden>

                        <spark-text :display="'Series'"
                            :form="forms.updateNoyawaFile"
                            :name="'series'"
                            :input.sync="forms.updateNoyawaFile.series">
                        </spark-text>
                        
                        <spark-text :display="'Name'"
                            :form="forms.updateNoyawaFile"
                            :name="'name'"
                            :input.sync="forms.updateNoyawaFile.name">
                        </spark-text>
                        
                        <spark-file :display="'Upload file'"
                            :form="forms.updateNoyawaFile"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in MP3 format'"
                            :input.sync="forms.updateNoyawaFile.file_url">
                        </spark-file>
                                                
                        <spark-shortname :display="'File Name'"
                            :form="forms.updateNoyawaFile"
                            :name="'filename'"
                            :source.sync="forms.updateNoyawaFile.name"
                            :input.sync="forms.updateNoyawaFile.filename">
                        </spark-shortname>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updateNoyawaFile" :disabled="forms.updateNoyawaFile.busy">
                        <span v-if="forms.updateNoyawaFile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

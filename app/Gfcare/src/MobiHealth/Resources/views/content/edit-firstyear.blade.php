    <div class="modal fade" id="modal-edit-firstyear" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Update Edit FYL File</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateFirstYearFile"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-hidden 
                            :form="forms.updateFirstYearFile"
                            :name="'week'"
                            :input.sync="forms.updateFirstYearFile.week">
                        </spark-hidden>

                        <spark-text :display="'Name'"
                            :form="forms.updateFirstYearFile"
                            :name="'name'"
                            :input.sync="forms.updateFirstYearFile.name">
                        </spark-text>
                        
                        <spark-file :display="'Upload file'"
                            :form="forms.updateFirstYearFile"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in MP3 format'"
                            :input.sync="forms.updateFirstYearFile.file_url">
                        </spark-file>
                                                
                        <spark-shortname :display="'File Name'"
                            :form="forms.updateFirstYearFile"
                            :name="'filename'"
                            :source.sync="forms.updateFirstYearFile.name"
                            :input.sync="forms.updateFirstYearFile.filename">
                        </spark-shortname>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updateFirstYearFile" :disabled="forms.updateFirstYearFile.busy">
                        <span v-if="forms.updateFirstYearFile.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

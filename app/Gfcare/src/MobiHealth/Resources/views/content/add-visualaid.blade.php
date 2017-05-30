    <div class="modal fade" id="modal-add-visual" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Visual Aid</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addVisual"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Description'"
                            :form="forms.addVisual"
                            :name="'type'"
                            :input.sync="forms.addVisual.reference_desc">
                        </spark-text>
                        
                        <spark-file :display="'Upload file'"
                            :form="forms.addVisual"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :input.sync="forms.addVisual.reference_file">
                        </spark-file>
                                                
                        <spark-shortname :display="'Page Shortname'"
                            :form="forms.addVisual"
                            :name="'shortname'"
                            :source.sync="forms.addVisual.reference_desc"
                            :input.sync="forms.addVisual.shortname">
                        </spark-shortname>
                    
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewVisual" :disabled="forms.addVisual.busy">
                        <span v-if="forms.addVisual.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

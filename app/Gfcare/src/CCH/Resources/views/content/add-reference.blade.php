    <div class="modal fade" id="modal-add-reference" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Reference</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addReference"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Description'"
                            :form="forms.addReference"
                            :name="'type'"
                            :input.sync="forms.addReference.reference_desc">
                        </spark-text>
                        
                        <spark-file :display="'Upload file'"
                            :form="forms.addReference"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :input.sync="forms.addReference.reference_file">
                        </spark-file>
                                                
                        <spark-shortname :display="'Page Shortname'"
                            :form="forms.addReference"
                            :name="'shortname'"
                            :source.sync="forms.addReference.reference_desc"
                            :input.sync="forms.addReference.shortname">
                        </spark-shortname>
                    
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewReference" :disabled="forms.addReference.busy">
                        <span v-if="forms.addReference.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

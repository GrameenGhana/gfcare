    <div class="modal fade" id="modal-edit-reference" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Edit Reference</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateReference"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Description'"
                            :form="forms.updateReference"
                            :name="'reference_dec'"
                            :input.sync="forms.updateReference.reference_desc">
                        </spark-text>
                        
                        <spark-file :display="'Upload file'"
                            :form="forms.updateReference"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :filename.sync="forms.updateReference.file_name"
                            :input.sync="forms.updateReference.reference_file">
                        </spark-file>
                                                
                        <spark-shortname :display="'Page Shortname'"
                            :form="forms.updateReference"
                            :name="'shortname'"
                            :source.sync="forms.updateReference.reference_desc"
                            :input.sync="forms.updateReference.shortname">
                        </spark-shortname>                   
                    </form>
                    
                    <fieldset>
                       <legend>Uploads</legend> 
                        <div class="panel-body" v-if="editingReference.file_url">
                            File name: @{{ editingReference.file_url }}
                        </div>
                        <div v-else class="panel-body">
                            No uploads found.
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updateReference" :disabled="forms.updateReference.busy">
                        <span v-if="forms.updateReference.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Updating</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

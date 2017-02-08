    <div class="modal fade" id="modal-add-section" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Section</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addSection"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-text :display="'Name*'"
                            :form="forms.addSection"
                            :name="'name'"
                            :input.sync="forms.addSection.name">
                        </spark-text>
                            
                        <spark-file :display="'Icon file'"
                            :form="forms.addSection"
                            :name="'icon_file'"
                            :warning="'File must be less than 20MB. Must be an image file'"
                            :filename.sync="forms.addSection.file_name"
                            :input.sync="forms.addSection.icon_file">
                        </spark-file>       
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewSection" :disabled="forms.addSection.busy">
                        <span v-if="forms.addSection.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

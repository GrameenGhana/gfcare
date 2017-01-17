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
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.addSection"
                            :name="'shortname'"
                            :source.sync="forms.addSection.name"
                            :input.sync="forms.addSection.shortname">
                        </spark-shortname>   
                                                                      
                         <spark-select :display="'Sub Section*'"
                                       :form="forms.addSection"
                                       :name="'sub_section'"
                                       :items="subSectionOptions"
                                       :input.sync="forms.addSection.sub_section">
                        </spark-select>                 

                        <spark-text :display="'Description*'"
                            :form="forms.addSection"
                            :name="'description'"
                            :input.sync="forms.addSection.description">
                        </spark-text>
                            
                        <spark-file :display="'Upload file'"
                            :form="forms.addSection"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :input.sync="forms.addSection.reference_file">
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

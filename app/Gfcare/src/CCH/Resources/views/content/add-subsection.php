    <div class="modal fade" id="modal-add-subsection" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add SubSection</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addSubSection"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-text :display="'Name*'"
                            :form="forms.addSubSection"
                            :name="'name'"
                            :input.sync="forms.addSubSection.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.addSubSection"
                            :name="'shortname'"
                            :source.sync="forms.addSubSection.name"
                            :input.sync="forms.addSubSection.shortname">
                        </spark-shortname>   
                                                                      
                         <spark-select :display="'Sub SubSection*'"
                                       :form="forms.addSubSection"
                                       :name="'sub_subsection'"
                                       :items="subSubSectionOptions"
                                       :input.sync="forms.addSubSection.sub_subsection">
                        </spark-select>                 

                        <spark-text :display="'Description*'"
                            :form="forms.addSubSection"
                            :name="'description'"
                            :input.sync="forms.addSubSection.description">
                        </spark-text>
                            
                        <spark-file :display="'Upload file'"
                            :form="forms.addSubSection"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :input.sync="forms.addSubSection.reference_file">
                        </spark-file>           
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewSubSection" :disabled="forms.addSubSection.busy">
                        <span v-if="forms.addSubSection.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

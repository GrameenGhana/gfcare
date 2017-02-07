    <div class="modal fade" id="modal-edit-subsection" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Edit SubSection</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateSubSection"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-select :display="'Type*'"
                                       :form="forms.updateSubSection"
                                       :name="'type'"
                                       :items="subsectionTypeOptions"
                                       :input.sync="forms.updateSubSection.type">
                        </spark-select> 
                                      
                        <spark-select :display="'Section*'"
                                       :form="forms.updateSubSection"
                                       :name="'section'"
                                       :items="sectionOptions"
                                       :input.sync="forms.updateSubSection.section">
                        </spark-select> 
                        
                        <spark-text :display="'Name*'"
                            :form="forms.updateSubSection"
                            :name="'name'"
                            :input.sync="forms.updateSubSection.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.updateSubSection"
                            :name="'shortname'"
                            :source.sync="forms.updateSubSection.name"
                            :input.sync="forms.updateSubSection.shortname">
                        </spark-shortname>   
                                                                      
                        <spark-text :display="'Title*'"
                            :form="forms.updateSubSection"
                            :name="'subtitle'"
                            :input.sync="forms.updateSubSection.subtitle">
                        </spark-text>

                        <spark-text :display="'Description*'"
                            :form="forms.updateSubSection"
                            :name="'description'"
                            :input.sync="forms.updateSubSection.description">
                        </spark-text>
                            
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewSubSection" :disabled="forms.updateSubSection.busy">
                        <span v-if="forms.updateSubSection.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

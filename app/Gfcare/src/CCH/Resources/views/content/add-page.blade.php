    <div class="modal fade" id="modal-add-page" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Page</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addPage"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-select :display="'Type*'"
                                       :form="forms.addPage"
                                       :name="'type'"
                                       :items="pageTypeOptions"
                                       :input.sync="forms.addPage.type">
                        </spark-select> 
                                      
                        <spark-select :display="'Section*'"
                                       :form="forms.addPage"
                                       :name="'section'"
                                       :items="sectionOptions"
                                       :input.sync="forms.addPage.section">
                        </spark-select> 
                        
                        <spark-text :display="'Name*'"
                            :form="forms.addPage"
                            :name="'name'"
                            :input.sync="forms.addPage.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.addPage"
                            :name="'shortname'"
                            :source.sync="forms.addPage.name"
                            :input.sync="forms.addPage.shortname">
                        </spark-shortname>   
                                                                      
                        <spark-text :display="'Title*'"
                            :form="forms.addPage"
                            :name="'subtitle'"
                            :input.sync="forms.addPage.subtitle">
                        </spark-text>

                        <spark-text :display="'Description*'"
                            :form="forms.addPage"
                            :name="'description'"
                            :input.sync="forms.addPage.description">
                        </spark-text>
                            
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewPage" :disabled="forms.addPage.busy">
                        <span v-if="forms.addPage.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

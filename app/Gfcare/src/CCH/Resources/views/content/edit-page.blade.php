    <div class="modal fade" id="modal-edit-page" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Edit Page</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updatePage"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-select :display="'Type*'"
                                       :form="forms.updatePage"
                                       :name="'type'"
                                       :items="pageTypeOptions"
                                       :input.sync="forms.updatePage.type">
                        </spark-select> 
                                      
                        <spark-select :display="'Section*'"
                                       :form="forms.updatePage"
                                       :name="'section'"
                                       :items="sectionOptions"
                                       :input.sync="forms.updatePage.section">
                        </spark-select> 
                        
                        <spark-text :display="'Name*'"
                            :form="forms.updatePage"
                            :name="'name'"
                            :input.sync="forms.updatePage.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.updatePage"
                            :name="'shortname'"
                            :source.sync="forms.updatePage.name"
                            :input.sync="forms.updatePage.shortname">
                        </spark-shortname>   
                                                                      
                        <spark-text :display="'Title*'"
                            :form="forms.updatePage"
                            :name="'subtitle'"
                            :input.sync="forms.updatePage.subtitle">
                        </spark-text>

                        <spark-text :display="'Description*'"
                            :form="forms.updatePage"
                            :name="'description'"
                            :input.sync="forms.updatePage.description">
                        </spark-text>
                            
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="addNewPage" :disabled="forms.updatePage.busy">
                        <span v-if="forms.updatePage.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Add </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

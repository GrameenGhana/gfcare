    <div class="modal fade" id="modal-edit-section" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-pencil"></i>Edit Section</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateSection"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form"> 
                        <spark-text :display="'Name*'"
                            :form="forms.updateSection"
                            :name="'name'"
                            :input.sync="forms.updateSection.name">
                        </spark-text>
                                   
                        <spark-shortname :display="'Shortname*'"
                            :form="forms.updateSection"
                            :name="'shortname'"
                            :source.sync="forms.updateSection.name"
                            :input.sync="forms.updateSection.shortname">
                        </spark-shortname>   
                                                                      
                         <spark-select :display="'Sub Section*'"
                                       :form="forms.updateSection"
                                       :name="'sub_section'"
                                       :items="subSectionOptions"
                                       :input.sync="forms.updateSection.sub_section">
                        </spark-select>                 

                        <spark-text :display="'Description*'"
                            :form="forms.updateSection"
                            :name="'description'"
                            :input.sync="forms.updateSection.description">
                        </spark-text>
                            
                        <spark-file :display="'Upload file'"
                            :form="forms.updateSection"
                            :name="'reference_file'"
                            :warning="'File must be less than 20MB. Must be in PDF format'"
                            :input.sync="forms.updateSection.reference_file">
                        </spark-file>           
                    </form>

                    <fieldset>
                       <legend>Uploads</legend> 
                        <div class="panel-body" v-if="editingSection.upload!=null">
                            File name: @{{ editingSection.upload.file_url }}
                        </div>
                        <div v-else class="panel-body">
                            No uploads found.
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updateSection" :disabled="forms.updateSection.busy">
                        <span v-if="forms.updateSection.busy"><i class="fa fa-btn fa-spinner fa-spin"></i> Adding</span>
                        <span v-else> <i class="fa fa-btn fa-save"></i> Update </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

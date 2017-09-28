<div class="modal fade" id="modal-add-content" tabindex="-1" role="dialog">
   <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Content</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addContent"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                    
                        <spark-text :display="'Name'"
                            :form="forms.addContent"
                            :name="'name'"
                            :input.sync="forms.addContent.name">
                        </spark-text>
                         <spark-text :display="'Week'"
                            :form="forms.addContent"
                            :name="'week'"
                            :input.sync="forms.addContent.week">
                        </spark-text>

                         <spark-select :display="'Content type'"
                                                   :form="forms.addContent"
                                                   :name="'content_type'"
                                                   :items="contentOptions"
                                                   :input.sync="forms.addContent.content_type">
                           </spark-select>  

                        <spark-text :display="'Message'"
                            :form="forms.addContent"
                            :name="'sms_message'"
                            :input.sync="forms.addContent.sms_message">
                        </spark-text>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" 
                            :disabled="forms.addContent.busy">
                        <span v-if="forms.addContent.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Adding
                        </span>

                        <span v-else>
                            <i class="fa fa-btn fa-save"></i> Add
                        </span>
                    </button>
                </div>
            </div>
        </div>



</div>
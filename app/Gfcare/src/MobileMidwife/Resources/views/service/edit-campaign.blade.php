 <div class="modal fade" id="modal-edit-campaign" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Edit  Campaign</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.editCampaign"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                    
                        <spark-text :display="'Name'"
                            :form="forms.editCampaign"
                            :name="'name'"
                            :input.sync="forms.editCampaign.name">
                        </spark-text>
                         <spark-text :display="'Description'"
                            :form="forms.editCampaign"
                            :name="'description'"
                            :input.sync="forms.editCampaign.description">
                        </spark-text>

                         <spark-text :display="'Start Date'"
                            :form="forms.editCampaign"
                            :name="'start_date'"
                            :input.sync="forms.editCampaign.start_date">
                        </spark-text>

                        <spark-text :display="'End Date'"
                            :form="forms.editCampaign"
                            :name="'end_date'"
                            :input.sync="forms.editCampaign.end_date">
                        </spark-text>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateCampaign"
                            :disabled="forms.editCampaign.busy">
                        <span v-if="forms.editCampaign.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Editing
                        </span>

                        <span v-else>
                            <i class="fa fa-btn fa-save"></i> Edit
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-add-campaign" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Campaign</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addCampaign"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                    
                        <spark-text :display="'Name'"
                            :form="forms.addCampaign"
                            :name="'name'"
                            :input.sync="forms.addCampaign.name">
                        </spark-text>
                         <spark-text :display="'Description'"
                            :form="forms.addCampaign"
                            :name="'description'"
                            :input.sync="forms.addCampaign.description">
                        </spark-text>

                         <spark-text :display="'Start Date'"
                            :form="forms.addCampaign"
                            :name="'start_date'"
                            :input.sync="forms.addCampaign.start_date">
                        </spark-text>

                        <spark-text :display="'End Date'"
                            :form="forms.addCampaign"
                            :name="'end_date'"
                            :input.sync="forms.addCampaign.end_date">
                        </spark-text>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewCampaign"
                            :disabled="forms.addCampaign.busy">
                        <span v-if="forms.addCampaign.busy">
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


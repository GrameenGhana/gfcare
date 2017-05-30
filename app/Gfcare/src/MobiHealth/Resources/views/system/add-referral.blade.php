    <div class="modal fade" id="modal-add-referral" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Referral</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addReferral"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                                    <spark-select :display="'Volunteer*'"
                                                   :form="forms.addReferral"
                                                   :name="'mhv'"
                                                   :items="volunteers"
                                                   :input.sync="forms.addReferral.mhv">
                                    </spark-select>  
                                    <spark-select :display="'Supervisor*'"
                                                   :form="forms.addReferral"
                                                   :name="'supervisor'"
                                                   :items="supervisors"
                                                   :input.sync="forms.addReferral.supervisor">
                                    </spark-select>  
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewReferral"
                            :disabled="forms.addReferral.busy">
                        <span v-if="forms.addReferral.busy">
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

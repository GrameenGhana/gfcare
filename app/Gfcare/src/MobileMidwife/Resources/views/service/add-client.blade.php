    <div class="modal fade" id="modal-add-client" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Client</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addClient"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                    
                        <spark-text :display="'Name'"
                            :form="forms.addClient"
                            :name="'name'"
                            :input.sync="forms.addClient.name">
                        </spark-text>
                                    <spark-select :display="'Volunteer*'"
                                                   :form="forms.addClient"
                                                   :name="'user_id'"
                                                   :items="userOptions"
                                                   :input.sync="forms.addClient.user_id">
                                    </spark-select>  

                                    <spark-select :display="'Register for MM?*'"
                                       :form="forms.addClient"
                                       :name="'registered'"
                                       :items="yesNoOptions"
                                       :input.sync="forms.addClient.registered">
                                    </spark-select>  
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewClient"
                            :disabled="forms.addClient.busy">
                        <span v-if="forms.addClient.busy">
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

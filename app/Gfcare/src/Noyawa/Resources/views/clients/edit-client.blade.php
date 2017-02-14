    <div class="modal fade" id="modal-edit-client" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Edit Client</h4>
                </div>

                <div class="modal-body">

                    <spark-error-alert :form="forms.updateClient"></spark-error-alert>

                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Name'"
                            :form="forms.updateClient"
                            :name="'name'"
                            :input.sync="forms.updateClient.name">
                        </spark-text>
                                    <spark-select :display="'Volunteer*'"
                                                   :form="forms.updateClient"
                                                   :name="'user_id'"
                                                   :items="userOptions"
                                                   :input.sync="forms.updateClient.user_id">
                                    </spark-select>  

                                    <spark-select :display="'Register for MM?*'"
                                       :form="forms.updateClient"
                                       :name="'registered'"
                                       :items="yesNoOptions"
                                       :input.sync="forms.updateClient.registered">
                                    </spark-select>  

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateClient"
                            :disabled="forms.updateClient.busy">
                        <span v-if="forms.updateClient.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Updating
                        </span>

                        <span v-else>
                            <i class="fa fa-btn fa-save"></i> Update
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

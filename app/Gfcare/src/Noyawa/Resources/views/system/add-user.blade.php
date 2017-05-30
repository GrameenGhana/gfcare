    <div class="modal fade" id="modal-add-user" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add User</h4>
                </div>

                <div v-if="userOptions.length > 0">
                <div class="modal-body">
                    <spark-error-alert :form="forms.addUser"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">  
                       
                        <div class="row">
                            <div class="col-md-12">
                                    <spark-select :display="'Users*'"
                                                   :form="forms.addUser"
                                                   :name="'user_id'"
                                                   :items="userOptions"
                                                   :input.sync="forms.addUser.user_id">
                                    </spark-select>  
                                    <spark-select :display="'Role*'"
                                       :form="forms.addUser"
                                       :name="'role'"
                                       :items="roleOptions"
                                       :input.sync="forms.addUser.role">
                                    </spark-select>
                            </div>
                        </div>                     
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewUser"
                            :disabled="forms.addUser.busy">
                        <span v-if="forms.addUser.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Adding
                        </span>

                        <span v-else>
                            <i class="fa fa-btn fa-save"></i> Add
                        </span>
                    </button>
                </div>
                </div>

                <div v-else>
                    <div class="modal-body">
                        All available users for this project have been assigned to this module. Use the Project settings to add new users.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

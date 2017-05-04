    <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Edit User</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateUser"></spark-error-alert>

                    <!-- Add Location Form -->
                    <form class="form-horizontal" role="form">                        
                         <div class="row">
                            <div class="col-md-12">
                                    <spark-select :display="'Role*'"
                                       :form="forms.updateUser"
                                       :name="'role'"
                                       :items="roleOptions"
                                       :input.sync="forms.updateUser.role">
                                    </spark-select>
                            </div>
                        </div>                   
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateUser"
                            :disabled="forms.updateUser.busy">
                        <span v-if="forms.updateUser.busy">
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

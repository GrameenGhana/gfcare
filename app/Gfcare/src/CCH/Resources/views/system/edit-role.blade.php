    <div class="modal fade" id="modal-edit-role" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Edit Role</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateRole"></spark-error-alert>

                    <!-- Add Location Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Name'"
                            :form="forms.updateRole"
                            :name="'name'"
                            :input.sync="forms.updateRole.name">
                        </spark-text>
                        
                        <spark-select :display="'Can Edit Content'"
                                       :form="forms.updateRole"
                                       :name="'is_editor'"
                                       :items="yesNoOptions"
                                       :input.sync="forms.updateRole.is_editor">
                        </spark-select>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateRole"
                            :disabled="forms.updateRole.busy">
                        <span v-if="forms.updateRole.busy">
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
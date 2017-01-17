    <div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Role</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addRole"></spark-error-alert>

                    <!-- Add Location Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Name'"
                            :form="forms.addRole"
                            :name="'name'"
                            :input.sync="forms.addRole.name">
                        </spark-text>
                        
                        <spark-select :display="'Can Edit Content'"
                                       :form="forms.addRole"
                                       :name="'is_editor'"
                                       :items="yesNoOptions"
                                       :input.sync="forms.addRole.is_editor">
                        </spark-select>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewRole"
                            :disabled="forms.addRole.busy">
                        <span v-if="forms.addRole.busy">
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
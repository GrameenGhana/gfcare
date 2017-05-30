<spark-team-settings-edit-team-location-screen :team="team" :team-location="editingTeamLocation" inline-template>
    <div class="modal fade" id="modal-edit-team-location" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-edit"></i>Edit @{{ teamLocation.name }}</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateTeamLocation"></spark-error-alert>

                    <!-- Update Location Form -->
                    <form class="form-horizontal" role="form">
                       <spark-hidden 
                            :form="forms.updateTeamLocation"
                            :name="'level'"
                            :input.sync="forms.updateTeamLocation.level">
                        </spark-hidden>
                        <spark-hidden 
                            :form="forms.updateTeamLocation"
                            :name="'type'"
                            :input.sync="forms.updateTeamLocation.type">
                        </spark-hidden>
                        <spark-hidden 
                            :form="forms.updateTeamLocation"
                            :name="'parent_id'"
                            :input.sync="forms.updateTeamLocation.parent_id">
                        </spark-hidden>                      
                        <spark-text :display="'Name'"
                            :form="forms.updateTeamLocation"
                            :name="'name'"
                            :input.sync="forms.updateTeamLocation.name">
                        </spark-text>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateTeamLocation"
                            :disabled="forms.updateTeamLocation.busy">
                        <span v-if="forms.updateTeamLocation.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Updating...
                        </span>

                        <span v-else>
                            <i class="fa fa-btn fa-save"></i> Update
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</spark-team-settings-edit-team-location-screen>

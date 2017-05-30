<spark-team-settings-edit-team-facilitygroup-screen :team="team" :team-facility-group="editingTeamFacilityGroup" inline-template>
    <div class="modal fade" id="modal-edit-team-facilitygroup" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-edit"></i>Edit @{{ teamFacilityGroup.name }}</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateTeamFacilityGroup"></spark-error-alert>

                    <!-- Update Facility Form -->
                    <form class="form-horizontal" role="form">
                        <spark-select :display="'Facility Group Type'"
                                      :form="forms.updateTeamFacilityGroup"
                                      :name="'type'"
                                      :items="types"
                                      :input.sync="forms.updateTeamFacilityGroup.type">
                        </spark-select>

                        <spark-text :display="'Name'"
                            :form="forms.updateTeamFacilityGroup"
                            :name="'name'"
                            :input.sync="forms.updateTeamFacilityGroup.name">
                        </spark-text>
                        
                        <spark-text :display="'Facilities'"
                            :form="forms.updateTeamFacilityGroup"
                            :name="'facilities'"
                            :input.sync="forms.updateTeamFacilityGroup.facilities">
                        </spark-text>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateTeamFacilityGroup"
                            :disabled="forms.updateTeamFacilityGroup.busy">
                        <span v-if="forms.updateTeamFacilityGroup.busy">
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
</spark-team-settings-edit-team-facilitygroup-screen>

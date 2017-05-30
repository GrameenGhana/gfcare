<spark-team-settings-add-team-facilitygroup-screen :team="team" :facility-group-types="facilityGroupTypes" inline-template>
    <div class="modal fade" id="modal-add-team-facilitygroup" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Facility Group</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addTeamFacilityGroup"></spark-error-alert>

                    <!-- Add Facility Group Form -->
                    <form class="form-horizontal" role="form">
                        <spark-select :display="'Facility Group Type'"
                                      :form="forms.addTeamFacilityGroup"
                                      :name="'type'"
                                      :items="types"
                                      :input.sync="forms.addTeamFacilityGroup.type">
                        </spark-select>

                        <spark-text :display="'Name'"
                            :form="forms.addTeamFacilityGroup"
                            :name="'name'"
                            :input.sync="forms.addTeamFacilityGroup.name">
                        </spark-text>
                        
                        <spark-facility-select :display="'Facilities'"
                                      :form="forms.addTeamFacilityGroup"
                                      :name="'facilities'"
                                      :team-id="team.id"
                                      :input.sync="forms.addTeamFacilityGroup.facilities">
                        </spark-facility-select>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addTeamFacilityGroup"
                            :disabled="forms.addTeamFacilityGroup.busy">
                        <span v-if="forms.addTeamFacilityGroup.busy">
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
</spark-team-settings-add-team-facilitygroup-screen>

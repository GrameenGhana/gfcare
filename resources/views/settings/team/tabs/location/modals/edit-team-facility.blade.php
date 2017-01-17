<spark-team-settings-edit-team-facility-screen :team="team" :team-facility="editingTeamFacility" inline-template>
    <div class="modal fade" id="modal-edit-team-facility" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-edit"></i>Edit @{{ teamFacility.name }}</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateTeamFacility"></spark-error-alert>

                    <!-- Update Facility Form -->
                    <form class="form-horizontal" role="form">

                        <spark-select :display="'Facility Type'"
                                      :form="forms.updateTeamFacility"
                                      :name="'type'"
                                      :input.sync="forms.updateTeamFacility.type">
                        </spark-select>
                        
                        <spark-select :display="'Location'"
                                      :form="forms.updateTeamFacility"
                                      :name="'location_id'"
                                      :items="locations"
                                      :input.sync="forms.updateTeamFacility.lcoation_id">
                        </spark-select>
                        
                        <spark-text :display="'Name'"
                            :form="forms.updateTeamFacility"
                            :name="'name'"
                            :input.sync="forms.updateTeamFacility.name">
                        </spark-text>

                        <spark-text :display="'Contact'"
                            :form="forms.updateTeamFacility"
                            :name="'contact'"
                            :input.sync="forms.updateTeamFacility.contact">
                        </spark-text>

                        <spark-text :display="'Phone'"
                            :form="forms.updateTeamFacility"
                            :name="'phonenumber'"
                            :input.sync="forms.updateTeamFacility.phonenumber">
                        </spark-text>

                        <spark-text :display="'Address'"
                            :form="forms.updateTeamFacility"
                            :name="'address'"
                            :input.sync="forms.updateTeamFacility.address">
                        </spark-text>

                        <spark-text :display="'Email'"
                            :form="forms.updateTeamFacility"
                            :name="'email'"
                            :input.sync="forms.updateTeamFacility.email">
                        </spark-text>

                        <spark-text :display="'Longitude'"
                            :form="forms.updateTeamFacility"
                            :name="'longitude'"
                            :input.sync="forms.updateTeamFacility.longitude">
                        </spark-text>

                        <spark-text :display="'Latitude'"
                            :form="forms.updateTeamFacility"
                            :name="'latitude'"
                            :input.sync="forms.updateTeamFacility.latitude">
                        </spark-text>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateTeamFacility"
                            :disabled="forms.updateTeamFacility.busy">
                        <span v-if="forms.updateTeamFacility.busy">
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
</spark-team-settings-edit-team-facility-screen>

<spark-team-settings-add-team-facility-screen :team="team" :facility-types="facilityTypes" inline-template>
    <div class="modal fade" id="modal-add-team-facility" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Facility</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addTeamFacility"></spark-error-alert>

                    <!-- Add Facility Form -->
                    <form class="form-horizontal" role="form">                        
                                                
                        <spark-select :display="'Facility Type'"
                                      :form="forms.addTeamFacility"
                                      :name="'type'"
                                      :items="types"
                                      :input.sync="forms.addTeamFacility.type">
                        </spark-select>
                        
                        <spark-location-select :display="'Location'"
                                      :form="forms.addTeamFacility"
                                      :name="'location_id'"
                                      :team-id="team.id"
                                      :input.sync="forms.addTeamFacility.location_id">
                        </spark-location-select>
                                              
                        <spark-text :display="'Name'"
                            :form="forms.addTeamFacility"
                            :name="'name'"
                            :input.sync="forms.addTeamFacility.name">
                        </spark-text>

                        <spark-text :display="'Contact Person'"
                            :form="forms.addTeamFacility"
                            :name="'contact'"
                            :input.sync="forms.addTeamFacility.contact">
                        </spark-text>

                        <spark-text :display="'Phone'"
                            :form="forms.addTeamFacility"
                            :name="'phonenumber'"
                            :input.sync="forms.addTeamFacility.phonenumber">
                        </spark-text>

                        <spark-text :display="'Address'"
                            :form="forms.addTeamFacility"
                            :name="'address'"
                            :input.sync="forms.addTeamFacility.address">
                        </spark-text>

                        <spark-text :display="'Email'"
                            :form="forms.addTeamFacility"
                            :name="'email'"
                            :input.sync="forms.addTeamFacility.email">
                        </spark-text>

                        <spark-text :display="'Longitude'"
                            :form="forms.addTeamFacility"
                            :name="'longitude'"
                            :input.sync="forms.addTeamFacility.longitude">
                        </spark-text>

                        <spark-text :display="'Latitude'"
                            :form="forms.addTeamFacility"
                            :name="'latitude'"
                            :input.sync="forms.addTeamFacility.latitude">
                        </spark-text>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addTeamFacility"
                            :disabled="forms.addTeamFacility.busy">
                        <span v-if="forms.addTeamFacility.busy">
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
</spark-team-settings-add-team-facility-screen>

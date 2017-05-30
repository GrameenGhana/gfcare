<spark-team-settings-add-team-location-screen :team="team" :location-types="locationTypes" inline-template>
    <div class="modal fade" id="modal-add-team-location" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Location</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addTeamLocation"></spark-error-alert>

                    <!-- Add Location Form -->
                    <form class="form-horizontal" role="form">
                       <spark-hidden 
                            :form="forms.addTeamLocation"
                            :name="'level'"
                            :input.sync="forms.addTeamLocation.level">
                        </spark-hidden>
                        
                        <spark-select :display="'Location Type'"
                                      :form="forms.addTeamLocation"
                                      :name="'type'"
                                      :items="types"
                                      :input.sync="forms.addTeamLocation.type">
                        </spark-select>
                        
                        <spark-select :display="'Parent'"
                                      :form="forms.addTeamLocation"
                                      :name="'parent_id'"
                                      :items="parents"
                                      :input.sync="forms.addTeamLocation.parent_id">
                        </spark-select>
                        
                        <spark-text :display="'Name'"
                            :form="forms.addTeamLocation"
                            :name="'name'"
                            :input.sync="forms.addTeamLocation.name">
                        </spark-text>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addTeamLocation"
                            :disabled="forms.addTeamLocation.busy">
                        <span v-if="forms.addTeamLocation.busy">
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
</spark-team-settings-add-team-location-screen>

<div class="modal fade" id="modal-add-program" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Program</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addProgram"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                    
                        <spark-text :display="'Name'"
                            :form="forms.addProgram"
                            :name="'name'"
                            :input.sync="forms.addProgram.name">
                        </spark-text>

                        <spark-select :display="'Campaign'"
                              :form="forms.addProgram"
                              :name="campaign"
                              :items="campaignOptions"
                              :input.sync="forms.addProgram.campaign">
                        </spark-select>
                    
                          <spark-select :display="'Channel'"
                                                   :form="forms.addProgram"
                                                   :name="'channel'"
                                                   :items="channelOptions"
                                                   :input.sync="forms.addProgram.channel">
                        </spark-select>

                         <spark-text :display="'Start Week'"
                            :form="forms.addProgram"
                            :name="'start_week'"
                            :input.sync="forms.addProgram.start_week">
                        </spark-text>

                        <spark-text :display="'End Week'"
                            :form="forms.addProgram"
                            :name="'end_week'"
                            :input.sync="forms.addProgram.end_week">
                        </spark-text>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewProgram"
                            :disabled="forms.addProgram.busy">
                        <span v-if="forms.addProgram.busy">
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


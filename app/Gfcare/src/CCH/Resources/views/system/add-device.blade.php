    <div class="modal fade" id="modal-add-device" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add Device</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.addDevice"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Type'"
                            :form="forms.addDevice"
                            :name="'type'"
                            :input.sync="forms.addDevice.type">
                        </spark-text>
                        
                        <spark-text :display="'Tag'"
                            :form="forms.addDevice"
                            :name="'tag'"
                            :input.sync="forms.addDevice.tag">
                        </spark-text>
                        
                        <spark-text :display="'Color'"
                            :form="forms.addDevice"
                            :name="'color'"
                            :input.sync="forms.addDevice.color">
                        </spark-text>
                        
                        <spark-text :display="'IMEI'"
                            :form="forms.addDevice"
                            :name="'imei'"
                            :input.sync="forms.addDevice.imei">
                        </spark-text>
                    
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewDevice"
                            :disabled="forms.addDevice.busy">
                        <span v-if="forms.addDevice.busy">
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
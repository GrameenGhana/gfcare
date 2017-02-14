    <div class="modal fade" id="modal-edit-device" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Edit Device</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateDevice"></spark-error-alert>

                    <!-- Add Location Form -->
                    <form class="form-horizontal" role="form">                        
                        <spark-text :display="'Type'"
                            :form="forms.updateDevice"
                            :name="'type'"
                            :input.sync="forms.updateDevice.type">
                        </spark-text>
                        
                        <spark-text :display="'Tag'"
                            :form="forms.updateDevice"
                            :name="'tag'"
                            :input.sync="forms.updateDevice.tag">
                        </spark-text>
                        
                        <spark-text :display="'Color'"
                            :form="forms.updateDevice"
                            :name="'color'"
                            :input.sync="forms.updateDevice.color">
                        </spark-text>
                        
                        <spark-text :display="'IMEI'"
                            :form="forms.updateDevice"
                            :name="'imei'"
                            :input.sync="forms.updateDevice.imei">
                        </spark-text>
                        
                        <spark-select :display="'Status'"
                                       :form="forms.updateDevice"
                                       :name="'statis'"
                                       :items="deviceStatusOptions"
                                       :input.sync="forms.updateDevice.status">
                        </spark-select>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateDevice"
                            :disabled="forms.updateDevice.busy">
                        <span v-if="forms.updateDevice.busy">
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
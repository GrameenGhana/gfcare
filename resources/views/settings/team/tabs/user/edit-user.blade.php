    <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Edit User</h4>
                </div>

                <div class="modal-body">
                    <spark-error-alert :form="forms.updateUser"></spark-error-alert>

                    <!-- Add Location Form -->
                    <form class="form-horizontal" role="form">                        
                                            <div class="row">
                            <div class="col-md-5">
                                   <spark-text :display="'Name*'"
                                        :form="forms.updateUser"
                                        :name="'name'"
                                        :input.sync="forms.updateUser.name">
                                    </spark-text>
                                    
                                    <spark-text :display="'Phone'"
                                        :form="forms.updateUser"
                                        :name="'phone_number'"
                                        :input.sync="forms.updateUser.phone_number">
                                    </spark-text>

                                   <!-- <spark-select :display="'Gender*'"
                                                   :form="forms.updateUser"
                                                   :name="'gender'"
                                                   :items="genderOptions"
                                                   :input.sync="forms.updateUser.gender">
                                    </spark-select> --> 

                                    <!--<spark-email :display="'Email*'"
                                        :form="forms.updateUser"
                                        :name="'email'"
                                        :input.sync="forms.updateUser.email">
                                    </spark-email> -->

                                    <spark-password :display="'Password*'"
                                        :form="forms.updateUser"
                                        :name="'password'"
                                        :input.sync="forms.updateUser.password">
                                    </spark-password>

                                    <spark-select :display="'Status*'"
                                                   :form="forms.updateUser"
                                                   :name="'status'"
                                                   :items="statusOptions"
                                                   :input.sync="forms.updateUser.status">
                                    </spark-select>
                            </div>
                            <div class="col-md-7">
                                    <spark-text :display="'Title*'"
                                        :form="forms.updateUser"
                                        :name="'title'"
                                        :input.sync="forms.updateUser.title">
                                    </spark-text>

                                    <spark-select :display="'Is CHN?'"
                                                   :form="forms.updateUser"
                                                   :name="'ischn'"
                                                   :items="yesNoOptions"
                                                   :input.sync="forms.updateUser.ischn">
                                    </spark-select>
                                    
                                    <spark-select :display="'Device'"
                                                   :form="forms.updateUser"
                                                   :name="'device'"
                                                   :items="deviceOptions"
                                                   :placetext="'Select Device'"
                                                   :input.sync="forms.updateUser.device">
                                    </spark-select>

                                    <spark-select :display="'Primary Facility*'"
                                                   :form="forms.updateUser"
                                                   :name="'primary_facility'"
                                                   :items="facOptions"
                                                   :input.sync="forms.updateUser.primary_facility">
                                    </spark-select>
                                    
                                    <spark-multi-select :display="'Supervised Facilities'"
                                                   :form="forms.updateUser"
                                                   :name="'supervised_facility'"
                                                   :items="facilities"
                                                   :fieldlabel="'name'",
                                                   :placetext="'Select facilities'",
                                                   :input.sync="forms.updateUser.supervised_facility">
                                    </spark-multi-select>
                   
                            </div>
                        </div>                   
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="updateUser"
                            :disabled="forms.updateUser.busy">
                        <span v-if="forms.updateUser.busy">
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

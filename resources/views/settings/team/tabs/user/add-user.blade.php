    <div class="modal fade" id="modal-add-user" tabindex="-1" role="dialog" style="margin:auto; width: 760px">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-btn fa-plus"></i>Add User</h4>
                </div>

                <div class="modal-body">

                    <spark-error-alert :form="forms.addUser"></spark-error-alert>

                    <!-- Add Form -->
                    <form class="form-horizontal" role="form" >  
                       
                        <div class="row">
                            <div class="col-md-5">
                                   <spark-text :display="'Name*'"
                                        :form="forms.addUser"
                                        :name="'name'"
                                        :input.sync="forms.addUser.name">
                                    </spark-text>
                                    
                                    <spark-text :display="'Phone'"
                                        :form="forms.addUser"
                                        :name="'phone_number'"
                                        :input.sync="forms.addUser.phone_number">
                                    </spark-text>

                                    <spark-select :display="'Gender*'"
                                                   :form="forms.addUser"
                                                   :name="'gender'"
                                                   :items="genderOptions"
                                                   :input.sync="forms.addUser.gender">
                                    </spark-select>  

                                    <spark-email :display="'Email*'"
                                        :form="forms.addUser"
                                        :name="'email'"
                                        :input.sync="forms.addUser.email">
                                    </spark-email>

                                    <spark-password :display="'Password*'"
                                        :form="forms.addUser"
                                        :name="'password'"
                                        :input.sync="forms.addUser.password">
                                    </spark-password>

                                    <spark-select :display="'Status*'"
                                                   :form="forms.addUser"
                                                   :name="'status'"
                                                   :items="statusOptions"
                                                   :input.sync="forms.addUser.status">
                                    </spark-select>
                            </div>
                            <div class="col-md-7">
                                    <spark-text :display="'Title*'"
                                        :form="forms.addUser"
                                        :name="'title'"
                                        :input.sync="forms.addUser.title">
                                    </spark-text>

                                    <spark-select :display="'Is CHN?'"
                                                   :form="forms.addUser"
                                                   :name="'ischn'"
                                                   :items="yesNoOptions"
                                                   :input.sync="forms.addUser.ischn">
                                    </spark-select>
                                    
                                    <spark-select :display="'Device'"
                                                   :form="forms.addUser"
                                                   :name="'device'"
                                                   :items="deviceOptions"
                                                   :placetext="'Select Device'"
                                                   :input.sync="forms.addUser.device">
                                    </spark-select>


                                    <spark-select :display="'Primary Facility*'"
                                                   :form="forms.addUser"
                                                   :name="'primary_facility'"
                                                   :items="facOptions"
                                                   :input.sync="forms.addUser.primary_facility">
                                    </spark-select>
                                    <spark-multi-select :display="'Supervised Facilities'"
                                                   :form="forms.addUser"
                                                   :name="'supervised_facility'"
                                                   :items="facilities"
                                                   :fieldlabel="'name'",
                                                   :placetext="'Select facilities'",
                                                   :input.sync="forms.addUser.supervised_facility">
                                    </spark-multi-select>
                                    
                                  
                   
                            </div>
                        </div>                     
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" @click.prevent="addNewUser"
                            :disabled="forms.addUser.busy">
                        <span v-if="forms.addUser.busy">
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

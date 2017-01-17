<gfcare-cch-system-screen inline-template>

    <!-- Devices -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Devices
            <button class="btn btn-default pull-right" @click.prevent="addDevice()">
                <i class="fa fa-btn fa-plus"></i>Add Device
            </button> 
        </div>

        <div class="panel-body" v-if="user && roles.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Tag</th>
                        <th>Color</th>
                        <th>IMEI</th>
                        <th>Status</th>
                        <th>User</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="device in devices">

                        <td class="spark-table-pad">@{{ device.type }}</td>
                        <td class="spark-table-pad">@{{ device.tag }}</td>
                        <td class="spark-table-pad">@{{ device.color }}</td>
                        <td class="spark-table-pad">@{{ device.imei }}</td>
                        <td class="spark-table-pad">@{{ device.status | device_status }}</td>
                        <td class="spark-table-pad">@{{ device.user_id | device_owner }}</td>

                        <td class="spark-table-pad">

                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeDevice(device)" :disabled="removingDevice(device.id)">
                                <span v-if="removingDevice(device.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editDevice(device)">
                                    <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No devices found.
        </div>
    </div>
    
    @include('CCH::system.add-device')
    @include('CCH::system.edit-device')

</gfcare-cch-system-screen>

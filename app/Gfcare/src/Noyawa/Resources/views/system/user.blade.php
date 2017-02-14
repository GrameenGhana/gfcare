<gfcare-noyawa-system-user-screen :team-id="{{ $team->id }}" inline-template>

    <!-- Users -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Users
            <button class="btn btn-default pull-right" @click.prevent="addUser()">
                <i class="fa fa-btn fa-plus"></i>Add User
            </button> 
        </div>

        <div class="panel-body" v-if="moduleUsers().length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Role</th>
                        <th>Primary Facility</th>
                        <th>Supervised Facilities</th>
                        <th>Devices (IMEI)</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in moduleUsers()">

                        <td class="spark-table-pad"> @{{ u.name }} </td>
                        <td class="spark-table-pad"> @{{ u.info.title }} </td>
                        <td class="spark-table-pad"> @{{ u.role }} </td>
                        <td class="spark-table-pad"> @{{ u | user_details_facilities }} </td>
                        <td class="spark-table-pad"> @{{ u | user_details_supervised }} </td>
                        <td class="spark-table-pad"> @{{ u | user_details_devices }} </td>
                        <td class="spark-table-pad"> @{{ u.info.status }} </td>

                        <td class="spark-table-pad">
                             <button class="btn btn-warning btn-xs btn-circle" @click.prevent="editUser(u)">
                                <i class="fa fa-pencil"></i></button>
                            
                            <button class="btn btn-danger btn-xs btn-cirlce" @click.prevent="removeUser(u)" :disabled="removingUser(u.id)">
                                <span v-if="removingUser(u.id)">
                                    <i class="fa fafa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No users found.
        </div>
    </div>
    
    @include('Noyawa::system.add-user')
    @include('Noyawa::system.edit-user')

</gfcare-noyawa-system-user-screen>

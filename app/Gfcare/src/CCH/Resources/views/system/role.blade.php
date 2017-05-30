<gfcare-cch-system-role-screen inline-template>

    <!-- Roles -->
    <div class="panel panel-default">
        <div class="panel-heading">
            User Roles
            <button class="btn btn-default pull-right" @click.prevent="addRole()">
                <i class="fa fa-btn fa-plus"></i>Add Role
            </button> 
        </div>

        <div class="panel-body" v-if="roles.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Can edit content</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles">

                        <td class="spark-table-pad">
                            @{{ role.name }}
                        </td>

                        <td class="spark-table-pad">
                            @{{ role.is_editor | role_is_editor }}
                        </td>

                        <td class="spark-table-pad">

                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeRole(role)" :disabled="removingRole(role.id)">
                                <span v-if="removingRole(role.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editRole(role)">
                                    <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No roles found.
        </div>
    </div>
    
    @include('CCH::system.add-role')
    @include('CCH::system.edit-role')

</gfcare-cch-system-role-screen>

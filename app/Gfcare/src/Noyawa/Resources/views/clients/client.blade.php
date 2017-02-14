<gfcare-noyawa-client-screen inline-template>

    <!-- Clients -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Clients
            <button class="btn btn-default pull-right" @click.prevent="addClient()">
                <i class="fa fa-btn fa-plus"></i>Add Client
            </button> 
        </div>

        <div class="panel-body" v-if="clients.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Volunteer</th>
                        <th>Registered</th>
                        <th>Registration Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clients">

                        <td class="spark-table-pad">@{{ client.name }}</td>
                        <td class="spark-table-pad">@{{ client.volunteer_name }}</td>
                        <td class="spark-table-pad">@{{ client.registered | registration_status }}</td>
                        <td class="spark-table-pad">@{{ client | registration_date_status }}</td>

                        <td class="spark-table-pad">

                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeClient(client)" :disabled="removingClient(client.id)">
                                <span v-if="removingClient(client.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editClient(client)">
                                    <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No clients found.
        </div>
    </div>
    
    @include('Noyawa::clients.add-client')
    @include('Noyawa::clients.edit-client')

</gfcare-noyawa-client-screen>

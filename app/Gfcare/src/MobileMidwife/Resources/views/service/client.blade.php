<gfcare-mm-client-screen inline-template>

    <!-- Clients -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Clients
           <!-- <button class="btn btn-default pull-right" @click.prevent="addClient()">
                <i class="fa fa-btn fa-plus"></i>Add Client
            </button> -->
        </div>

        <div class="panel-body" v-if="clients.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Start Week</th>
                        <th>Registered</th>
                        <th>Registration Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clients">

                        <td class="spark-table-pad">@{{ client.name }}</td>
                        <td class="spark-table-pad">@{{ client.start_week }}</td>
                        <td class="spark-table-pad">Registered</td>
                        <td class="spark-table-pad">@{{ client.created_at}}</td>

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
    
    @include('MobileMidwife::service.add-client')
    @include('MobileMidwife::service.edit-client')

</gfcare-mm-client-screen>

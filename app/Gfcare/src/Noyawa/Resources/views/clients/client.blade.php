<gfcare-noyawa-client-screen inline-template>

    <!-- Clients -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Clients
        </div>

        <div class="panel-body" v-if="clients.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Phone Number</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clients">

                        <td class="spark-table-pad">@{{ client.firstname }}  @{{ client.lastname }}</td>
                        <td class="spark-table-pad">@{{ client.DOB }}</td>
                        <td class="spark-table-pad">@{{ client.phonenumber}}</td>
                        <td class="spark-table-pad"></td>

                        <td class="spark-table-pad">

                           
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No clients found.
        </div>
    </div>
    
   

</gfcare-noyawa-client-screen>

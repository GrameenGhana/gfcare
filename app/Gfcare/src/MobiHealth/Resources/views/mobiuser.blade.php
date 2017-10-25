<gfcare-mobi-app-user-screen inline-template>


    <div class="panel panel-default">
        <div class="panel-heading">
            Digitunza Communtiy
        </div>

        <div class="panel-body" v-if="communityusers.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Phone Number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in communityusers">
                        <td class="spark-table-pad">@{{ u.firstname }} @{{ u.lastname }}</td>
                        <td class="spark-table-pad">@{{ u.DOB }}</td>
                        <td class="spark-table-pad">@{{ u.phonenumber }}</td>
                        <td class="spark-table-pad"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No Tunza Users Available
        </div>
    </div>


</gfcare-mobi-app-user-screen>

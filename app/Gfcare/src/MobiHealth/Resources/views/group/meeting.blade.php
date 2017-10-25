<gfcare-mobi-meeting-screen inline-template>


    <div class="panel panel-default">
        <div class="panel-heading">
            Meetings 
        </div>

        <div class="panel-body" v-if="meetings.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Topic</th>
                        <th>Organised By</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in meetings">
                        <td class="spark-table-pad">@{{ u.name}}</td>
                        <td class="spark-table-pad">@{{ u.topic}}</td>
                        <td class="spark-table-pad">@{{ u.organised_by }}</td>
                        <td class="spark-table-pad"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No Meetings  Available
        </div>
    </div>


</gfcare-mobi-meeting-screen>

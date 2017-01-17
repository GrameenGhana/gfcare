<gfcare-mobi-content-screen inline-template>

    <!-- First year -->
    <div class="panel panel-default">
        <div class="panel-heading">
            First Year of Life Messages
        </div>

        <div class="panel-body" v-if="user && firstyear_files.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Week</th>
                        <th>File</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="file in firstyear_files">
                        <td class="spark-table-pad">@{{ file.name }}</td>
                        <td class="spark-table-pad">Week @{{ file.week }}</td>
                        <td class="spark-table-pad">@{{ file.file_url }}</td>

                        <td class="spark-table-pad">
                           
                             <button class="btn btn-warning btn-circle" @click.prevent="editFirstYearFile(file)">
                                 <i class="fa fa-pencil"></i>
                            </button>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No first year files found.
        </div>
    </div>
         
    @include('MobiHealth::content.edit-firstyear')
    
</gfcare-mobi-content-screen>

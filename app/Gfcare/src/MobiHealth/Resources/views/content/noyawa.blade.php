<gfcare-mobi-content-screen inline-template>

    <!-- Pregnancy -->
    <div class="panel panel-default">
        <div class="panel-heading">
            NoYawa Messages
        </div>

        <div class="panel-body" v-if="user && noyawa_files.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Series</th>
                        <th>Name</th>
                        <th>Week</th>
                        <th>File</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="file in noyawa_files">
                        <td class="spark-table-pad">@{{ file.series }}</td>
                        <td class="spark-table-pad">@{{ file.name }}</td>
                        <td class="spark-table-pad">Week @{{ file.week }}</td>
                        <td class="spark-table-pad">@{{ file.file_url }}</td>

                        <td class="spark-table-pad">
                           
                             <button class="btn btn-warning btn-circle" @click.prevent="editNoyawaFile(file)">
                                 <i class="fa fa-pencil"></i>
                            </button>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No noyawa files found.
        </div>
    </div>
         
    @include('MobiHealth::content.edit-noyawa')
    
</gfcare-mobi-content-screen>

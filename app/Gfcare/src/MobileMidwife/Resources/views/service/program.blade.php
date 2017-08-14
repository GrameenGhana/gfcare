<gfcare-mm-program-screen inline-template>

    <!-- Programs -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Programs
            <button class="btn btn-default pull-right" @click.prevent="addProgram()">
                <i class="fa fa-btn fa-plus"></i>Add Program
            </button> 
        </div>

        <div class="panel-body" v-if="programs.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Channel</th>
                        <th>Start Week</th>
                        <th>End Week</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="program in programs">

                        <td class="spark-table-pad">@{{ program.name }}</td>
                        <td class="spark-table-pad">@{{ program.channels }}</td>
                        <td class="spark-table-pad">@{{ program.start_week }}</td>
                        <td class="spark-table-pad">@{{ program.end_week }}</td>

                        <td class="spark-table-pad">

                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeProgram(program)" :disabled="removingProgram(program.id)">
                                <span v-if="removingProgram(program.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editProgram(program)">
                                    <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No programs found.
        </div>
    </div>
    
    @include('MobileMidwife::service.add-program')
   

</gfcare-mm-campaign-screen>

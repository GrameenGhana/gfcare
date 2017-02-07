<gfcare-cch-content-poc-subsection-screen inline-template>

    <!-- Sub Sections -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Sub Sections
            <button class="btn btn-default pull-right" @click.prevent="addSubSection()">
                <i class="fa fa-btn fa-plus"></i>Add Sub Section
            </button> 
        </div>

        <div class="panel-body" v-if="subsections.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Section</th>
                        <th>Sub Section</th>
                        <th># Topics</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subsection in subsections">

                        <td class="spark-table-pad">@{{ subsection.icon_url }}</td>
                        <td class="spark-table-pad">@{{ subsection.section }}</td>
                        <td class="spark-table-pad">@{{ subsection.name }}</td>
                        <td class="spark-table-pad">@{{ subsection.topics.length}}</td>
                        <td class="spark-table-pad">
                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeSubSection(subsection)" :disabled="removingSubSection(subsection.id)">
                                <span v-if="removingSubSection(subsection.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>
                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editSubSection(subsection)"> <i class="fa fa-pencil"></i> 
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No sub sections found.
        </div>
    </div>
    
        
    
</gfcare-cch-content-poc-subsection-screen>

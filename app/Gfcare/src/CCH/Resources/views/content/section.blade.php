<gfcare-cch-content-screen inline-template>

    <!-- Sections -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Sections
            <button class="btn btn-default pull-right" @click.prevent="addSection()">
                <i class="fa fa-btn fa-plus"></i>Add Section
            </button> 
        </div>

        <div class="panel-body" v-if="user && sections.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sub Section</th>
                        <th>Upload Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="section in sections">

                        <td class="spark-table-pad">@{{ section.name }}</td>
                        <td class="spark-table-pad">@{{ section.sub_section}}</td>
                        <td class="spark-table-pad">
                            <div v-if="section.upload_status=='Uploaded'">
                                Uploaded
                            </div>
                            <div v-else>
                                <button class="btn btn-success btn-circle" style="margin-right: 10px"      @click.prevent="editSection(section)"> <i class="fa fa-upload"></i> 
                                </button>
                            </div>
                        </td>
                        <td class="spark-table-pad">
                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeSection(section)" :disabled="removingSection(section.id)">
                                <span v-if="removingSection(section.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>
                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editSection(section)"> <i class="fa fa-pencil"></i> 
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No sections found.
        </div>
    </div>
    
        
    @include('CCH::content.add-section')
    @include('CCH::content.edit-section')
    
</gfcare-cch-content-screen>

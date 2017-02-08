<gfcare-cch-content-references-screen inline-template>

    <!-- Roles -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Learning Center References
            <button class="btn btn-default pull-right" @click.prevent="addReference()">
                <i class="fa fa-btn fa-plus"></i>Add Reference
            </button> 
        </div>

        <div class="panel-body" v-if="references.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Size</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="lcr in references">
                        <td class="spark-table-pad">@{{ lcr.reference_desc}}</td>
                        <td class="spark-table-pad">@{{ lcr.size }}</td>
                        <td class="spark-table-pad">
                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeReference(lcr)" :disabled="removingReference(lcr.id)">
                                <span v-if="removingReference(lcr.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else> <i class="fa fa-trash-o"></i> </span>
                            </button>
                            
                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editReference(lcr)"> <i class="fa fa-pencil"></i> 
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No references found.
        </div>
    </div>
    
    @include('CCH::content.add-reference')
    @include('CCH::content.edit-reference')


</gfcare-cch-content-references-screen>

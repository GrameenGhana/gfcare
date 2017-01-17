<gfcare-cch-content-screen inline-template>

    <!-- Pages -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Pages
            
            <button class="btn btn-default pull-right" @click.prevent="addPage()">
                <i class="fa fa-btn fa-plus"></i>Add Page
            </button> 
        </div>

        <div class="panel-body" v-if="user && pages.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="page in pages">
                        <td class="spark-table-pad">@{{ page.section }}</td>
                        <td class="spark-table-pad">@{{ page.type }}</td>
                        <td class="spark-table-pad">@{{ page.name }}</td>
                        <td class="spark-table-pad">@{{ page.subtitle }}</td>

                        <td class="spark-table-pad">
                           
                             <button class="btn btn-warning btn-circle btn-xs" @click.prevent="editPage(page)">
                                 <i class="fa fa-pencil"></i>
                            </button>
                            
                            <button class="btn btn-danger btn-circle pull-right btn-xs" @click.prevent="removePage(page)" :disabled="removingPage(page.id)">
                                <span v-if="removingPage(page.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No pages found.
        </div>
    </div>
         
    @include('CCH::content.add-page')
    @include('CCH::content.edit-page')
    
</gfcare-cch-content-screen>
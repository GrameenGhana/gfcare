<gfcare-mobi-content-screen inline-template>

    <!-- Visual Aids -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Visual Aids 
            <button class="btn btn-default pull-right" @click.prevent="addVisual()">
                <i class="fa fa-btn fa-plus"></i>Add Visual Aid
            </button> 
        </div>

        <div class="panel-body" v-if="user && visuals.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="lcr in visuals">
                        <td class="spark-table-pad">@{{ lcr.reference_desc}}</td>
                        <td class="spark-table-pad">@{{ lcr.size }}</td>
                        <td class="spark-table-pad"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No visual aids found.
        </div>
    </div>
    
    @include('MobiHealth::content.add-visualaid')

</gfcare-mobi-content-screen>

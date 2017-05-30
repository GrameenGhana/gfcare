<gfcare-mobi-system-referral-screen inline-template>

    <!-- Referrals -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Referrals
            <button class="btn btn-default pull-right" @click.prevent="addReferral()">
                <i class="fa fa-btn fa-plus"></i>Add Referral
            </button> 
        </div>

        <div class="panel-body" v-if="referrals.length > 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Volunteer</th>
                        <th>Supervisor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="referral in referrals">

                        <td class="spark-table-pad">@{{ referral.volunteer_name  }}</td>
                        <td class="spark-table-pad">@{{ referral.supervisor_name  }}</td>

                        <td class="spark-table-pad">

                            <button class="btn btn-danger btn-circle pull-right" @click.prevent="removeReferral(referral)" :disabled="removingReferral(referral.id)">
                                <span v-if="removingReferral(referral.id)">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            </button>

                             <button class="btn btn-warning btn-circle pull-right" style="margin-right: 10px"  @click.prevent="editReferral(referral)">
                                    <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="panel-body">
            No referral mapping found.
        </div>
    </div>
    
    @include('MobiHealth::system.add-referral')
    @include('MobiHealth::system.edit-referral')

</gfcare-mobi-system-referral-screen>
